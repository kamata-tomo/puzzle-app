<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\UserItem;
use Illuminate\Http\Request;

class UserItemController extends Controller
{
    public function index(Request $request)
    {
        $title = 'ユーザー所持アイテム一覧';
        //テーブルの全てのレコードを取得

        $users = User::All();


        return view('user_item/index', ['title' => $title, 'users' => $users]);
    }
}
