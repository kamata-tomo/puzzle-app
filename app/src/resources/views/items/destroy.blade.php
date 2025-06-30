@extends('layouts.app')
@section('title', '削除確認')
@section('body')
    <h1>■削除確認■</h1>
    <p>アイテム名:{{$item['name']}}</p>
    <form method="post" action="{{url('item/destroy',$item['id'])}}">
        @csrf
        <input type="hidden" name="submit" value="confirmed">
        <input type="submit" value="削除">
    </form>

    <a href="http://localhost/TOP/index">[管理画面TOP]</a><br>
    <a href="http://localhost/item/index">[アイテム一覧]</a><br>
@endsection
