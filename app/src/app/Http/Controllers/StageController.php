<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\StageCell;
use Illuminate\Http\Request;

class StageController extends Controller
{
    public function index(Request $request)
    {

        //テーブルの全てのレコードを取得
        //$data = User::All();
        $data = Stage::simplePaginate(10);
        return view('stages/index', ['stages' => $data]);
    }

    public function create(Request $request){
        return view('stages/create');
    }

    public function store(Request $request)
    {
        // 1. stages の更新 or 作成
        $stage = Stage::updateOrCreate(
            [
                'chapter_num' => $request->chapter_num,
                'stage_num'   => $request->stage_num,
            ],
            [
                'score_criteria_is_time' => $request->boolean('score_criteria_is_time'),
                'reference_value_1'      => $request->reference_value_1,
                'reference_value_2'      => $request->reference_value_2,
                'reference_value_3'      => $request->reference_value_3,
                'shuffle_count'          => $request->shuffle_count,
            ]
        );

        // 2. 今回登録した Stage の ID を取得
        $stageId = $stage->id;

        // 3. セル情報の処理（フロントから配列で受け取る想定）
        // 例: $request->cells = [ ['x'=>0,'y'=>0,'piece_type'=>1,'collectible'=>null], ... ]
        $cells = json_decode($request->cells, true); // 配列に変換

        foreach ($cells as $cell) {
            StageCell::updateOrCreate(
                [
                    'stage_id' => $stageId,
                    'x'        => $cell['x'],
                    'y'        => $cell['y'],
                ],
                [
                    'piece_type'  => $cell['piece_type'] ?? null,
                    'collectibles' => $cell['collectibles'] ?? null,
                ]
            );
        }

        return redirect()
            ->route('stages.index')
            ->with('success', 'ステージを作成・更新しました。');
    }
    public function edit($id)
    {
        $stage = Stage::with('cells')->findOrFail($id); // cells リレーションは要定義

        return view('stages/create', [
            'stage' => $stage,   // create.blade.php に渡す
        ]);
    }

}
