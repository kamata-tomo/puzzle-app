<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Monolog\Level;


class UserController extends Controller
{
    public function show(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        return response()->json(
            UserResource::make($user)
        );

    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $users = User::where('name', "LIKE", "%{$request->name}%")
            ->get();/* 名前に〇〇を含む */
        return response()->json(
            UserResource::collection($users));
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
        return response()->json(['user_id' => $user->id]);
    }
    public function update(Request $request)
    {
        if (empty($request->user_id)) {
            http_response_code(400);
            echo "Bad Request: user_idがNULLです。";
            return;
        }

        $user = User::findOrFail($request->user_id);

        if(!empty($request->level)){
            $user->level += $request->level;
        }
        if(!empty($request->Experience)){
            $user->Experience += $request->Experience;
        }
        $user->save();

        return response()->json();
    }
}
