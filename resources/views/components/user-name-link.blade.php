@props(['user' => Auth::user()])

<a href="{{route('movies', ['user'=>$user->name])}}"
   class="text-black no-underline hover:text-gray-600">
    <span class="text-xl pl-4"><i class="em em-grinning"></i>{{$user->name}}</span>
</a>
