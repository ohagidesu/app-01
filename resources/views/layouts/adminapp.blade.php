<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        <link href="{{ asset('css/Like.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.posts')" :active="request()->routeIs('admin.posts')">
                        {{ __('口コミ投稿掲示板') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.looks')" :active="request()->routeIs('admin.looks')">
                        {{ __('チャットをする') }}
                    </x-nav-link>
                </div>
            </div>
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
            <!-- Page Heading -->
            
                
            
            <!-- Page Content -->
            <main>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

    {{-- エンターキーによるボタン押下を行うために、
         <button type="button">ではなく、<form>と<button type="submit">を使用。
         ボタン押下(=submit)時にページリロードが行われないように、
         onsubmitの設定の最後に"return false;"を追加。
         (return false;の結果として、submitが中断され、ページリロードは行われない。）--}}
   <form method="post"  onsubmit="onsubmit_Form(); return false;">
        メッセージ : <input type="text" id="input_message" autocomplete="off" />
        <input type="hidden" id="talk_id" name="talk_id" value="{{ $talk->id }}"> 
        <button type="submit" class="text-white bg-blue-700 px-5 py-2">送信</button>
    </form>
    
    <ul class="list-disc" id="list_message">
        @foreach ($messages as $message)
            <li>
                <strong>
                    @if ($message->admin_id)
                        {{ $message->admin->name }}
                    @elseif ($message->user_id)
                        {{ $message->user->name }}
                    @else
                        Unknown User
                    @endif
                :</strong>
                <div>{{ $message->messages }}</div>
            </li>
        @endforeach
    </ul>


    

                </div>
            </div>
        </div>
    </div>
    
    <script>
        const elementInputMessage = document.getElementById( "input_message" );
        const talkId = document.getElementById("talk_id").value;
        console.log(talkId);
        
        {{-- formのsubmit処理 --}}
        function onsubmit_Form()
        {
            {{-- 送信用テキストHTML要素からメッセージ文字列の取得 --}}
            let strMessage = elementInputMessage.value;
            if( !strMessage )
            {
                return;
            }

            params = { 
                'message': strMessage,
                'talk_id': talkId
                
            };

            {{-- POSTリクエスト送信処理とレスポンス取得処理 --}}
            axios
                .post( '/admin/chat', params )
                .then( response => {
                    console.log(response);
                    console.log(chatId)
                } )
                .catch(error => {
                    console.log(error.response)
                } );

            {{-- テキストHTML要素の中身のクリア --}}
            elementInputMessage.value = "";
        }
        
        {{-- ページ読み込み後の処理 --}}
        window.addEventListener( "DOMContentLoaded", ()=>
        {
            const elementListMessage = document.getElementById( "list_message" );
            
            {{-- Listen開始と、イベント発生時の処理の定義 --}}
            window.Echo.private('dating').listen( 'MessageSent', (e) =>
            {
                console.log(e);
                
                if (e.message.talk_id === talkId) {
                    {{-- メッセージの整形 --}}
                    let strUsername = e.message.username;
                    let strMessage = e.message.body;
    
                    {{-- 拡散されたメッセージをメッセージリストに追加 --}}
                    let elementLi = document.createElement( "li" );
                    let elementUsername = document.createElement( "strong" );
                    let elementMessage = document.createElement( "div" );
                    elementUsername.textContent = strUsername;
                    elementMessage.textContent = strMessage;
                    elementLi.append( elementUsername );
                    elementLi.append( elementMessage );
                    elementListMessage.prepend( elementLi );  // リストの一番上に追加
                    //elementListMessage.append( elementLi ); // リストの一番下に追加
                }
            });
            
            window.Echo.private('admin-dating').listen( 'AdminMessageSent', (e) =>
            {
                console.log(e);
                
                if (e.message.talk_id === talkId) {
                    {{-- メッセージの整形 --}}
                    let strUsername = e.message.username;
                    let strMessage = e.message.body;
    
                    {{-- 拡散されたメッセージをメッセージリストに追加 --}}
                    let elementLi = document.createElement( "li" );
                    let elementUsername = document.createElement( "strong" );
                    let elementMessage = document.createElement( "div" );
                    elementUsername.textContent = strUsername;
                    elementMessage.textContent = strMessage;
                    elementLi.append( elementUsername );
                    elementLi.append( elementMessage );
                    elementListMessage.prepend( elementLi );  // リストの一番上に追加
                    //elementListMessage.append( elementLi ); // リストの一番下に追加
                }
            });
        } );
    </script>

            </main>
        </div>
    </body>
</html>