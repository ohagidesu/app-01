<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Library\Message;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function __construct()
    {
        // 認証されたユーザーだけが、このコントローラのページにアクセスすることができる。
        $this->middleware('auth');
    }

    public function index()
    {
        return view('chat');
    }
    
    // メッセージ送信時の処理
    public function sendMessage( Request $request )
    {
        // auth()->user() : 現在認証しているユーザーを取得
        $user = auth()->user();
        $strUsername = $user->name;
        
        // リクエストからデータの取り出し
        $strMessage = $request->input('message');
        
        // メッセージオブジェクトの作成と公開メンバー設定
        $message = new Message;
        $message->username = $strUsername;
        $message->body = $strMessage;
        
        // 送信者を含めてメッセージを送信
        MessageSent::dispatch($message);
        
         // 送信者を除いて他者にメッセージを送信
        // Note : toOthersメソッドを呼び出すには、
        //        イベントでIlluminate\Broadcasting\InteractsWithSocketsトレイトをuseする必要がある。
        //broadcast( new MessageSent($message))->toOthers();
        
        //return ['message' => $strMessage];
        return $request;
    }
}

