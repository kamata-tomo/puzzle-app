@extends('layouts.app')
@section('title', 'ユーザー情報')
@section('body')
    <a href="http://localhost/TOP/index">[管理画面TOP]</a><br>
    <a href="http://localhost/users/index">[ユーザー一覧]</a><br>
    <h1>■ユーザー情報■</h1>
    <table border="1">

        <tr>
            <td>ユーザーID</td>
            <td>{{$users['id']}}</td>

        </tr>
        <tr>
            <td>ユーザー名</td>
            <td>{{$users['name']}}</td>

        </tr>



        </table>
@endsection
