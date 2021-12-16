<x-app-layout>
    <div class="pt-6 pb-12 bg-gray-300">
        <x-slot name="header">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <x-add-movie-link :user="$user"></x-add-movie-link>
                    <x-user-name-link :user="$user"></x-user-name-link>
                </h2>
            </div>
        </x-slot>
        <div id="card" class="">
            <!-- container for all cards -->
            <div class="container w-100 lg:w-4/5 mx-auto flex flex-col">
                @forelse($movies as $movie)
                    <div
                        class="flex flex-col md:flex-row overflow-hidden bg-white rounded-lg shadow-xl mt-4 w-100 mx-2">
                        <!-- media -->
                        <div class="md:w-1/6">
                            <img class="inset-0 h-full w-full object-cover object-center"
                                 src="{{'/images/movies/'.$movie->poster_path}}"/>
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
                            @if($movie->deleted_at)
                                <h4 class="text-lg text-red-700 uppercase font-black mt-2">
                                    Удалённый объект
                                </h4>
                            @endif
                            <a href="{{route('movies.show', ['user'=>$user->name, 'movie'=>$movie->id])}}" class="self-start inline-flex items-center h-10 px-4 my-2 mr-2 text-base
                         text-white transition-colors duration-300 bg-green-500 rounded-lg
                         focus:shadow-outline hover:bg-indigo-900">...подробнее</a>
                        </div>
                    </div>
                @empty
                    <div class="container justify-center">
                        <h3 class="text-lg text-center font-extrabold">Коллекция пуста</h3>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <script>
        (function ($) {
            window.onbeforeunload = function (e) {
                window.name += ' [' + location.pathname + '[' + $(window).scrollTop().toString() + '[' + $(window).scrollLeft().toString();
            };
            $.maintainscroll = function () {
                if (window.name.indexOf('[') > 0) {
                    var parts = window.name.split('[');
                    window.name = $.trim(parts[0]);
                    if (parts[parts.length - 3] === location.pathname) {
                        window.scrollTo(parseInt(parts[parts.length - 1]), parseInt(parts[parts.length - 2]));
                    }
                }
            };
            $.maintainscroll();
        })(jQuery);
    </script>
</x-app-layout>
