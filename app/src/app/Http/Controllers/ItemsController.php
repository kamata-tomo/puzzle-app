<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index(Request $request)
    {
        $title = 'アイテム一覧';
        //テーブルの全てのレコードを取得
        $data = Item::All();
        return view('Items/index', ['title' => $title, 'Items' => $data]);
    }
}
