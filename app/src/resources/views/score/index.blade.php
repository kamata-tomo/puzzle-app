<html lang=“ja”>
<body>
<h1>■{{$title}}</h1>
<table border="1">
    <tr>
        <th>id</th>
        <th>name</th>
        <th>score</th>
    </tr>
    　@foreach($accounts as $account)
        <tr>
            <td>{{$account['id']}}</td>
            <td>{{$account['name']}}</td>
            <td>{{$account['score']}}</td>
        </tr>
    @endforeach


</table>
<a href="http://localhost/accounts/index">[アカウント一覧]</a>
</body>
</html>
