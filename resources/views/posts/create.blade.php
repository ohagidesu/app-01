<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Blog</title>
    </head>
    <body>
        <h1>皆様の生の声をお届けください！</h1>
        <form action="/posts" method="POST">
            @csrf
            <div class="title">
                <h3>タイトル名</h3>
                <input type="text" name="post[title]" placeholder="タイトル" value="{{ old('post.title') }}"/>
                <p class="title__error" style="color:red">{{ $errors->first('post.title') }}</p>
            </div>
            <div class="body">
                <h3>投稿内容</h3>
                <textarea name="post[content]" placeholder="今日も1日お疲れさまでした。">{{ old('post.content') }}</textarea>
                <p class="content__error" style="color:red">{{ $errors->first('post.content') }}</p>
            </div>　
            <input type="submit" value="この内容で投稿する"/>
        </form>
        <div class="back">[<a href="/posts">back</a>]</div>
    </body>
</html>