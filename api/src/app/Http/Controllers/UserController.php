<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\AcquisitionStatus;
use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Monolog\Level;


class UserController extends Controller
{
    public function show(Request $request)
    {
        $user = User::findOrFail($request->user()->id);
        return response()->json(
            $user
        );

    }

    public function store(Request $request)
    {
        if (empty($request->name)) {
            http_response_code(400);
            echo "Bad Request: nameがNULLです。";
            return;
        }

        $user = User::create([
            'name' => $request->name,

        ]);

        //APIトークンを発行する
        $token = $user->createToken($request->name)->plainTextToken;

        //ユーザーIDとAPIトークンを返す
        return response()->json(['token' => $token]);


    }
    public function update(Request $request)
    {


        $user = User::findOrFail($request->user()->id);
        if(!empty($request->name)){
            $user->name = $request->name;
        }
        if(!empty($request->level)){
            $user->level += $request->level;
        }
        if(!empty($request->Experience)){
            $user->Experience += $request->Experience;
        }
        $user->save();

        return response()->json();
    }

    public function show_title(Request $request){
        $Title = AcquisitionStatus::where('user_id', '=', $request->user()->id)
                ->get();
        return response()->json($Title);
    }
/** ユーザー称号情報の参照 */
    public function title_registration(Request $request){
        AcquisitionStatus::create([
            'user_id' => $request->user()->id,
            'title_id' => $request->title_id
        ]);
    }

    public function friend_request(Request $request){
        FriendRequest::create([
           'requesting_user_id' => $request->user()->id,
            'recipient_id' => $request->recipient_id
        ]);
    }
}
