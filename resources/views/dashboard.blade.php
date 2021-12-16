<x-app-layout>
    <x-slot name="header">
    </x-slot>
    <!-- component -->
    <div class="h-screen w-full flex overflow-hidden">
        <main
            class="flex-1 flex flex-col bg-gray-100 dark:bg-gray-700 transition duration-500 ease-in-out overflow-y-auto">
            <div class="mx-10">
                <nav
                    class="flex flex-row justify-between border-b
				dark:border-gray-600 dark:text-gray-400 transition duration-500
				ease-in-out">
                    <div class="flex">
                        <!-- Top NavBar -->
                        <a
                            class="py-2 block text-green-500 border-green-500
						dark:text-green-200 dark:border-green-200
						focus:outline-none border-b-2 font-medium capitalize
						transition duration-500 ease-in-out">
                            пользователи
                        </a>
                    </div>

                </nav>
                <h2 class="my-4 text-4xl font-semibold dark:text-gray-400">
                    Список пользователей
                </h2>
                <x-auth-user-block :user="Auth::user()"></x-auth-user-block>
                @forelse(App\Models\User::all() as $user)
                    @if($user->id !== Auth::id())
                        <div
                            class="w-min mt-2 flex px-4 py-4 justify-between bg-white
                            dark:bg-gray-600 shadow-xl rounded-lg cursor-pointer"
                        >
                            <div class="flex justify-between"
                                 onclick="window.location='{{route('movies', ['user'=>$user->name])}}';">
                                <div
                                    class="ml-4 flex flex-col text-gray-600
                            dark:text-gray-400">
                                    <span>Имя</span>
                                    <span class="mt-2 text-black dark:text-gray-200">
                                {{$user->name}}
                            </span>
                                </div>
                                <div
                                    class="ml-12 flex flex-col text-gray-600
                            dark:text-gray-400">
                                    <span>Почта</span>
                                    <span class="mt-2 text-black dark:text-gray-200">
                                {{$user->email}}
                            </span>

                                </div>

                                <div
                                    class="ml-12 flex flex-col text-gray-600
                            dark:text-gray-400">
                                    <span>Администратор</span>
                                    <span
                                        class="mt-2 text-black dark:text-gray-200 self-center">{{$user->is_admin ? '+' : '-'}}</span>
                                </div>
                                <div
                                    class="ml-12 flex flex-col text-gray-600
                            dark:text-gray-400">
                                    <span>Друг</span>
                                    <span class="mt-2 text-black dark:text-gray-200 self-center">
                                {{Auth::user()->isFriendWith($user) ? '+' : '-'}}
                                </span>
                                </div>
                            </div>
                            <div class="ml-12 flex items-center text-gray-600 dark:text-gray-400">
                                @if(!Auth::user()->isFriendWith($user))
                                    <form action="{{route('user.befriend', ['user'=>$user->name])}}" method="post">
                                        @csrf
                                        <x-button class="bg-green-600">
                                            <h2 class="whitespace-nowrap">Добавить в друзья</h2>
                                        </x-button>
                                    </form>
                                @else
                                    <form action="{{route('user.unfriend', ['user'=>$user->name])}}" method="post">
                                        @csrf
                                        <x-button class="bg-red-600">
                                            <h2 class="whitespace-nowrap">Удалить из друзей</h2>
                                        </x-button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 font-extrabold text-lg bg-white border-b border-gray-200">
                            В базе данных пользователи отсутствуют
                        </div>
                    </div>
            @endforelse
        </main>
    </div>
</x-app-layout>
