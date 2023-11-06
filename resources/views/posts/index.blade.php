<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Blog</title>
        
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        
    </head>
    <body class="antialiased"> 
        <h1>Blog Name</h1>
        <a href='/posts/create'>create</a>
        <div class='posts'>
            @foreach($posts as $post)
            <a href="/categories/{{ $post->category->id }}">{{ $post->category->name }}</a>
                <div class='post'>
                    <h2 class='title'>
                        <a href="/posts/{{ $post->id }}">{{ $post->title }}</a>
                        </h2>
                    <p class='body'>{{ $post->body }}</p>
                    <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="deletePost({{ $post->id }})">delete</button> 
                    </form>
                </div>
                @auth
　　　　　　　　　　　　　<!-- Post.phpに作ったisLikedByメソッドをここで使用 -->
　　　　　　　　　　@if (!$post->isLikedBy(Auth::user()))
    　　　　　　　　　　　　<span class="likes">
       　　　　　　　　 <i class="fas fa-heart like-toggle" data-post-id="{{ $post->id }}"></i>
   　　　　　　　　　　　　 <span class="like-counter">{{$post->likes_count}}</span>
    　　　　　　　　　　　　　　</span><!-- /.likes -->
　　　　　　　　　@else
    　　　　　　　　　　　<span class="likes">
        　　　　　　　<i class="fas fa-heart heart like-toggle liked" data-post-id="{{ $post->id }}"></i>
    　　　　　　　　　　<span class="like-counter">{{$post->likes_count}}</span>
    　　　　　　　　</span><!-- /.likes -->
　　　　　　　　@endif
　　　　　　　@endauth
            @endforeach
        </div>
        <div class='paginate'>{{ $posts->links()}}</div>
        <script>
            function deletePost(id) {
                'use strict'

                if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                    document.getElementById(`form_${id}`).submit();
                }
            }
        </script>
    </body>
</html>

