<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\AcquisitionStatus;
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

//    public function index(Request $request)
//    {
//      $validator = Validator::make($request->all(), [
//            'name' => ['required', 'string'],
//        ]);
//
    //       if ($validator->fails()) {
    //           return response()->json($validator->errors(), 400);
    //       }
//
    //       $users = User::where('name', "LIKE", "%{$request->name}%")
//           ->get();/* 名前に〇〇を含む */
//       return response()->json(
        //          UserResource::collection($users));
    //  }

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

    public function ShowTitle(Request $request){
        $Title = AcquisitionStatus::where('user_id', '=', $request->user()->id)
                ->get();
        return response()->json($Title);
    }

    public function TitleRegistration(Request $request){
        $Title = AcquisitionStatus::create([
            'user_id' => $request->user()->id,
            'title_id' => $request->title_id
        ]);
    }
}
