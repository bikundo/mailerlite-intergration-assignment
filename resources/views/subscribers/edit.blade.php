@extends('layouts.app')

@section('content')
    <div class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-lg flex items-center space-x-4 text-center">
        <div class="w-full max-w-xs">

            <div class="w-full max-w-xs">
                <a href="{{route('subscribers.index')}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                    all subscribers
                </a>

                {{ Form::open(['route' => ['subscribers.update', $subscriber['id'] ], 'class' => 'bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4']) }}
                @method('PUT')
                <div class="mb-6">
                    <h1>Edit a Subscriber</h1>

                    <hr class=" mb-6">
                    @if(Session::has('message'))
                        <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
                            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path
                                    d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/>
                            </svg>
                            <p>
                                {{ Session::get('message') }}
                            </p>
                        </div>
                    @endif
                    <hr class=" mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="api_token">
                        Email
                    </label>
                    <input name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" disabled id="text" type="text" value="{{ $subscriber['email'] }}">

                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        name
                    </label>
                    <input name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="text" type="text" value="{{ $subscriber['name'] }}">
                    @if($errors->has('name'))
                        <p class="text-red-500 text-xs italic">
                            {{$errors->first('name')}}
                        </p>
                    @endif
                </div>


                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="country">
                        country
                    </label>
                    <input name="country" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="text" type="text" value="{{ $subscriber['country']}}">
                    @if($errors->has('country'))
                        <p class="text-red-500 text-xs italic">
                            {{$errors->first('country')}}
                        </p>
                    @endif
                </div>

                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        update subscriber details
                    </button>
                </div>
                {{ Form::close() }}

            </div>
        </div>
@endsection
