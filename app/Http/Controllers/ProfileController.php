<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function index() {
        $user = Auth::user();
        return view('Backend.Profile', ['user' => $user]);
    }

    public function updateProfile(Request $request) {
        $id = $request->input('id');
        $password = $request->input('password');
        $user = User::find($id);

        $validate = $request->validate([
            'name' => 'required|min:2'
        ]);

        if(strlen($password) > 0) {

            $validate = $request->validate([
                'password' => 'min:5'
            ]);

            if($user->email != $request->input('email')) {
                $validate = $request->validate([
                    'email' => 'required|unique:users,email'
                ]);
            } else {
                $validate = $request->validate([
                    'email' => 'required'
                ]);
            }

            if($user->phone != $request->input('phone')) {
                $validate = $request->validate([
                    'phone' => 'unique:users,phone|min:10'
                ]);
            } else {
                if($request->input('phone') != '') {
                    $validate = $request->validate([
                        'phone' => 'min:10'
                    ]);
                }
            }

            $validate = $request->validate([
                'name' => 'required|min:2',
                'password' => 'min:5'
            ]);

            $password = bcrypt($password);

            User::where('id', $request->input('id'))->update([
                "name" => $request->input('name'),
                "email" => $request->input('email'),
                "phone" => $request->input('phone'),
                "password" => $password
            ]);

            return Redirect::to('/profile');

        } else {
            if($user->email != $request->input('email')) {
                $validate = $request->validate([
                    'email' => 'required|unique:users,email'
                ]);
            } else {
                $validate = $request->validate([
                    'email' => 'required'
                ]);
            }

            if($user->phone != $request->input('phone')) {
                $validate = $request->validate([
                    'phone' => 'unique:users,phone|min:10'
                ]);
            } else {
                if($request->input('phone') != '') {
                    $validate = $request->validate([
                        'phone' => 'min:10'
                    ]);
                }
            }

            $validate = $request->validate([
                'name' => 'required|min:2'
            ]);

            User::where('id', $request->input('id'))->update([
                "name" => $request->input('name'),
                "email" => $request->input('email'),
                "phone" => $request->input('phone')
            ]);

            return Redirect::to('/profile');
        }
    }
}
