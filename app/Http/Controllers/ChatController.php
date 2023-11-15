<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Library\Message;
use App\Events\MessageSent;
use App\Models\Messeage;

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
    public function sendMessage( Request $request,Messeage $messeage )
    {
        // auth()->user() : 現在認証しているユーザーを取得
        $user = auth()->user();
        $strUsername = $user->name;
        $userId = auth()->user()->id;
        
        // リクエストからデータの取り出し
        $strMessage = $request->input('message');
        
        
        // メッセージオブジェクトの作成と公開メンバー設定
        $message = new Message;
        $message->username = $strUsername;
        $message->body = $strMessage;
        
        // 送信者を含めてメッセージを送信
        MessageSent::dispatch($message);
        
        $messeage->talk_id = null;
        $messeage->user_id = $userId;
        $messeage->admin_id = null;
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
        return $request;
    }
}

