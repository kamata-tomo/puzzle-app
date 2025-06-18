<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\UserItem;
use Illuminate\Http\Request;

class UserItemController extends Controller
{
    public function index(Request $request)
    {
        $title = 'ユーザー所持アイテム一覧';
        //テーブルの全てのレコードを取得
        $data = UserItem::select([
            'user_items.id  as  id',
            'users.name  as  user_name',
            'items.name  as  item_name',
            'amount'
        ])
            ->join('users', 'users.id', '=', 'user_items.user_id')
            ->join('items', 'items.id', '=', 'user_items.item_id')
            ->get();

        return view('UserItem/index', ['title' => $title, 'UserItems' => $data]);
    }
}
