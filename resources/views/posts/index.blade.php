<x-app-layout>
    <body class="antialiased"> 
        <h1>Blog Name</h1>
        <a href='/posts/create'>create</a>
        <div class='posts'>
            @foreach($posts as $post)
                <div class='post'>
                    <h2 class='title'>
                        <a href="/posts/{{ $post->id }}">{{ $post->title }}</a>
                        </h2>
                    <p class='body'>{{ $post->content }}</p>
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
</x-app-layout>

