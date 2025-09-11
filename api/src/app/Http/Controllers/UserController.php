<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\AcquisitionStatus;
use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\StaminaLog;
use App\Models\StaminaReasons;
use App\Models\StaminaStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Monolog\Level;
use Illuminate\Support\Facades\Http;



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
        $request->validate([
            'name' => 'nullable|string',
            'experience' => 'nullable|integer',
            'item_quantity' => 'nullable|integer'
        ]);

        $user = User::with('stamina')->findOrFail($request->user()->id);
        $response = null; // 初期化しておく

        if (!empty($request->name)) {
            $user->name = $request->name;
        }
        $user->save();
        if (!empty($request->experience)) {
            $user->experience += $request->experience;
            $user->save();
            while ($user->experience >= ($user->level * 10)) {
               $user->experience -= ($user->level * 10);
                $user->level += 1;
                $user->stamina->max_stamina += 1;
                $user->stamina->save();
                $user->save();
                $fakeRequest = new Request([
                    'reason_id' => 4,
                ]);

                $fakeRequest->setUserResolver(function () use ($user) {
                    return $user; // update() で取得済みの $user を返す
                });

                $response = app(UserController::class)->stamina_changes_by_reasons($fakeRequest);

            }
        }
        if(!empty($request->item_quantity)){
            $user->item_quantity += $request->item_quantity;
            $user->save();
        }



        return response()->json([
            'user' => $user->load('stamina')->toArray()
        ]);

    }


    public function show_title(Request $request){
        $titles = AcquisitionStatus::with('title')
            ->where('user_id', $request->user()->id)
            ->get();
        return response()->json($titles);
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
            ->get();

        return response()->json($requests);
    }

    public function store_friend(Request $request){
        $friend_request = FriendRequest::where([
            ['recipient_id', '=', $request->user()->id],
            ['requesting_user_id', '=', $request->requesting_user_id],
        ])->firstOrFail();
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
                'user.acquisitions.title'
            ])
            ->get()
            ->map(function ($friend) {
                $titles = $friend->user->acquisitions->map(function ($acq) {
                    return [
                        'id'   => $acq->title_id,
                        'name' => $acq->title->name ?? null, // タイトルが存在しない場合は null
                    ];
                })->toArray();

                return [
                    'id'                  => $friend->user->id,
                    'name'                => $friend->user->name,
                    'level'               => $friend->user->level,
                    'experience'          => $friend->user->experience,
                    'is_provides_stamina' => $friend->is_provides_stamina,
                    'current_stamina'     => optional($friend->user->stamina)->current_stamina,
                    'max_stamina'         => optional($friend->user->stamina)->max_stamina,
                    'titles'              => $titles,
                ];
            });

        return response()->json($friends);
    }
    public function stamina_auto_recovery(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => '認証されていません'], 401);
        }

        $status = StaminaStatus::where('user_id', $user->id)->firstOrFail();

        $now = now();
        $last = $status->last_updated_at ?? $now;

        // Carbon に変換
        if (!($last instanceof \Carbon\Carbon)) {
            $last = \Carbon\Carbon::parse($last);
        }

        $minutes = $last->diffInMinutes($now);
        $recoverPoints = intdiv($minutes, 5); // 5分ごとに1回復

        if ($recoverPoints > 0) {
            $status->current_stamina = min($status->max_stamina, $status->current_stamina + $recoverPoints);
            $status->last_updated_at->addMinutes(5 * $recoverPoints);
            $status->save();
        }

        return response()->json([
            'current_stamina' => $status->current_stamina,
            'max_stamina' => $status->max_stamina,
        ]);
    }

    /** @used-by Route::prefix('users')->controller(UserController::class)->group(...) */
    public function stamina_changes_by_reasons(Request $request)
    {
        $request->validate([
            'reason_id'   => 'required|integer',
            'amount'      => 'nullable|integer', // クエスト消費だけ可変
        ]);

        $status = StaminaStatus::where('user_id', $request->user()->id)->firstOrFail();
        $reason = StaminaReasons::findOrFail($request->reason_id);
        $user = User::findOrFail($request->user()->id);
        $change = 0;
        switch ($reason->id) {
            case 1: // クエスト消費
                $change = -abs($request->amount ?? 0);
                if ($status->current_stamina + $change < 0) {
                    return response()->json(['error' => 'スタミナ不足です'], 400);
                }elseif ($status->current_stamina >= $status->max_stamina){
                    $status->last_updated_at = now();
                }
                break;

            case 2: // アイテム回復
                if($user->item_quantity > 0) {
                    $user->item_quantity -= 1;
                    $user->save();
                    $change += 5;
                }else{
                    return response()->json(['error' => 'スタミナ回復アイテム不足です'], 400);
                }
                break;

            case 4: // レベルアップ回復
                $change = $status->max_stamina;
                break;

            default:
                return response()->json(['error' => '不正なreason_idです'], 400);
        }

        // スタミナ更新
        $status->current_stamina += $change;
        $status->save();

        // ログ保存
        StaminaLog::create([
            'user_id'    => $request->user()->id,
            'change'     => $change,
            'reason_id'  => $reason->id,
        ]);

        return response()->json([
            'current_stamina' => $status->current_stamina,
            'max_stamina'     => $status->max_stamina,
        ]);
    }

    public function provider_stamina(Request $request){
        $trustee = StaminaStatus::where('user_id', $request->friend_id)->firstOrFail();
        $friend = Friend::where([
            ['user_id', '=', $request->user()->id],
            ['friend_id', '=', $request->friend_id],
        ])->firstOrFail();
        if($friend->updated_at->diffInDays(today()) >= 1){
            $friend->is_provides_stamina = false;
            $friend->save();
        }
        $change = 1;
        if ($trustee->current_stamina + $change > $trustee->max_stamina) {
            return response()->json(['error' => '最大スタミナを超過します'], 400);
        }elseif ($friend->is_provides_stamina == true){
            return response()->json(['error' => '今日はすでにあげています'], 400);
        }
        $trustee->current_stamina += 1;
        $trustee->save();

        $friend->is_provides_stamina = true;
        $friend->save();
        // ログ保存
        $log = StaminaLog::create([
            'user_id'    => $request->friend_id,
            'provider_id'=> $request->user()->id,
            'change'     => $change,
            'reason_id'  => 3,
        ]);
        return response()->json($log);

    }
}
