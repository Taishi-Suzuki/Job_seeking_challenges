<html>
<head>
<title>画像クラス保存</title>
<style>
table {
 width: 100%;
 text-align: center;
 border-collapse: collapse;
 border-spacing: 0;
}
table th {
 padding: 10px;
 background: #e9faf9;
 border: solid 1px #778ca3;
}
table td {
 padding: 10px;
 border: solid 1px #778ca3;
}
</style>
</head>
<body>
    @if (session('flash_message'))
        <div>
            {{ session('flash_message') }}
        </div>
    @endif
    @if(count($errors) > 0)
    @foreach ($errors->all() as $error)
     {{$error}}
    @endforeach
    @endif
    <table>
        <tr><th>id</th><th>image_path</th><th>success</th><th>message</th><th>class</th><th>confidence</th><th>request_timestamp</th><th>response_timestamp</th></tr>
    @foreach($datas as $data)
        <tr><td>{{$data->id}}</td><td>{{$data->image_path}}</td><td>{{$data->success}}</td><td>{{$data->message}}</td><td>{{$data->class}}</td><td>{{$data->confidence}}</td><td>{{$data->request_timestamp}}</td><td>{{$data->response_timestamp}}</td></tr>
    @endforeach
    </table>
<form action="/image/create" method="POST">
    @csrf
    <input type="text" name="path" value="{{old('path')}}">
    <input type="submit" value="send">
</form>
</body>
</html>