<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
                'password' => Hash::make($request->newPassword)
            ];
            User::where('id', Auth::user()->id)->update($data);

            // Auth::logout();

            return redirect()->route('admin#changePasswordPage')->with(['updateSuccess' => 'Updated Successfully!']);
        }

        return redirect()->route('admin#changePasswordPage')->with(['notMatch' => 'The old password does not match.']);
    }

    // direct details page
    public function details() {
        return view('admin.profile.details');
    }

    // password validation function
    private function passwordValidation($request) {
        Validator::make($request->all(), [
            'oldPassword' => ['required', Password::min(8)],
            'newPassword' => ['required', Password::min(8)->mixedCase()->numbers()->symbols(), 'different:oldPassword'],
            'confirmPassword' => ['required', 'same:newPassword']
        ])->validate();
    }
}
