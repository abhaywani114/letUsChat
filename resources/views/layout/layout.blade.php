<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LetUsChat</title>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
	<script src="/js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js"></script>
</head>
<body class="bg-center bg-cover " xclass="bg-gray-200" style="background:url('https://i0.wp.com/destinationsolomons.com/wp-content/uploads/2019/03/2560x1440-blue-abstract-noise-free-website-background-image.jpg?fit=2560%2C1440&ssl=1') no-repeat;background-size: cover;">
<div class="inset-0 bg-black opacity-50 w-full h-full card-img-overlay z-0"></div>
    <header>
        <nav id="nav_bar" class="flex shadow-sm bg-gray-100  md:justify-between">
            <div class="bg-teal-600 shadow-2xl md:mx-auto">
                <h3 class='text-gray-100 text-lg tracking-wider font-semibold px-5 py-5'>Let Us Chat</h3>
            </div>
            <div class="flex justify-content items-center pr-4 mt-3 ml-auto md:ml-0">
                @auth<span class="text-xs font-semibold tracking-wider text-gray-600">Howdy {{Auth::user()->username}}!</span> @endauth
              <div class="relative ml-2">
                <button class="h-8 w-8 " @click="is_avater_open = !is_avater_open">
                <img class="relative z-20 block h-full w-full object-cover overflow-hidden rounded-full border-2 active:focus:outline-none focus:shadow-outline focus:border-white" src="/img/male-avatar.jpg" alt="" srcset="">
                </button>
                <button v-if="is_avater_open" @click="is_avater_open = !is_avater_open"  class="fixed inset-0 w-full h-full bg-black cursor-default opacity-75 z-10" tabindex="-1"></button>
                <div v-if="is_avater_open" class="z-20 bg-white w-48 rounded-md shadow-lg absolute right-0">
                    @if(Auth::user())
                    <a href="#" class="block p-4 text-gray-800 hover:bg-indigo-600 hover:text-white">Help</a>
                    <a href="#" class="block p-4 text-gray-800 hover:bg-indigo-600 hover:text-white">Settings</a>
                    <a href="{{url('logout')}}" class="block p-4 text-gray-800 hover:bg-indigo-600 hover:text-white">Logout</a>
                    @else
                    <a href="#" class="block p-4 text-gray-800 hover:bg-indigo-600 hover:text-white">Help</a>
                    @endif
                </div>
                </div>
                <!-- <h4 class="text-sm font-semibold text-gray-600 cursor-pointer">Logout</h4> -->
            </div>
        </nav>
    </header>
    @yield('content',"is empty")
  <script>
   var nav_bar_app = new Vue({
        el: '#nav_bar',
        data:{
            is_avater_open: false
     }
   });

   logout = function() {
        var data = new FormData();
        data.append('csrf',"{{ csrf_token() }}");
        axios.post('/logout', data)
            .then(function (res) {
              window.location = '/'
            })
   }

   </script>
</body>
</html>