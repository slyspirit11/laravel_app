@include('layout.header')

<!-- This example requires Tailwind CSS v2.0+ -->
<div id="movieModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="movieModal" role="dialog"
     aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle max-w-2xl w-full">
            <div class="flex flex-col md:flex-row overflow-hidden bg-white rounded-lg shadow-xl mt-4 w-full mx-2">
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
                        <form action="{{route('movies.destroy', ['user'=>$user->name, 'movie'=>$movie->id])}}" method="post">
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
                    <form action="{{route('movies.forceDelete', ['user'=>$user->name, 'movie'=>$movie->id])}}" method="post">
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
                        <form action="{{route('movies.restore', ['user'=>$user->name, 'movie'=>$movie->id])}}" method="post">
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
</div>
@include('layout.footer')
