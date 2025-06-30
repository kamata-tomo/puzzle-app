<html lang=“ja”>
<body>
<h1>■{{$title}}■</h1>
<a href="http://localhost/TOP/index">[管理画面TOP]</a><br>
<a href="http://localhost/item/create">[新規アイテム作成]</a>

<table border="1">
    <tr>
        <th>id</th>
        <th>name</th>
        <th>タイプ</th>
        <th>効果値</th>
        <th>説明</th>
        <th>操作</th>
    </tr>
    　@foreach($items as $item)
        <tr>
            <td>{{$item['id']}}</td>
            <td>{{$item['name']}}</td>
            <td>{{$item['type']}}</td>
            <td>{{$item['effect_value']}}</td>
            <td>{{$item['flavor_text']}}</td>
            <td>
                <form method="post" action="{{url('item/destroy',$item['id'])}}">
                    @csrf
                    <input type="submit" value="削除">
                </form>
                <form method="post" action="{{url('item/edit',$item['id'])}}">
                    @csrf
                    <input type="submit" value="編集">
                </form>
            </td>
        </tr>
    @endforeach


</table>

</body>
</html>

