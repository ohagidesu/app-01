<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Library\Message;
use App\Events\AdminMessageSent;
use App\Models\Messeage;
use App\Models\Admin;
use App\Models\Post;
use App\Models\Talk;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminChatController extends Controller
{
    public function __construct()
    {
        // 認証されたユーザーだけが、このコントローラのページにアクセスすることができる。
        $this->middleware('auth');
    }
    
    public function index()
    {
       $users = User::all();
        return view('admin.index', compact('users'));
    }
    
    public function posts(Post $post)
     {
        return view('admin.posts')->with(['posts' => $post->getPaginateByLimit()]);  
       //blade内で使う変数'posts'と設定。'posts'の中身にgetを使い、インスタンス化した$postを代入。
     }

    public function openChat(User $user,Request $request)
    {
        //dd($admin = Auth::guard('admin'));
        $adminId = Auth::guard('admin')->id();
        $userId = $user->id; // ここで相手のユーザーIDを指定
        
         // データベース内でチャットが存在するかを確認
        $talk = Talk::where(function($query) use ($userId, $adminId) {
            $query->where('user_id', $userId)
                ->where('admin_id', $adminId);
        })->first();

        // チャットが存在しない場合、新しいチャットを作成
        if (!$talk) {
            $talk = new Talk();
            $talk->user_id = $userId;
            $talk->admin_id = $adminId;
            $talk->save();
        }

        $messages = Messeage::where('talk_id', $talk->id)->orderBy('updated_at', 'DESC')->get();;

        return view('admin/chat')->with(['talk'=>$talk,'messages'=>$messages]);
        
    }
    
    // メッセージ送信時の処理
    public function sendMessage( Request $request,Messeage $messeage )
    {
        //dd($request);
        // auth()->user() : 現在認証しているユーザーを取得
        $admin = Auth::guard('admin');
        $strUsername = $admin->user()->name;
        $adminId = Auth::guard('admin')->id();
        
        // リクエストからデータの取り出し
        $strMessage = $request->input('message');
        
        
        // メッセージオブジェクトの作成と公開メンバー設定
        $message = new Message;
        $message->username = $strUsername;
        $message->body = $strMessage;
        $message->talk_id = $request->input('talk_id');
        
        // 送信者を含めてメッセージを送信
        AdminMessageSent::dispatch($message);
        
        $messeage->talk_id = $request->input('talk_id');;
        $messeage->user_id = null;
        $messeage->admin_id = $adminId;
        $messeage->messages = $strMessage;
        $messeage->save();
        
        
        

        /* Messeage::create([  
          "talk_id" => 1,  
          "user_id" => 1,  
          "admin_id" => 1,  
          "messeage" => $strMessage,  
        ]);*/
        
         // 送信者を除いて他者にメッセージを送信
        // Note : toOthersメソッドを呼び出すには、
        //        イベントでIlluminate\Broadcasting\InteractsWithSocketsトレイトをuseする必要がある。
        //broadcast( new MessageSent($message))->toOthers();
        
        //return ['message' => $strMessage];
        return response()->json(['message' => 'Message sent successfully']);
    }
}

