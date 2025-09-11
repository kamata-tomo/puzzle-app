@extends('layouts.app')
@section('title', 'ユーザー情報')
@section('body')
    <div class="container">
        <h1>ユーザー状況: {{ $user->name }}</h1>
        <div class="card mb-4">
            <div class="card-header">ユーザー情報</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>名前</th>
                        <th>Lv</th>
                        <th>経験値</th>
                        <th>スタミナ回復アイテム個数</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->level }}</td>
                        <td>{{ $user->experience }}</td>
                        <td>{{ $user->item_quantity }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 称号取得 --}}
        <div class="card mb-4">
            <div class="card-header">称号取得状況</div>
            <div class="card-body">
                @if($titles->isEmpty())
                    <p>称号なし</p>
                @else
                    <ul>
                        @foreach($titles as $status)
                            <li>
                                ID: {{ $status->title->id }} -
                                {{ $status->title->name }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        {{-- ステージ進行状況 --}}
        <div class="card mb-4">
            <div class="card-header">ステージ進行状況</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Chapter</th>
                        <th>Stage</th>
                        <th>評価(★)</th>
                        <th>収集アイテム</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($stages as $stage)
                        <tr>
                            <td>{{ $stage->stage->chapter_num }}</td>
                            <td>{{ $stage->stage->stage_num }}</td>
                            <td>{{ $stage->evaluation }}</td>
                            <td>{{ $stage->collectibles ? '取得済み' : '未取得' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- フレンド --}}
        <div class="card mb-4">
            <div class="card-header">フレンド</div>
            <div class="card-body">
                @if($friends->isEmpty())
                    <p>フレンドなし</p>
                @else
                    <ul>
                        @foreach($friends as $f)
                            <li>{{ $f->id }} - {{ $f->name }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        {{-- 申請状況 --}}
        <div class="card mb-4">
            <div class="card-header">フレンド申請状況</div>
            <div class="card-body">
                <h5>申請した</h5>
                @if($sentRequests->isEmpty())
                    <p>なし</p>
                @else
                    <ul>
                        @foreach($sentRequests as $r)
                            <li>{{ $r->id }} - {{ $r->name }}</li>
                        @endforeach
                    </ul>
                @endif

                <h5 class="mt-3">申請された</h5>
                @if($receivedRequests->isEmpty())
                    <p>なし</p>
                @else
                    <ul>
                        @foreach($receivedRequests as $r)
                            <li>{{ $r->id }} - {{ $r->name }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection
