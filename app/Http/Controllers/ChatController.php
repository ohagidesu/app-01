<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
        // 認証されたユーザーだけが、このコントローラのページにアクセスすることができる。
        $this->middleware('auth');
    }

    public function index()
    {
        return 'chat';
    }
}

