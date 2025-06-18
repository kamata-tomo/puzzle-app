<html lang=“ja”>
<body>
<h1>■{{$title}}</h1>
<a href="http://localhost/TOP/index">[管理画面TOP]</a>
<table border="1">
    <tr>
        <th>id</th>
        <th>name</th>
        <th>Lv</th>
        <th>経験値</th>
    </tr>
    　@foreach($Users as $User)
        <tr>
            <td>{{$User['id']}}</td>
            <td>{{$User['name']}}</td>
            <td>{{$User['level']}}</td>
            <td>{{$User['Experience']}}</td>
        </tr>
    @endforeach


</table>

</body>
</html>

