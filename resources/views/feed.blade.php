<x-app-layout>
    <div class="pt-6 pb-12 bg-gray-300">
        <x-slot name="header">
        </x-slot>
        @forelse($movies_and_reviews as $object)
            @if($object instanceof \App\Models\Movie)
                <div id="card" class="">
                    <!-- container for all cards -->
                    <div class="container lg:w-1/2 mx-auto flex flex-col">
                        <div
                            class="flex flex-col md:flex-row overflow-hidden bg-white rounded-lg shadow-xl mt-4 mx-2">
                            <!-- media -->
                            <div class="md:w-1/4">
                                <img class="inset-0 h-full w-full object-cover object-center"
                                     src="{{'/images/movies/'.$object->poster_path}}"/>
                            </div>
                            <!-- content -->
                            <div class="w-full py-2 px-6 text-gray-800 flex flex-col relative">
                                <h3 class="capitalize font-black text-2xl leading-tight">{{$object->title}}</h3>
                                <h4 class="text-md text-gray-800 uppercase font-bold mt-2">
                                    Режиссёр: {{$object->director}}
                                </h4>
                                <h4 class="text-md text-gray-800 uppercase font-bold mt-2">
                                    Год: {{$object->year}}
                                </h4>
                                @if($object->deleted_at)
                                    <h4 class="text-md text-red-700 uppercase font-black mt-2">
                                        Удалённый объект
                                    </h4>
                                @endif
                                <a href="{{route('movies.show', ['user'=>$object->user->name, 'movie'=>$object->id])}}"
                                   class="self-start inline-flex items-center h-10 px-4 my-2 mr-2 text-base
                         text-white transition-colors duration-300 bg-green-500 rounded-lg
                         focus:shadow-outline hover:bg-indigo-900">...подробнее</a>
                                <h4 class="text-md text-gray-800 uppercase font-bold mt-2">
                                    Дата создания: {{$object->created_at}}
                                </h4>
                                <h4 class="text-md text-gray-800 uppercase font-bold mt-2">
                                    Добавил: <a class="text-indigo-600 normal-case hover:text-blue-500"
                                                href={{route('movies', ['user'=>$object->user->name])}}>
                                        {{$object->user->name}}
                                    </a>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="flex mx-auto items-center justify-center shadow-lg mx-4 mb-4 mt-4 max-w-2xl">
                    <div class="font-extrabold w-full max-w-2xl bg-white rounded-lg px-4 pt-2">
                        <div class="flex flex-col flex-wrap -mx-3 mb-6">
                            <h2 class="px-4 pt-1 pb-1 text-lg">Комментарий от
                                <a class="text-indigo-600 normal-case hover:text-blue-500"
                                   href={{route('movies', ['user'=>$object->user->name])}}>
                                    {{$object->user->name}}
                                </a>
                                к фильму
                                <a class="text-indigo-600 normal-case hover:text-blue-500"
                                   href={{route('movies.show', ['user'=>$object->user->name, 'movie'=>$object->movie->id])}}>
                                    <span class="capitalize text-blue-800">{{$object->movie->title}}</span>
                                </a>
                            </h2>
                            <h2 class="px-4 pb-1 text-gray-800 text-lg">{{$object->published_at->format('Y.m.d H:i:s')}}</h2>
                            <div class="h-full w-full md:w-full px-3 mb-2 mt-2">
                                <p class="bg-gray-100 rounded border break-all border-gray-400 leading-normal overflow-y-auto w-full max-h-52 py-2 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white">
                                    {{$object->content}}
                                </p>
                            </div>
                            <div class="w-full md:w-full flex items-start md:w-full px-3">
                                <div class="flex items-start w-1/2 text-gray-700 px-2 mr-auto items-center">
                                    <h2>Оценка: {{$object->rating}}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="container justify-center">
                <h3 class="text-lg text-center font-extrabold">В ленте нет записей</h3>
            </div>
        @endforelse
    </div>
</x-app-layout>
