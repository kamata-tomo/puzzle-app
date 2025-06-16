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
        if (hash::check($request['password'], $account[0]->password)) {
            return redirect('accounts/index');
        } else {
//            Debugbar::info('IDもしくはpassが間違っています');
            return view('auth/index', ['error_id' => $request->error_id]);

        }
    }

    public function index(Request $request)
    {
        Debugbar::info('情報表示だよ');
        Debugbar::warning('警告だよ');
        Debugbar::error('エラーだよ');

        return view('auth/index');
    }

}
