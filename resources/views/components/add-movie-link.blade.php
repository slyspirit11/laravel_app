@props(['user' => Auth::user()])

@if($user->can('create', App\Models\Movie::class))
    <a href="{{route('movies.create', ['user'=>$user->id])}}"
       class="text-black no-underline hover:text-gray-600">
        <span class="text-xl pl-4"><i class="em em-grinning"></i>Добавить</span>
    </a>
@endif
