<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\UserItem;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $title = 'ユーザー一覧';
        //テーブルの全てのレコードを取得
        //$data = User::All();
        $data = User::simplePaginate(10);
        return view('users/index', ['title' => $title, 'users' => $data]);
    }

    public function show(Request $request)
    {
        $users = User::findOrFail($request->id);
//        $data = UserItem::select([
//            'user_items.id  as  id',
//            'items.id  as  item_id',
//            'items.name  as  item_name',
//            'amount'
//        ])
//            ->join('items', 'items.id', '=', 'user_items.item_id')
//            ->join('users', 'users.id', '=', 'user_items.user_id')
//            ->where('users.id', '=', $request->id)
//            ->get();
//        var_dump($users);
//        $data = User::simplePaginate(10);
        return view('users/show', ['users' => $users]);
    }

    public function items()
    {
        return $this->belongsToMany(
            Item::class, 'user_items', 'user_id', 'item_id')
            ->withPivot('amount');
    }

}
