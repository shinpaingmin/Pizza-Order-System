<?php

namespace App\Http\Controllers;

use Storage;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    // change password page
    public function changePasswordPage() {
        return view('admin.profile.changePassword');
    }

    // change password function
    public function changePassword(Request $request) {
        /*
            1. all fields must be filled
            2. new password length must be greater than 6, mixed case letters, one number, one symbol
            3. old password & new password must be different
            4. new password & confirm password must be the same
            5. client old password must be the same with db password
            6. process succeed
        */
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

            return redirect()->route('admin#changePasswordPage')->with(['updateSuccess' => 'Updated Successfully!']);
        }

        return redirect()->route('admin#changePasswordPage')->with(['notMatch' => 'The old password does not match.']);
    }

    // direct profile details page
    public function details() {
        return view('admin.profile.details');
    }

    // direct profile edit page
    public function edit() {
        return view('admin.profile.edit');
    }

    // update profile info
    public function update(Request $request, $id) {
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
        return redirect()->route('admin#details')->with(['updateSuccess' => 'Updated Successfully!']);
    }

    // direct to admin list
    public function list() {
        $admins = User::when(request('searchKey'), function($query) {
                        $query->orWhere('username', 'like', '%' . request('searchKey') . '%')
                                ->orWhere('email', 'like', '%' . request('searchKey') . '%')
                                ->orWhere('gender', 'like', '%' . request('searchKey') . '%')
                                ->orWhere('phone', 'like', '%' . request('searchKey') . '%')
                                ->orWhere('address', 'like', '%' . request('searchKey') . '%');
                    })
                    ->where('role', 'admin')->paginate(5);

        return view('admin.list.list', compact('admins'));
    }

    // delete admin account
    public function delete($id) {
        User::where('id', $id)->delete();
        return redirect()->route('admin#list')->with(['deleteSuccess' => 'Deleted Successfully!']);
    }

    // demote to user function
    public function demote($id) {
        User::where('id', $id)->update([
            'role' => 'user'
        ]);

        return redirect()->route('admin#list')->with(['deleteSuccess' => 'Demoted Successfully!']);
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
    private function accountValidation($request, $id) {
        Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'unique:users,email,' . $id],
            'phone' => ['required', 'integer', 'min_digits:9', 'max_digits:15'],
            'address' => ['required'],
            'gender' => ['required'],
            'image' => [File::image()->max(1024)]
        ])->validate();
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
