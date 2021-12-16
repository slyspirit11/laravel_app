@props(['user' => Auth::user()])
<div
    class="w-min mt-2 flex px-4 py-4 justify-between {{$user->id == Auth::id() ? 'bg-green-300' : 'bg-white'}}
        dark:bg-gray-600 shadow-xl rounded-lg cursor-pointer ">
    <div class="flex justify-between" onclick="window.location='{{route('movies', ['user'=>$user->name])}}';">
        <div class="ml-4 flex flex-col text-gray-600 dark:text-gray-400">
            <span>Имя</span>
            <span class="mt-2 text-black dark:text-gray-200">{{$user->name}}</span>
        </div>
        <div class="ml-12 flex flex-col text-gray-600 dark:text-gray-400">
            <span>Почта</span>
            <span class="mt-2 text-black dark:text-gray-200">{{$user->email}}</span>
        </div>
        <div class="ml-12 flex flex-col text-gray-600 dark:text-gray-400">
            <span>Администратор</span>
            <span class="mt-2 text-black dark:text-gray-200 self-center">{{$user->is_admin ? '+' : '-'}}</span>
        </div>
        @if(Auth::id() !== $user->id)
            <div class="ml-12 flex flex-col text-gray-600 dark:text-gray-400">
                <span>Друг</span>
                <span
                    class="mt-2 text-black dark:text-gray-200 self-center">{{Auth::user()->isFriendWith($user) ? '+' : '-'}}</span>
            </div>
        @endif
    </div>
</div>
