<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <x-add-movie-link :user="$user"></x-add-movie-link>
                <x-user-name-link :user="$user"></x-user-name-link>
            </h2>
        </div>
    </x-slot>
    <div class="flex flex-row">
        <div
            class="mx-auto inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle max-w-3xl">
            <div class="flex flex-col md:flex-row overflow-hidden bg-white rounded-lg shadow-xl mt-4 mx-3">
                <!-- media -->
                <div class="w-auto w-1/3">
                    <img class="h-full w-full object-cover" src="{{'/images/movies/'.$movie->poster_path}}"/>
                </div>
                <!-- content -->
                <div class="w-full py-2 px-6 text-gray-800 flex flex-col relative">
                    <h3 class="font-black text-3xl leading-tight truncate">{{$movie->title}}</h3>
                    <h4 class="text-lg text-gray-800 uppercase font-bold mt-2">
                        Режиссёр: {{$movie->director}}
                    </h4>
                    <h4 class="text-lg text-gray-800 uppercase font-bold mt-2">
                        Год: {{$movie->year}}
                    </h4>
                    <p href="{{route('movies.show', ['user'=>$user->name, 'movie'=>$movie->id])}}"
                       class="items-center text-base text-justify break-all">
                        {{$movie->synopsys}}
                    </p>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="btn-close-modal"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300
                        shadow-sm px-4 py-2 bg-indigo-500 text-base font-medium text-gray-50
                        hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2
                        focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    <a href="{{route('movies', ['user'=>$user->name])}}" class="">Закрыть</a>
                </button>
                @can('update', $movie)
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300
                        shadow-sm px-4 py-2 bg-green-500 text-base font-medium text-gray-50
                        hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2
                        focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        <a href="{{route('movies.edit', ['user'=>$user->name, 'movie'=>$movie->id])}}"
                           class="">Редактировать</a>
                    </button>
                @endcan
                @can('delete', $movie)
                    @if(!$movie->deleted_at)
                        <form action="{{route('movies.destroy', ['user'=>$user->name, 'movie'=>$movie->id])}}"
                              method="post">
                            @method('DELETE')
                            @csrf
                            <button class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300
                            shadow-sm px-4 py-2 bg-red-500 text-base font-medium text-gray-50
                            hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2
                            focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Удалить
                            </button>
                        </form>
                    @endif
                @endcan
                @can('forceDelete', $movie)
                    <form action="{{route('movies.forceDelete', ['user'=>$user->name, 'movie'=>$movie->id])}}"
                          method="post">
                        @method('DELETE')
                        @csrf
                        <button class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300
                            shadow-sm px-4 py-2 bg-red-500 text-base font-medium text-gray-50
                            hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2
                            focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Force delete
                        </button>
                    </form>
                @endcan
                @can('restore', $movie)
                    @if($movie->deleted_at)
                        <form action="{{route('movies.restore', ['user'=>$user->name, 'movie'=>$movie->id])}}"
                              method="post">
                            @method('PUT')
                            @csrf
                            <button class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300
                            shadow-sm px-4 py-2 bg-yellow-400 text-base font-medium text-gray-50
                            hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2
                            focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Восстановить
                            </button>
                        </form>
                    @endif
                @endcan
            </div>
        </div>
    </div>
    <div class="flex mx-auto items-center justify-center shadow-lg mx-4 mb-4 max-w-2xl">
        <form action="{{route('reviews.store', ['user' => Auth::user()->name, 'movie' => $movie->id])}}" method="post"
              class="w-full max-w-2xl bg-white rounded-lg px-4 pt-2">
            @csrf
            <div class="flex flex-wrap -mx-3 mb-6">
                <h2 class="px-4 pt-3 pb-2 text-gray-800 text-lg">Рецензия</h2>
                <div class="w-full md:w-full px-3 mb-2 mt-2">
                            <textarea
                                class="bg-gray-100 rounded border border-gray-400 leading-normal resize-y w-full h-20 py-2 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white"
                                name="content" required></textarea>
                </div>
                <div class="w-full md:w-full flex items-start md:w-full px-3">
                    <div class="flex items-start w-1/2 text-gray-700 px-2 mr-auto items-center">
                        <p class="text-xs md:text-sm pt-px">Оценка: </p>
                        <input type="number" class="mx-2 w-1/5" id="tentacles" name="rating" min="1" max="10"
                               required>
                    </div>
                    <div class="-mr-1">
                        <input type='submit'
                               class="bg-white text-gray-700 font-medium py-1 px-4 border border-gray-400 rounded-lg tracking-wide mr-1 hover:bg-gray-100"
                               value='Опубликовать'>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @forelse($movie->reviews()->orderBy('published_at', 'desc')->get() as $review)
        <div class="flex mx-auto items-center justify-center font-bold shadow-lg mx-4 mb-4 max-w-2xl">
            <div class="w-full max-w-2xl bg-white rounded-lg px-4 pt-2">
                <div class="flex flex-col flex-wrap -mx-3 mb-6">
                    <h2 class="px-4 pt-1 pb-1 text-gray-800 text-lg">{{$review->user->name}} <span class="text-pink-700">{{Auth::user()->isFriendWith($review->user) ? '(друг)' : ''}}</span></h2>
                    <h2 class="px-4 pb-1 text-gray-800 text-lg">{{$review->published_at->format('Y.m.d H:i:s')}}</h2>
                    <div class="h-full w-full md:w-full px-3 mb-2 mt-2">
                        <p class="bg-gray-100 rounded border break-all border-gray-400 leading-normal overflow-y-auto w-full max-h-52 py-2 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white">
                            {{$review->content}}
                        </p>
                    </div>
                    <div class="w-full md:w-full flex items-start md:w-full px-3">
                        <div class="flex items-start w-1/2 text-gray-900 px-2 mr-auto items-center">
                            <h2>Оценка: {{$review->rating}}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <h2>Рецензии к данному фильму отсутствуют</h2>
    @endforelse
</x-app-layout>
