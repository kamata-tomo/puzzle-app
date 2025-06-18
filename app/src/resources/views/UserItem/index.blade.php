<html lang=“ja”>
<body>
<h1>■{{$title}}</h1>
<a href="http://localhost/TOP/index">[管理画面TOP]</a>
<table border="1">
    <tr>
        <th>id</th>
        <th>ユーザー名</th>
        <th>アイテム名</th>
        <th>個数</th>
    </tr>
    　@foreach($UserItems as $UserItem)
        <tr>
            <td>{{$UserItem['id']}}</td>
            <td>{{$UserItem['user_name']}}</td>
            <td>{{$UserItem['item_name']}}</td>
            <td>{{$UserItem['amount']}}</td>
        </tr>
    @endforeach


</table>

</body>
</html>

