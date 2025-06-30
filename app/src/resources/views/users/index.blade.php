@extends('layouts.app')
@section('title', 'ユーザー一覧')
@section('body')
    <h1>■{{$title}}■</h1>
    <a href="http://localhost/TOP/index">[管理画面TOP]</a>

    {{$users->links()}}
    <table border="1">
        <tr>
            <th>id</th>
            <th>name</th>
            <th>Lv</th>
            <th>経験値</th>
            <th>年齢</th>
        </tr>
        　@foreach($users as $user)

            <tr>
                <td>{{$user['id']}}</td>
                <td><a href="http://localhost/users/show/{{$user['id']}}" id="user{{$user['id']}}">{{$user['name']}}</a>
                </td>
                <td>{{$user['level']}}</td>
                <td>{{$user['Experience']}}</td>
                @isset($user->detail->age)
                    <td>{{$user->detail->age}}</td>
                @endisset
            </tr>

        @endforeach


    </table>

@endsection
