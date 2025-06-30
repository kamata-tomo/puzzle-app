@extends('layouts.app')
@section('title', 'ログイン画面')
@section('body')
    <div>
        <form method="post" action="{{url('login')}}">
            @csrf
            ID:<input name="name" type="text"><br>
            pass:<input name="password" type="password"><br>
            <button type="submit">ログイン</button>
            <br>

        </form>
        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

    </div>
@endsection
