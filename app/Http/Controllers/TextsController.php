<?php

namespace App\Http\Controllers;

use App\texts;
use Illuminate\Http\Request;

class TextsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $username = \Auth::User()->username;
        $texts = texts::select(['recpt','sender'])
            ->where(['sender'=> $username,'send_view'=>1 ]) 
                ->orWhere(['recpt'=> $username,'recpt_view'=>1])
                    ->orderBy('created_at','desc')->get();

        $senders = $texts->pluck('sender');
        $recpts = $texts->pluck('recpt');

        $texts = array_merge($senders->toArray(),$recpts->toArray());
        $texts = array_unique($texts);

        $texts = array_filter($texts, function($in){
            return $in != \Auth::user()->username;
        });


        $user = \App\User::select('username','name','dp as image','last_seen as active')->whereIn('username',$texts)->get();
        
        $user->map(function($u){
            $u->active = \Carbon\Carbon::parse($u->active)->diffForhumans();
        });

        return response()->json($user);
    }

    public function search_user(Request $request)
    {
        try {

            $data = $request->validate([
                'string_text'=>"required|min:1",
            ]);

            $string_text = $data['string_text'];

            $user = \App\User::select('username','name','dp as image','last_seen as active')
                ->where('name', 'LIKE', "%{$string_text}%")
                    ->orderBy('created_at','desc')
                    ->get();
                
            $user->map(function($u){
                $u->active = \Carbon\Carbon::parse($u->active)->diffForhumans();
            });

            $user = $user->filter(function($u) {
                return $u->username != \Auth::user()->username;
            });
    
            return response()->json($user);
            
        } catch (\Exception $e) {
            abort(response($e->getMessage(), 404));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            
            $data = $request->validate([
                'recpt'=>"required|min:1|exists:App\User,username",
                'text'=> "required|min:1"
            ]);

            $message = new texts();
            $message->sender = \Auth::user()->username;
            $message->recpt = $data['recpt'];
            $message->data = nl2br(e($data['text']));
            $message->type = 'text';
            $message->send_view = $message->recpt_view = 1;
            $message->save();

            return response()->json($message);

        }   catch (\Exception $e) {
            
            abort( response($e->getMessage(), 404));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\texts  $texts
     * @return \Illuminate\Http\Response
     */

    public function show(Request $request)
    {
        try {
            $data = $request->validate([
                "active_user" => "required|exists:App\User,username"
            ]);

            $username = \Auth::User()->username;
            $active_user = $data['active_user'];

            $texts = texts::where([
                        'sender'=> $username,   
                        'send_view' =>  1,   
                        'recpt'    =>  $active_user 
                        ])->orWhere([
                        'recpt' =>    $username,    
                        'recpt_view'    =>  1, 
                        'sender'   => $active_user
                        ])->orderBy('created_at','desc')
                        ->paginate(5);
            
             $texts->map(function($seen){
                $seen->seen = now();
                $seen->save();
             });

            return response()->json($texts);

        }   catch (\Exception $e) {
            
            abort( response($e->getMessage(), 404));
        }
    }

    public function new_inbox_texts(Request $request)
    {
        try {

            $data = $request->validate([
                "active_user" => "required|exists:App\User,username"
            ]);

            $username = \Auth::User()->username;
            $active_user = $data['active_user'];

            $texts = texts::where([
                            'recpt' =>   $username,    'recpt_view'    =>  1, 'sender'   => $active_user,    'seen'  =>  null
                                ])->orderBy('created_at','desc')->get();
            
            $texts->map(function($seen){
                $seen->seen = now();
                $seen->save();
                });

            return response()->json($texts);

        }   catch (\Exception $e) {
            
            abort( response($e->getMessage(), 404));
        }

    }

    public function edit(texts $texts)
    {
        //
    }

    public function update(Request $request, texts $texts)
    {
        //
    }

    public function destroy(Request $request)
    {
        //
        try {

            $data = $request->validate([
                "active_user" => "required|exists:App\User,username"
            ]);

            $username = \Auth::User()->username;
            $active_user = $data['active_user'];

           $texts = texts::where([
                'sender'=> $username,   
                'send_view' =>  1,   
                'recpt'    =>  $active_user 
                ])->get();

                dd($texts);
                
            texts::Where([
                'recpt' =>    $username,    
                'recpt_view'    =>  1, 
                'sender'   => $active_user
                ])->update(['recpt_view'=>-1]);
            
                return response()->json(["Status"=>"Okay"]);

        }   catch (\Exception $e) {
            
                abort( response($e->getMessage(), 404));
            }  
    }
}
