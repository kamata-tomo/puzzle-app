<html lang=“ja”>
<body>
<h1>■{{$title}}■</h1>
<table border="1">
    <tr>
        <th>id</th>
        <th>name</th>

    </tr>
    　@foreach($accounts as $account)
        <tr>
            <td>{{$account['id']}}</td>
            <td>{{$account['name']}}</td>
        </tr>
    @endforeach


</table>

</body>
</html>
