@extends('layout.layout')

@section('content')
<div id="app" style="height:92vh">

    <div class="md:px-32 md:mt-10  md:h-6/12 ">
        <div class="md:flex md:bg-gray-100">
            <div class="w-full md:w-1/4 shadow-md">
                <p class="bg-teal-600 py-3 text-center text-white text-sm font-semibold uppercase tracking-wider cursor-pointer" v-on:click="inbox = !inbox">Inbox</p>
                <ul :class="!inbox ? 'hidden md:block':''" class="overflow-y-auto pb-4 bg-gray-100" style="max-height: 60vh;">
                    <div class="relative ">
                        <input v-model="active_user.search" v-on:keydown="search_user(event)" class='w-full text-sm px-3 pl-8 py-1 rounded-b-lg bg-gray-800  text-white focus:outline-none focus:shadow-outline' type="text" name="" id="" placeholder="Search"/>
                        <div class="absolute top-0">
                            <svg class="fill-current w-4 mt-2 ml-2 text-gray-500" viewBox="0 0 24 24">
                            <defs/>
                            <path d="M16.32 14.9l5.39 5.4a1 1 0 01-1.42 1.4l-5.38-5.38a8 8 0 111.41-1.41zM10 16a6 6 0 100-12 6 6 0 000 12z" class="heroicon-ui"/>
                            </svg>
                        </div>
                    </div>
                    <li class="flex p-2 shadow-sm hover:bg-gray-200" v-for="user in user_list">
                        <div class="pr-16 relative">
                         <img v-bind:src="user.image" class="absolute  h-auto w-full rounded-full mr-3" alt="" srcset="">
                        </div>
                        <div class='m-3 justify-center relative'>
                            <h3 class="cursor-pointer" v-on:click="select_active_user(user.username)">@{{user.name}}</h3>
                            <h4 class="text-xs text-gray-400">Active @{{user.active}}</h4>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="w-full mt-10 md:mt-0 md:w-9/12 bg-gray-100 ">
                <div class="flex justify-center shadow-sm">
                    <div class="flex ml-auto">
                        <div class="flex justify-center items-center">
                        <svg class="h-8 w-auto m-0" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                        </div>

                        <div class="ml-4">
                            <h3 class="">@{{active_user.name}}</h3>
                            <h4 class="text-xs text-gray-400">@{{active_user.active}}</h4>
                        </div>
                    </div>

                    <div class="flex justify-center  items-center ml-auto">
                    <div class="relative">
                    <button @click="cog = !cog"><svg class="h-8 w-auto m-0 mr-2 " fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></button>
                   
                    <button v-if="cog" @click="cog = !cog"  class="fixed inset-0 w-full h-full  cursor-default  z-10" tabindex="-1"></button>
                        <div v-if="cog" class="z-20 bg-white w-48 rounded-md shadow-xl absolute right-0">
                        <a href="#" v-on:click="delete_msgs" class="block p-4 text-gray-800 hover:bg-indigo-600 hover:text-white">Delete</a>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="relative h-full">
                    <div class="overflow-y-auto pb-4" style="min-height: 60vh;max-height: 60vh;">
                    <!-- text-field -->
                    <ul v-if="messages.texts.length > 0">
                        <li v-for="text in messages.texts" :class="( (text.sender != messages.user) ? 'ml-auto bg-teal-500':'mr-auto bg-blue-500')" class="flex  text-white w-1/2 rounded-lg m-8">
                            <div class=" flex justify-center items-center pr-6 relative">
                                <img src="/img/male-avatar.jpg" class="absolute h-auto w-full rounded-full mr-3" alt="" srcset="">
                            </div>
                            <p class="font-semibold text-sm break-words break-all pl-0 p-2">
                            <span v-html="text.data"></span>
                            <br/>
                            <span class="text-xs text-gray-400 font-medium tracking-wider">Today | Seen</span></p>
                        </li>
                        <li v-if="messages.page != -1" v-on:click="get_messages" class="flex justify-center items-between cursor-pointer">
                                <span class="p-2 rounded-full shadow-lg "><svg class="w-8 h-8 text-gray-600" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"></path></svg></span>
                        </li>
                    </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <div v-if="active_user.active" class="flex justify-center items-between shadow-lg bg-gray-800 w-full fixed bottom-0 p-2 md:py-4 px-auto opacity-75">
        <div class=" flex justify-center items-center pr-24 relative ml-40 hidden md:visible">
            <img v-bind:src="active_user.image"   class="opacity-100 absolute h-auto w-full rounded-full mr-3" alt="" srcset="">
        </div>

        <div class="w-9/12 md:w-1/2 ">
            <textarea v-model="messages.text_field" v-on:keyup.enter="send_message"  class="p-2 md:p-4 shadow-md w-full bg-gray-200 rounded-lg font-semibold tracking-wide leading-relaxed" name="" id="" cols="30" rows="3">@{{messages.text_field}}</textarea>
        </div>
        
        <div class="flex justify-center items-center">
            <a v-on:click="send_message(event)" class="bg-teal-600 text-white rounded-lg text-lg ml-2 md:ml-3 p-1 md:p-4 cursor-pointer"><svg class="h-8 w-auto" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7l4-4m0 0l4 4m-4-4v18"></path></svg></a>

            <a class="bg-teal-600 text-white rounded-lg text-lg ml-2 md:ml-3 p-1 md:p-4 "><svg class="h-8 w-auto" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></a>
        </div>
    </div>
