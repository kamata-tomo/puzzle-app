@extends('layouts.app')
@section('title', $title)
@section('body')
    <h1>■{{$title}}■</h1>
    <p>アイテム名:{{$name}}</p>
    <a href="http://localhost/TOP/index">[管理画面TOP]</a><br>
    <a href="http://localhost/item/index">[アイテム一覧]</a><br>
@endsection
