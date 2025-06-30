<html lang=“ja”>
<body>
<h1>■{{$title}}■</h1>
<a href="http://localhost/TOP/index">[管理画面TOP]</a>

<table border="1">
    <tr>
        <th>id</th>
        <th>ユーザー名</th>
        <th>アイテム名</th>
        <th>個数</th>
    </tr>
    　@foreach($users as $user)
        @foreach($user->items as $item)
            <tr>
                <td>{{$user['id']}}</td>
                <td>{{$user['name']}}</td>
                <td>{{$item['name']}}</td>
                <td>{{$item->pivot->amount}}</td>
            </tr>
        @endforeach
    @endforeach


</table>

</body>
</html>

