<x-app-layout>
    <div class="pt-6 pb-12 bg-gray-300">
        <x-slot name="header">
        </x-slot>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 text-lg">Список клиентов</div>
                    <div class="p-6 bg-white border-b border-gray-200">
{{--                        <div class="py-3 text-gray-900">--}}
{{--                            <h3 class="text-lg text-gray-500">{{$client->name}}</h3>--}}
{{--                            <p><b>ID: </b>{{$client->id}}</p>--}}
{{--                            <p><b>Redirect: </b>{{$client->redirect}}</p>--}}
{{--                            <p><b>Secret: </b>{{$client->secret}}</p>--}}
{{--                        </div>--}}

{{--                        @forelse($clients as $client)--}}
{{--                            <div class="py-3 text-gray-900">--}}
{{--                                <h3 class="text-lg text-gray-500">{{$client->name}}</h3>--}}
{{--                                <p><b>ID: </b>{{$client->id}}</p>--}}
{{--                                <p><b>Redirect: </b>{{$client->redirect}}</p>--}}
{{--                                <p><b>Secret: </b>{{$client->secret}}</p>--}}
{{--                            </div>--}}
{{--                        @empty--}}
{{--                            <div class="container justify-center">--}}
{{--                                <h3 class="text-lg text-center font-extrabold">Нет клиентов</h3>--}}
{{--                            </div>--}}
{{--                        @endforelse--}}
                    </div>
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form action="/oauth/clients" method="POST">
                            <div>
                                <x-label for="name" >Имя</x-label>
                                <x-input type="text" name="name" placeholder="Имя клиента"></x-input>
                            </div>
                            <div class="mt-2">
                                <x-label for="redirect" >Redirect</x-label>
                                <x-input type="text" name="redirect" placeholder="https://my-url.com/callback"></x-input>
                            </div>
                            <div class="mt-3">
                                @csrf
                                <x-button type="submit">Создать клиент</x-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
