<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\AcquisitionStatus;
use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\StaminaStatus;
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
        StaminaStatus::create([
           'user_id' => $user->id,
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
            $user->experience += $request->experience;
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
    public function store_title(Request $request){
        AcquisitionStatus::create([
            'user_id' => $request->user()->id,
            'title_id' => $request->title_id
        ]);
    }

    public function store_friend_request(Request $request){
        FriendRequest::create([
           'requesting_user_id' => $request->user()->id,
            'recipient_id' => $request->recipient_id
        ]);
    }

    public function show_friend_request(Request $request){
        $requests = FriendRequest::where('recipient_id', $request->user()->id)
            ->with(['requestingUser.acquisitions'])
            ->get()
            ->map(function ($request) {
                return [
                    'name'       => $request->requestingUser->name,
                    'level'      => $request->requestingUser->level,
                    'experience' => $request->requestingUser->experience,
                    'title_id'   => $request->requestingUser->acquisitions->pluck('title_id')->toArray(),
                ];
            });

        return response()->json($requests);
    }

    public function store_friend(Request $request){
        $friend_request = FriendRequest::where('recipient_id',$request->user()->id);
        $friend_request->is_reaction = true;
        $friend_request->save();

        Friend::create([
            'user_id' => $request->user()->id,
            'friend_id' => $friend_request->requesting_user_id
        ]);
        Friend::create([
            'user_id' => $friend_request->requesting_user_id,
            'friend_id' => $request->user()->id
        ]);
    }

    public function show_friend(Request $request){
        $friends = Friend::where('user_id', $request->user()->id)
            ->with([
                'user.stamina',
                'user.acquisitions',
            ])
            ->get()
            ->map(function ($friend) {
                return [
                    'name'             => $friend->user->name,
                    'level'            => $friend->user->level,
                    'experience'       => $friend->user->experience,
                    'is_provides_stamina' => $friend->is_provides_stamina,
                    'current_stamina'  => optional($friend->user->stamina)->current_stamina,
                    'max_stamina'      => optional($friend->user->stamina)->max_stamina,
                    'title_id'         => $friend->user->acquisitions->pluck('title_id')->toArray(),
                ];
            });

        return response()->json($friends);
    }
}
