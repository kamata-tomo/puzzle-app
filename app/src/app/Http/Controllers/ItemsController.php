<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index(Request $request)
    {
        $title = 'アイテム一覧';
        //テーブルの全てのレコードを取得
        $data = Item::All();
        return view('items/index', ['title' => $title, 'items' => $data]);
    }

    public function create(Request $request)
    {
        $errors = [];

        if (!empty($request['errors'])) {
            $error_code = $request['errors'];
            if (floor($error_code / 100) == 1) {
                $errors[] = '「アイテム名」は必須です。';
            }
            if (floor(($error_code % 100) / 10) == 1) {
                $errors[] = '「タイプ」は必要です。';
            }
            if (($error_code % 10) === 1) {
                $errors[] = '「説明」は必要です。';
            }

        }
        return view('items/create', ['errors' => $errors]);
    }

    public function store(Request $request)
    {
        $errors = 0;

        if (empty($request['name'])) {
            $errors += 100;
        }
        if (empty($request['type'])) {
            $errors += 10;
        }
        if (empty($request['flavor_text'])) {
            $errors += 1;
        }
        if (empty($errors)) {
            Item::create([
                'name' => $request['name'],
                'type' => $request['type'],
                'effect_value' => $request['effect_value'],
                'flavor_text' => $request['flavor_text']
            ]);
            return redirect()->route('item.result', [
                'name' => $request['name'],
                'title' => '登録完了'
            ]);
        } else {
            return redirect()->route('item.create', ['errors' => $errors]);
        }
    }

    public function edit(Request $request)
    {
        $errors = [];

        if (!empty($request['errors'])) {
            $error_code = $request['errors'];
            if (floor($error_code / 100) == 1) {
                $errors[] = '「アイテム名」は必須です。';
            }
            if (floor(($error_code % 100) / 10) == 1) {
                $errors[] = '「タイプ」は必要です。';
            }
            if (($error_code % 10) === 1) {
                $errors[] = '「説明」は必要です。';
            }

        }
        return view('items/edit', ['errors' => $errors, 'id' => $request['id']]);
    }

    public function update(Request $request)
    {
        $errors = 0;

        if (empty($request['name'])) {
            $errors += 100;
        }
        if (empty($request['type'])) {
            $errors += 10;
        }
        if (empty($request['flavor_text'])) {
            $errors += 1;
        }
        if (empty($errors)) {
            $item = Item::findOrFail($request->id);
            $item->name = $request['name'];
            $item->type = $request['type'];
            $item->effect_value = $request['effect_value'];
            $item->flavor_text = $request['flavor_text'];
            $item->save();
            return redirect()->route('item.result', [
                'name' => $request['name'],
                'title' => '編集完了'
            ]);
        } else {
            return redirect()->route('item.edit_redirect', ['id' => $request->id, 'errors' => $errors]);
        }
    }

    public function result(Request $request)
    {

        return view('items/result', ['name' => $request['name'], 'title' => $request['title']]);
    }

    public function destroy(Request $request)
    {
        $item = Item::findOrFail($request->id);
        if (!empty($request['submit']) && $request['submit'] == 'confirmed') {
            $item->delete();
            return redirect()->route('item.result', [
                'name' => $item['name'],
                'title' => '削除完了'
            ]);
        }

        return view('items/destroy', ['item' => $item]);
    }

    public function users()
    {
        return $this->belongsToMany(User::class,
            'user_items',
            'item_id',
            'user_id')->withPivot('amount');
    }

}
