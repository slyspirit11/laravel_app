@include('layout.header')

<div>
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="mt-5 md:mt-0 md:col-span-2">
            <form action="{{route('movies.update', ['user'=>$user->name, 'movie'=>$movie->id])}}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        <div class="grid grid-cols-3 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="title" class="block text-sm font-medium text-gray-700">Название</label>
                                <input type="text" name="title" id="title" autocomplete="title"
                                       value="{{$movie->title}}"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                       required>
                            </div>
                            @error('title') {{$message}} @enderror
                            <div class="col-span-6 sm:col-span-3">
                                <label for="director" class="block text-sm font-medium text-gray-700">Режиссёр</label>
                                <input type="text" name="director" id="director" autocomplete="director"
                                       value="{{$movie->director}}"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                       required>
                            </div>
                            @error('director') {{$message}} @enderror
                            <div class="col-span-6 sm:col-span-3">
                                <label for="year" class="block text-sm font-medium text-gray-700">Год</label>
                                <input type="number" name="year" id="year" autocomplete="year" value="{{$movie->year}}"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                       required>
                            </div>
                            @error('year') {{$message}} @enderror
                        </div>

                        <div>
                            <label for="synopsys" class="block text-sm font-medium text-gray-700">
                                Описание
                            </label>
                            <div class="mt-1">
                                <textarea id="synopsys" name="synopsys" rows="3"
                                          class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block
                                          w-full sm:text-sm border border-gray-300 rounded-md">{{$movie->synopsys}}</textarea>
                            </div>
                        </div>
                        @error('synopsys') {{$message}} @enderror
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Фотография для обложки
                            </label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                         viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="poster"
                                               class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Загрузить файл</span>
                                            <input id="poster" name="poster" type="file" class="sr-only"
                                                   value="/images/movies/{{$movie->poster_path}}"
                                                   accept=".jpg, .jpeg, .png">
                                        </label>
                                        <p class="pl-1">или переместить</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        JPG, JPEG, PNG до 64KB
                                    </p>
                                </div>
                                @error('poster') {{$message}} @enderror
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Сохранить
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="hidden sm:block" aria-hidden="true">
    <div class="py-5">
        <div class="border-t border-gray-200"></div>
    </div>
</div>


@include('layout.footer')
