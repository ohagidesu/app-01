<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Chat
        </h2>
    </x-slot>

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
                    @if ($message->user_id)
                        {{ $message->user->name }}
                    @elseif ($message->admin_id)
                        {{ $message->admin->name }}
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
                .post( '/chat', params )
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
        } );
    </script>
</x-app-layout>
