<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Stage;
use App\Models\StageCell;
use App\Models\StageProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Monolog\Level;

class StageController extends Controller
{
    public function show_stages(Request $request)
    {
        $userId = $request->user()->id;

        // stagesをchapter_num, stage_num順に取得
        $stages = Stage::orderBy('chapter_num')
            ->orderBy('stage_num')
            ->get();

        // 進捗をまとめて取得（user_idで絞る）
        $progress = StageProgress::where('user_id', $userId)
            ->get()
            ->keyBy('stage_id'); // stage_idをキーにすると便利

        // レスポンス整形
        $result = $stages->map(function ($stage) use ($progress) {
            $p = $progress->get($stage->id);

            return [
                'stage_id'          => $stage->id,
                'chapter_num' => $stage->chapter_num,
                'stage_num'   => $stage->stage_num,
                'clear'       => $p ? true : false,
                'evaluation'  => $p ? $p->evaluation : null,
                'collectibles'=> $p ? $p->collectibles : null,
            ];
        });

        return response()->json($result);
    }

    public function  clear_stage(Request $request){
        $request->validate([
            'stage_id' => 'required|integer',
            'evaluation' => 'integer|min:0|max:3',
            'collectibles' => 'boolean'
        ]);

        $stage_progress = StageProgress::updateOrCreate([
            'user_id' => $request->user()->id,
            'stage_id' => $request->stage_id,
        ],[
            'evaluation' => $request->evaluation,
            'collectibles' => $request->collectibles,
        ]);
        return response()->json($stage_progress);
    }

    public function getCells(Request $request)
    {
        // バリデーション
        $request->validate([
            'stage_id' => 'required|integer',

        ]);

        // stage_cells を取得 (x → y の順に並び替え)
        $cells = StageCell::where('stage_id', $request->stage_id)
            ->orderBy('x')
            ->orderBy('y')
            ->get();

        if ($cells->isEmpty()) {   // ←ここを修正
            abort(400, 'StageCell が存在しません');
        }
        return response()->json($cells);
    }
}
