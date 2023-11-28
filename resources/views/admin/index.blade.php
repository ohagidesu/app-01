
<head>
    <title>User List</title>
</head>
<body>
    <h1>User List</h1>

    <ul>
        @foreach ($users as $user)
           <a href="/admin/chat/{{ $user->id }}">{{ $user->name }}とチャットする</a>
            <!-- 他の属性も表示 -->
        @endforeach
    </ul>
</body>
