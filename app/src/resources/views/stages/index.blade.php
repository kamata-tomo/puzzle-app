@extends('layouts.app')
@section('title', 'ステージ情報')
@section('body')

    <a href="/TOP/index">[管理画面TOP]</a>
    <a href="/stages/create">[ステージ作成]</a>
    <h1>■ステージ情報■</h1>
    {{$stages->links()}}
    <table border="2">
        <tr>
            <th>id</th>
            <th>ステージ</th>
            <th>評価基準が時間か否か</th>
            <th>星1基準</th>
            <th>星2基準</th>
            <th>星3基準</th>
        </tr>
        　@foreach($stages as $stage)

            <tr>
                <td>{{$stage['id']}}</td>
                <td>{{$stage['chapter_num']}}-{{$stage['stage_num']}}</td>
                <td style="text-align: center"><?php if($stage['score_criteria_is_time']){
                        echo '◯';
                    }else{
                        echo '✕';
                    } ?></td>
                <td>{{$stage['reference_value_1']}}</td>
                <td>{{$stage['reference_value_2']}}</td>
                <td>{{$stage['reference_value_3']}}</td>

            </tr>

        @endforeach


    </table>

@endsection
