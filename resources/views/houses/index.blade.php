<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Blog</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
          </head>
    <body>
    </div>
    @section('content')
    <div class="container">
        <h1>登録された家の一覧</h1>

        <!-- 登録ボタン -->
        <a href="{{ route('houses.create') }}" class="btn btn-primary">新しい家を登録</a>

        <!-- 家の一覧表示 -->
        @if(count($houses) > 0)
            <ul>
                @foreach($houses as $house)
                    <li>
                        {{ $house->building }} - {{ $house->interior }} - {{ $house->budget }} - {{ $house->hobby }}

                        <!-- 編集リンク -->
                        <a href="{{ route('houses.edit', $house->id) }}" class="btn btn-warning">編集</a>

                        <!-- 削除フォーム -->
                        <form action="{{ route('houses.destroy', $house->id) }}" method="post" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p>登録された家はありません。</p>
        @endif
    </div>
@endsection
            </div>
        </div>
    </body>
</html>