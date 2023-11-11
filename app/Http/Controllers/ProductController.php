<?php

namespace App\Http\Controllers;

use Storage;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // direct product list page
    public function list() {
        $products = Product::when(request('searchKey'), function($query) {
                        $query->where('product_name', 'like', '%' . request('searchKey') . '%');
                    })
                    ->select('products.*', 'categories.category_name')
                    ->join('categories', 'products.category_id', 'categories.category_id')
                    ->orderBy('product_name', 'asc')->paginate(5);

        return view('admin.product.list', compact('products'));
    }

    // direct product create page
    public function createPage() {
        $categories = Category::select('category_id', 'category_name')->get();

        return view('admin.product.create', compact('categories'));
    }

    // create new product function
    public function create(Request $request) {
        $this->productValidation($request);

        $data = $this->getProductData($request);

        $fileName = uniqid() . $request->file('image')->getClientOriginalName();

        $request->file('image')->storeAs('public', $fileName);

        $data['image'] = $fileName;

        Product::create($data);

        return redirect()->route('product#list')->with(['createSuccess' => 'Added Successfully!']);
    }

    // delete product function
    public function delete($id, $image) {
        Storage::delete('public/' . $image);

        Product::where('product_id', $id)->delete();

        return redirect()->route('product#list')->with(['deleteSuccess' => 'Deleted Successfully!']);
    }

    // direct edit page
    public function editPage($id) {
        $product = Product::where('product_id', $id)->first();

        $categories = Category::select('category_id', 'category_name')->get();

        return view('admin.product.edit', compact(['product', 'categories']));
    }

    // product update function
    public function update(Request $request, $id) {
        $this->productValidation($request, $id);

        $data = $this->getProductData($request);

        $data['updated_at'] = Carbon::now();

        if($request->hasFile('image')) {
            $dbImage = Product::where('product_id', $id)->first();

            $dbImage = $dbImage->image;

            Storage::delete('public/' . $dbImage);

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();

            $request->file('image')->storeAs('public', $fileName);

            $data['image'] = $fileName;
        }

        Product::where('product_id', $id)->update($data);

        return redirect()->route('product#list')->with(['updateSuccess' => 'Updated Successfully!']);
    }

    // private functions
    // product validation function
    private function productValidation($request, $id="") {
        $validationRules = [
            'productName' => ['required', 'string', 'min:4', 'max:255', 'unique:products,product_name,' . $id . ',product_id'],
            'categoryName' => ['required'],
            'description' => ['required', 'string', 'min:10'],
            'image' => ['required', File::image()->max(2048)],
            'price' => ['required', 'integer'],
            'waitingTime' => ['required', 'integer']
        ];

        if (!empty($id)) {
            $validationRules['image'] = [File::image()->max(2048)];     // for update page
        }

        Validator::make($request->all(), $validationRules)->validate();
    }

    // get product data function
    private function getProductData($request) {
        return [
            'product_name' => $request->productName,
            'category_id' => $request->categoryName,
            'description' => $request->description,
            'price' => $request->price,
            'waiting_time' => $request->waitingTime
        ];
    }
}
