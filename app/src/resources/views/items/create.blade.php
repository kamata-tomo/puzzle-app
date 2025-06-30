@extends('layouts.app')
@section('title', 'アイテム作成')
@section('body')
    <h1>■アイテム作成</h1>
    <a href="http://localhost/TOP/index">[管理画面TOP]</a><br>
    <a href="http://localhost/item/index">[アイテム一覧]</a><br>
    <form method="post" action="{{url('item/store')}}">
        @csrf
        <table border="1">
            <tr>
                <td>アイテム名</td>
                <td><input type="text" name="name" size="30"></td>
            </tr>
            <tr>
                <td>タイプ</td>
                <td><input type="text" name="type" size="30"></td>
            </tr>
            <tr>
                <td>効果値</td>
                <td><input type="number" name="effect_value" size="30"></td>
            </tr>
            <tr>
                <td>説明</td>
                <td><input type="text" name="flavor_text" size="30"></td>
            </tr>
        </table>
        <input type="submit" value="変更">
    </form>
    @foreach($errors as $error)
        <p>{{$error}}</p>
        @endforeach
        </body>
        </html>
        @endsection
