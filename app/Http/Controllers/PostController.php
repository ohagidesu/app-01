<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostRequest;


class PostController extends Controller
{
    
     public function index(Post $post)
     {
        return view('posts.index')->with(['posts' => $post->getPaginateByLimit()]);  
       //blade内で使う変数'posts'と設定。'posts'の中身にgetを使い、インスタンス化した$postを代入。
     }

     public function create()
     {
        return view('posts.create');
     }

     public function store(PostRequest $request, Post $post)
     {
        $post->user_id = \Auth::id();
        $input = $request['post'];
        $post->fill($input)->save();
        return redirect('/posts/' . $post->id); 
     }

     public function show(Post $post)
     {
        return view('posts.show')->with(['post' => $post]);
     }

     public function edit(Post $post)
     {
        return view('posts.edit')->with(['post' => $post]);
     }

     public function update(PostRequest $request, Post $post)
     {
        $input_post = $request['post'];
        $post->fill($input_post)->save(); 
        
        return redirect('/posts/' . $post->id);
     }

     public function delete(Post $post)
     {
        $post->delete();
        return redirect('/');
     }
     
     public function like(Request $request)
     {
    $user_id = Auth::user()->id; // ログインしているユーザーのidを取得
    $post_id = $request->post_id; // 投稿のidを取得

    // すでにいいねがされているか判定するためにlikesテーブルから1件取得
    $already_liked = Like::where('user_id', $user_id)->where('post_id', $post_id)->first(); 

    if (!$already_liked) { 
        $like = new Like; // Likeクラスのインスタンスを作成
        $like->post_id = $post_id;
        $like->user_id = $user_id;
        $like->save();
    } else {
        // 既にいいねしてたらdelete 
        Like::where('post_id', $post_id)->where('user_id', $user_id)->delete();
    }
    // 投稿のいいね数を取得
    $post_likes_count = Post::withCount('likes')->findOrFail($post_id)->likes_count;
    $param = [
        'post_likes_count' => $post_likes_count,
    ];
    return response()->json($param); // JSONデータをjQueryに返す
 }
 

}
?>

