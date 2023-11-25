<x-app-layout>
<head>
    <title>Employee List</title>
</head>
<body>
    <h1>Employee List</h1>

    <ul>
        @foreach ($admins as $admin)
           <a href="/chat/{{ $admin->id }}">{{ $admin->name }}とチャットする</a>
            <!-- 他の属性も表示 -->
        @endforeach
    </ul>
</body>
</x-app-layout>