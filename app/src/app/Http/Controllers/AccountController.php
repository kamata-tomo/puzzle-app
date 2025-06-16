<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Models\Account;


class AccountController extends Controller
{
    //アカウント一覧を表示する
    public function index(Request $request)
    {
        $title = 'アカウント一覧';

        $data = [
            [
                'id' => 1,
                'name' => 'jobi'

            ],
            [
                'id' => 2,
                'name' => 'test'
            ]
        ];
        //テーブルの全てのレコードを取得
        $accounts = Account::All();
//テーブルのレコード数を取得
        $count = Account::count();
//idで検索,見つからなかったら404エラー
        $account = Account::findOrFail(1);
//条件を指定して取得
        $account = Account::where('name', '=', 'jobi')->get();
//複数の条件を指定して取得
        $account = Account::where('name', '=', 'jobi')
            ->where('created_at', '>=', '2024-06-08')
            ->get();


        return view('accounts/index',
            ['title' => $title, 'accounts' => $data]);

    }

    public function score(Request $request)
    {
        $title = 'スコア一覧';

        $data = [
            [
                'id' => 1,
                'name' => 'jobi',
                'score' => 256
            ],
            [
                'id' => 2,
                'name' => 'test',
                'score' => 512
            ]
        ];
        //テーブルの全てのレコードを取得
        $accounts = Account::All();
//テーブルのレコード数を取得
        $count = Account::count();
//idで検索,見つからなかったら404エラー
        $account = Account::findOrFail(1);
//条件を指定して取得
        $account = Account::where('name', '=', 'jobi')->get();
//複数の条件を指定して取得
        $account = Account::where('name', '=', 'jobi')
            ->where('created_at', '>=', '2024-06-08')
            ->get();


        return view('score/index',
            ['title' => $title, 'accounts' => $data]);

    }


}

