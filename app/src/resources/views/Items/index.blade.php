<html lang=“ja”>
<body>
<h1>■{{$title}}</h1>
<a href="http://localhost/TOP/index">[管理画面TOP]</a>
<table border="1">
    <tr>
        <th>id</th>
        <th>name</th>
        <th>タイプ</th>
        <th>効果値</th>
        <th>説明</th>

    </tr>
    　@foreach($Items as $Item)
        <tr>
            <td>{{$Item['id']}}</td>
            <td>{{$Item['name']}}</td>
            <td>{{$Item['type']}}</td>
            <td>{{$Item['effect_value']}}</td>
            <td>{{$Item['FlavorText']}}</td>
        </tr>
    @endforeach


</table>

</body>
</html>

