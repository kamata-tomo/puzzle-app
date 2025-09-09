<?php

namespace App\Http\Controllers;


use App\Models\AcquisitionStatus;
use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\StageProgress;
use App\Models\User;

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

    public function show($userId)
    {
        $user = User::findOrFail($userId);

        // 称号取得状況
        $titles = AcquisitionStatus::where('user_id', $userId)->pluck('title_id');

        // ステージ進行状況
        $stages = StageProgress::with('stage')
            ->where('user_id', $userId)
            ->get()
            ->sortBy(fn($s) => [$s->stage->chapter_num, $s->stage->stage_num]);

        // フレンド関係
        $friends = Friend::where('user_id', $userId)
            ->with('friendUser:id,name')
            ->get()
            ->pluck('friendUser');

// 申請した
        $sentRequests = FriendRequest::where('requesting_user_id', $userId)
            ->where('is_reaction', false)
            ->with('recipient:id,name')
            ->get()
            ->pluck('recipient');

// 申請された
        $receivedRequests = FriendRequest::where('recipient_id', $userId)
            ->where('is_reaction', false)
            ->with('requestingUser:id,name')
            ->get()
            ->pluck('requestingUser');


        return view('users/show', compact(
            'user', 'titles', 'stages', 'friends', 'sentRequests', 'receivedRequests'
        ));
    }



}
