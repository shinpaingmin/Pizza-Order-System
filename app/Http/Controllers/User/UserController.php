<?php

namespace App\Http\Controllers\User;

use Storage;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Contact;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    // direct user home page
    public function home() {
        $products = Product::orderBy('created_at', 'desc')->get();
        $categories = Category::orderBy('category_name', 'asc')->get();

        // find cart
        $cart = Cart::where('user_id', Auth::user()->id)->first();

        // initiate with empty cart items
        $cart_items = [];

        // if the cart exits, we will fill cart items into it
        if(!empty($cart)) {
            $cart_id = $cart->id;

            $cart_items = CartItem::where('cart_id', $cart_id)->get();
        }

        $avg_ratings = Rating::select('product_id', DB::raw('AVG(rating_count) as avg_rating'))
                            ->groupBy('product_id')
                            ->get();



        return view('user.main.home', compact(['products', 'categories', 'cart_items', 'avg_ratings']));
    }

    // direct change password page
    public function changePasswordPage() {
        // find cart
        $cart = Cart::where('user_id', Auth::user()->id)->first();

        // initiate with empty cart items
        $cart_items = [];

        // if the cart exits, we will fill cart items into it
        if(!empty($cart)) {
            $cart_id = $cart->id;

            $cart_items = CartItem::where('cart_id', $cart_id)->get();
        }
        return view('user.profile.changePassword', compact('cart_items'));
    }

    // change password function
    public function changePassword(Request $request) {
        $this->passwordValidation($request);

        $user = User::select('password')->where('id', Auth::user()->id)->first();

        $dbPassword = $user->password;

        if(Hash::check($request->oldPassword, $dbPassword))
        {
            $data = [
                'password' => Hash::make($request->newPassword),
                'updated_at' => Carbon::now()
            ];
            User::where('id', Auth::user()->id)->update($data);

            // Auth::logout();

            return redirect()->route('user#changePasswordPage')->with(['updateSuccess' => 'Updated Successfully!']);
        }

        return redirect()->route('user#changePasswordPage')->with(['notMatch' => 'The old password does not match.']);
    }

    // direct profile edit page
    public function editProfile() {
        // find cart
        $cart = Cart::where('user_id', Auth::user()->id)->first();

        // initiate with empty cart items
        $cart_items = [];

        // if the cart exits, we will fill cart items into it
        if(!empty($cart)) {
            $cart_id = $cart->id;

            $cart_items = CartItem::where('cart_id', $cart_id)->get();
        }
        return view('user.profile.edit', compact('cart_items'));
    }

    // update profile function
    public function updateProfile($id, Request $request) {
        $this->accountValidation($request, $id);
        $data = $this->getUserData($request);

        // for image
        if($request->hasFile('image')) {
            /*
                1. get old image name from db
                2. check => delete if the old image exists in local storage
                3. store new one in local storage
            */
            $dbImage = User::where('id', $id)->first();
            $dbImage = $dbImage->image;

            if(!empty($dbImage)) {
                Storage::delete('public/' . $dbImage);
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();    // unique filename
            $request->file('image')->storeAs('public', $fileName);  // store in local storage
            $data['image'] = $fileName;     // store in db
        }

        User::where('id', $id)->update($data);
        return redirect()->route('user#editProfilePage')->with(['updateSuccess' => 'Updated Successfully!']);
    }

    // filter pizza
    public function filter($categoryId) {
        $products = Product::where('category_id', $categoryId)->orderBy('created_at', 'desc')->get();
        $categories = Category::orderBy('category_name', 'asc')->get();

        $cart = Cart::where('user_id', Auth::user()->id)->first();

        $cart_items = [];

        if(!empty($cart)) {
            $cart_id = $cart->id;

            $cart_items = CartItem::where('cart_id', $cart_id)->get();
        }

        return view('user.main.home', compact(['products', 'categories', 'cart_items']));
    }

    // direct product detail page
    public function pizzaDetails($pizzaId) {
        $pizza = Product::where('id', $pizzaId)->first();
        $pizzaList = Product::get();

        $cart = Cart::where('user_id', Auth::user()->id)->first();

        $cart_items = [];

        if(!empty($cart)) {
            $cart_id = $cart->id;

            $cart_items = CartItem::where('cart_id', $cart_id)->get();
        }

        $ratings = Rating::select('ratings.*', 'users.username', 'users.image', 'users.gender')
                            ->join('users', 'ratings.user_id', 'users.id')
                            ->where('product_id', $pizzaId)
                            ->orderBy('created_at', 'desc')
                            ->paginate(2);


        $avg_ratings = Rating::select('product_id', DB::raw('AVG(rating_count) as avg_rating'))
        ->groupBy('product_id')
        ->get();


        return view('user.main.details', compact('pizza', 'pizzaList', 'cart_items', 'ratings', 'avg_ratings'));
    }

    // direct to cart list page
    public function cartList() {
        // find cart
        $cart = Cart::where('user_id', Auth::user()->id)->first();

        $cart_items = [];

        $subTotal = 0;

        if(!empty($cart)) {
            $cart_id = $cart->id;

            $cart_items = CartItem::select('cart_items.*', 'products.product_name', 'products.price', 'products.image')
                            ->join('products', 'cart_items.product_id', 'products.id')
                            ->where('cart_id', $cart_id)
                            ->get();



            foreach ($cart_items as $c) {
                $subTotal += $c->total_price;
            }
        }

        $order = Order::where('user_id', Auth::user()->id)
                ->where('status', 0)
                ->get();

        return view('user.main.cart', compact('cart_items', 'subTotal', 'order'));
    }

    // direct order history page
    public function history() {
        $orders = Order::select('orders.*', 'order_items.total_price', 'order_items.total_qty', 'products.*')
                ->join('order_items', 'orders.id', 'order_items.order_id')
                ->join('products', 'order_items.product_id', 'products.id')
                ->where('orders.user_id', Auth::user()->id)
                ->orderBy('orders.created_at', 'desc')
                ->paginate(5);

                // find cart
        $cart = Cart::where('user_id', Auth::user()->id)->first();

        // initiate with empty cart items
        $cart_items = [];

        // if the cart exits, we will fill cart items into it
        if(!empty($cart)) {
            $cart_id = $cart->id;

            $cart_items = CartItem::where('cart_id', $cart_id)->get();
        }

        return view('user.main.history', compact('orders', 'cart_items'));
    }

    // direct contact page
    public function contactPage() {
        $cart = Cart::where('user_id', Auth::user()->id)->first();

        // initiate with empty cart items
        $cart_items = [];

        // if the cart exits, we will fill cart items into it
        if(!empty($cart)) {
            $cart_id = $cart->id;

            $cart_items = CartItem::where('cart_id', $cart_id)->get();
        }
        return view('user.contact.contact', compact('cart_items'));
    }

    // contact function
    public function contact(Request $request) {
        $this->contactValidation($request);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message
        ];

        if(!empty(Auth::user()->id)) {
            $data['user_id'] = Auth::user()->id;
        }

        Contact::create($data);



        return redirect()->route('user#contactPage')->with(['createSuccess' => 'Sent Successfully!']);
    }

    // pizza review ajax function
    public function pizzaReview(Request $request) {
        logger($request->all());

        $existingRating = Rating::where('user_id', $request->userId)
                                    ->where('product_id', $request->pizzaId)
                                    ->first();

        if(!empty($existingRating)) {
            return response()->json([
                'message' => "You've already posted a review on this product."
            ], 422);
        }

        Rating::create([
            'user_id' => $request->userId,
            'product_id' => $request->pizzaId,
            'rating_count' => $request->stars,
            'message' => $request->review
        ]);

        return response()->json([
            'message' => 'Success'
        ], 200);
    }

    // private functions
    // contact form validation
    private function contactValidation($request) {
        Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'min:10', 'max:20'],
            'message' => ['required', 'string', 'min:10', 'max:500']
        ])->validate();
    }

    // password validation function
    private function passwordValidation($request) {
        Validator::make($request->all(), [
            'oldPassword' => ['required', Password::min(8)],
            'newPassword' => ['required', Password::min(8)->mixedCase()->numbers()->symbols(), 'different:oldPassword'],
            'confirmPassword' => ['required', 'same:newPassword']
        ])->validate();
    }

    // account validation
    private function accountValidation($request, $id="") {
        $validationRules =  [
            'name' => ['required'],
            'email' => ['required', 'unique:users,email,' . $id],
            'phone' => ['required', 'min_digits:9', 'max_digits:15'],
            'address' => ['required'],
            'gender' => ['required'],
            'image' => [File::image()->max(1024)]
        ];

        Validator::make($request->all(), $validationRules)->validate();
    }

    // request user data
    private function getUserData($request) {
        return [
            'username' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'updated_at' => Carbon::now()
        ];
    }
}
