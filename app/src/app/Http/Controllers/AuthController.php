<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'min:4', 'max:20'],
            'password' => ['required']
        ]);
        $account = Account::where('name', '=', $request['name'])->get();
//        dd($request);
        if (!empty($account[0]->password) && hash::check($request['password'], $account[0]->password)) {
            return redirect('TOP/index');
        } else {
//            Debugbar::info('IDもしくはpassが間違っています');
            return view('auth/index', ['error_id' => $request->error_id]);

        }
    }

    public function index(Request $request)
    {
        return view('auth/index');
    }

}
