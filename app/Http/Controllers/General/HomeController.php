<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth:sanctum', [
            'except' => [],
        ]);
    }

    public function index()
    {
        return view("home.index");
    }

    public function profile()
    {
        return view("home.profile");
    }

    public function saveEdtprofile()
    {
        $message = [
            "name.required" => "Field name is required, cannot be empty!",
            "name.max" => "The length of field name is 255 and you can't input longer than 255!",
            "name.regex" => "Special Character for name is not allowed!",
            "email.required" => "Field email is required, cannot be empty!",
            "email.email" => "Please provide your valid email!",
            "email.unique" => "This email has been taken!",
            "password.required" => "Field password is required, cannot be empty!",
            "password.regex" => "Special Character for password is not allowed!",
            "confirm_pass.required" => "Field password confirmation is required, cannot be empty!",
            "confirm_pass.regex" => "Special Character for password confirmation is not allowed!",
            "confirm_pass.same" => "You have to match with your password!",
            "role_id.required" => "Role ID is required, you have to choose 1 from options!",
            "role_id.not_in" => "You have to choose Role other than this from options!",
            // "organization_id.not_in" => "You have to choose Organization other than this from options!",
        ];

        $rules = [
            "name" => "required|regex:/^[a-zA-Z0-9 ]+$/u|string|max:255",
            "email" => "required|email|max:255",
            "password" => "required|regex:/^[a-zA-Z0-9 ]+$/u|string",
            "confirm_pass" => "required|regex:/^[a-zA-Z0-9 ]+$/u|required_with:password|same:password",
            "role_id" => "required|not_in:0",
        ];
    }
}
