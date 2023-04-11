@extends('layouts.app')

@section('content')
    <div class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-lg flex items-center space-x-4 text-center">
        <div class="w-full max-w-xs">

            {{ Form::open(['route' => 'mailerlite.token.validate', 'class' => 'bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4']) }}
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="api_token">
                    MailerLite API Token
                </label>
                <input name="api_token" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="text" type="text" placeholder="your MailerLite API token" value="{{ old('api_token') }}">
               @if($errors->has('api_token'))
                    <p class="text-red-500 text-xs italic">
                        {{$errors->first('api_token')}}
                    </p>
               @endif
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    validate Token
                </button>
            </div>
            {{ Form::close() }}

        </div>
    </div>
@endsection
