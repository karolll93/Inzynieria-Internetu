<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

    public function login(Request $request) {
        $error = '';
        $next = $request->get('next');
        $redirect = '';
        if ($request->isMethod('post')) {
            $username = $request->input('username');
            $password = $request->input('password');
            $redirect = $request->input('redirect');
            if ($username && $password) {
                $results = DB::select('select * from UZYTKOWNICY where login = :login limit 1', ['login' => $username]);
                if (count($results) > 0) {
                    $user = $results[0];
                    if (Hash::check($password, $user->haslo)) {
                        Auth::loginUsingId($user->id, true);
                        return redirect($redirect ? $redirect : route('home'));
                    }
                }
                $error = 'Zły login lub hasło!';
            } else {
                $error = 'Podaj login i hasło!';
            }
        }
        return view('login', ['error' => $error, 'redirect' => $redirect ? $redirect : $next ]);
    }

    public function logout() {
        Auth::logout();
        return redirect(route('home'));
    }

}