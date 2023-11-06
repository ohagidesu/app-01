<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    protected $fillable = [
    'title',
    'body',
];
    public function user() {
         return $this->belongsTo(User::class);
     //     return $this->belongsTo(User::class, 'foreign_key', 'owner_key');
     }
     
    public function index(Post $post)
    {
    return view('posts.index')->with(['posts' => $post->getByLimit()]);
    }
    
    public function getByLimit(int $limit_count = 10)
    {
    // updated_atで降順に並べたあと、limitで件数制限をかける
    return $this->orderBy('updated_at', 'DESC')->limit($limit_count)->get();
    }
    
    // 実装1
    public function likes()
    {
    return $this->hasMany('App\Models\Like');
    }

// 実装2
// Viewで使う、いいねされているかを判定するメソッド。
public function isLikedBy($user): bool {
    return Like::where('user_id', $user->id)->where('post_id', $this->id)->first() !==null;
   }

}