</div>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            inbox: false,
            cog: false,
            user_list: [
            ],
            active_user: {
                name: 'Welcome',
                search:'',
                active: '',
                image: '',
            },
            messages: {
                index: 0,
                user: '',
                text_field: '',
                page:1,
                texts: [
                ]
            },
            interval: {
                userList:null,
                inbox:null,
            }
        },
        methods: {
            select_active_user: function(username) {
                obj = this.get_user(username)
                if (obj == null) {return}
                this.messages.user = obj.username
                this.active_user.name = obj.name
                this.active_user.active = obj.active
                this.active_user.image = obj.image
                app.messages.texts = []
                app.messages.page = 0
                app.inbox =  false
                this.get_messages();
            },
            get_user: function(username) {
                for (i=0; i < this.user_list.length; i++)
                {

                    if (this.user_list[i].username == username)
                    {
                        return this.user_list[i]
                    }
                }
            },
            get_messages: function(){

                if (app.messages.page == -1) {
                    console.log("End of page")
                    return
                }

                axios.post("texts/show?page="   +   app.messages.page   ,   {
                
                    active_user: app.messages.user
                
                }).then(function(res){
                    // app.messages.texts.push( res.data)
                    for (i=0; i <    res.data.data.length;    i++) {
                        app.messages.texts.push(res.data.data[i])
                    }

                    app.messages.page = (res.data.last_page > app.messages.page ? (res.data.current_page + 1)   : -1)
                })

            },

            search_user: function() {
                string_text = this.active_user.search

                if (string_text == '') {
                    this.get_user_list()
                    return
                }

                axios.post("{{route('texts.search_user')}}",{
                    'string_text' : string_text,
                }).then( function(res){
                    app.user_list = res.data
                });
            },

            send_message: function(event) {
                
                if (event.shiftKey == true) {return}

                axios.post("{{route('texts.store')}}",{
                    
                    recpt: app.messages.user,
                    text: app.messages.text_field
               
                }).then(function(res){
               
                    app.messages.texts.unshift(res.data)
                    console.log(res)                    

                });

                this.messages.text_field = ''
            },
            
            get_user_list: function() {

                axios.get('/texts').then(function(res){
                    app.user_list = res.data
                    console.log(res)
                })
            },

            get_new_messages: function() {
                axios.post("{{route('texts.show_new')}}"  ,   {
                   active_user: app.messages.user
                }).then(function(res){
                    for (i=0; i <    res.data.length;    i++) {
                        app.messages.texts.unshift(res.data[i])
                    }
                    })
            },

            delete_msgs: function() {
                axios.post("{{route('texts.destroy')}}",  {
                    active_user: app.messages.user
                }).then(function(res){
                    app.messages.texts = []
                })
            },

            bootstrap: function() {
                this.interval.userList = setInterval( function(){ 
                    if (app.active_user.search == '') { app.get_user_list();}
                }, 10000);

                this.interval.inbox = setInterval(function(){ 
                    if (app.messages.user != '') {app.get_new_messages(); }
                }, 10000);
            }
        }
    });
    app.bootstrap()
    </script>
@endsection