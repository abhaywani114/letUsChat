@extends('layout.layout')

@section('content')

<div class="px-32 mt-10 h-6/12" id='login_app'>
    <div class="w-2/4 mx-auto bg-white">
        <div>
        <p @click="show_sign_up = !show_sign_up ; show_login = !show_login" class="w-1/2 cursor-pointer bg-teal-600 py-3 text-center text-white text-sm font-semibold uppercase tracking-wider w-full">Sign Up</p>
    </div>
       
    <div class="w-full justify-center shadow-sm">
         <br/>
        <div v-if="show_sign_up" class="w-full">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="{{ route('register') }}">
                        @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="Name" type="text" placeholder="Name" name="name"/>
                    @if (session('form') == 'sign_up') @error('name') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror @endif
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">E-Mail Address</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="Naemailme" type="email" placeholder="example@gmail.com" name="email"/>
                    @if (session('form') == 'sign_up') @error('email') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror @endif
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Username</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Username" name="username"/>
                    @if (session('form') == 'sign_up') @error('username') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror @endif
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>

                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************" name="password" />
                    @if (session('form') == 'sign_up') @error('password') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror @endif
                </div>

                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Sign Up</button>
                </div>
            </form>
        </div>
    </div>

    <div class="w-full justify-center shadow-sm">
        <p @click="show_sign_up = !show_sign_up ; show_login = !show_login" class="bg-teal-600 py-3 text-center text-white text-sm font-semibold uppercase tracking-wider w-full cursor-pointer">Login</p>
        <br/>
        <div v-if="show_login" class="w-full  justify-center items-center">
            @if (session('login_error'))
            <p class="bg-red-500 py-2 text-white text text-sm italic text-center">{{ session('login_error') }}</p>
            @endif
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full" method="POST" action="{{ route('login') }}">
                          @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>

                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="email" id="email" type="text" placeholder="email">
                    @if (session('form') != 'sign_up') @error('email') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror @endif
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>

                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" name="password" id="password" type="password" placeholder="******************">
                    @if (session('form') != 'sign_up') @error('password') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror @endif
                </div>

                <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Sign In</button>
                <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
                    Forgot Password?
                </a>
                 </div>
            </form>
        </div>
    </div>
    </div>
</div>
<script type="text/javascript">
     var login_app = new Vue({
        el: '#login_app',
        data: {
            @if (session('form') != 'sign_up')
            show_login: true,
            show_sign_up: false,
            @else 
            show_login: false,
            show_sign_up: true,
            @endif
        }
    });
</script>
@endsection