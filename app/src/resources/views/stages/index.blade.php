@extends('layouts.app')
@section('title', 'ステージ一覧')
@section('body')


        <div class="d-flex gap-2 mb-3">
            <a href="/TOP/index" class="btn btn-secondary shadow-sm">🏠 管理画面TOP</a>
            <a href="{{ route('stages.create') }}" class="btn btn-success shadow-sm">➕ ステージ作成</a>
        </div>
        {{-- 成功メッセージ --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="閉じる"></button>
            </div>
        @endif
        <h1>■ステージ一覧■</h1>
    {{$stages->links()}}
    <table border="2">
        <tr>
            <th>id</th>
            <th>ステージ</th>
            {{--<th>評価基準が時間か否か</th>--}}
            <th>星1基準</th>
            <th>星2基準</th>
            <th>星3基準</th>
        </tr>
        　@foreach($stages as $stage)

            <tr>
                <td>
                    <a href="{{ route('stages.edit', $stage['id']) }}">
                        {{ $stage['id'] }}
                    </a>
                </td>
                <td>{{ $stage['chapter_num'] }}-{{ $stage['stage_num'] }}</td>
                {{--<td style="text-align: center">
                    {{ $stage['score_criteria_is_time'] ? '◯' : '✕' }}
                </td>--}}
                <td>{{ $stage['reference_value_1'] }}</td>
                <td>{{ $stage['reference_value_2'] }}</td>
                <td>{{ $stage['reference_value_3'] }}</td>
            </tr>


        @endforeach


    </table>

@endsection
