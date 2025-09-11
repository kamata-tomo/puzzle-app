@extends('layouts.app')
@section('title', 'ユーザー一覧')
@section('body')
    <h1>■{{$title}}■</h1>
    <a href="/TOP/index">[管理画面TOP]</a>

    {{$users->links()}}
    <table border="1">
        <tr>
            <th>id</th>
            <th>name</th>
            <th>Lv</th>
            <th>経験値</th>
            <th>スタミナ回復アイテム個数</th>
        </tr>
        　@foreach($users as $user)

            <tr>
                <td>{{$user['id']}}</td>
                <td><a href="/users/show/{{$user['id']}}" id="user{{$user['id']}}">{{$user['name']}}</a>
                </td>
                <td>{{$user['level']}}</td>
                <td>{{$user['experience']}}</td>
                <td>{{$user['item_quantity']}}</td>
            </tr>

        @endforeach


    </table>

@endsection
