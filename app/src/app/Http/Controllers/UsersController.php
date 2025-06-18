<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $title = 'ユーザー一覧';
        //テーブルの全てのレコードを取得
        $data = User::All();
        return view('Users/index', ['title' => $title, 'Users' => $data]);
    }
}
