<x-app-layout>
     <x-slot name="header">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               {{ __('みんなの口コミを見てみよう！') }}
          </h2>
     </x-slot>

     <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

               <div class="bg-white shadow-sm sm:rounded-lg mb-10">
                    <div class="p-6 flex items-center ">
                         <a href="{{ route('posts.create') }}">
                              <button class="rounded bg-green-400 text-white py-2 px-3">口コミ投稿はこちらから！</button>
                         </a>
                    </div>
               </div>

               <div class="bg-white shadow-sm sm:rounded-lg ">
                    @foreach ($posts as $post)
                    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                         <div class="flex flex-col ">
                              <span class="text-xs text-gray-800">{{ $post->user->name }}</span>
                              <span class="text-xs text-gray-800">{{ $post->updated_at }}</span>
                         </div>
                         <a href="{{ route('posts.show', $post->id) }}">
                              <p class="text-md">{{$post->title}}</p>
                         </a>
                    </div>
                    @endforeach
               </div>

               <div class="my-5">{{$posts->links()}}</div>

          </div>
     </div>
</x-app-layout>


