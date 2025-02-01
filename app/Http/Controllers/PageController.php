<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Post;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function dashboard(Request $request){
        
        // dd($request->all());
        // dd($request->get('for-my'));
        // dd($request->user());
        // dd($request->user()->id);
        if($request->get('for-my')){
            $user = $request->user();
            $friends_from_ids = $user->friendsFrom()->pluck('users.id');
            $friends_to_ids   = $user->friendsTo()->pluck('users.id');
            $user_ids         = $friends_from_ids->merge($friends_to_ids)->push($user->id);
            // dd($user_id); 
            // $posts = Post::where('user_id', $request->user()->id)->latest()->get();
            // $posts = $request->user()->posts()->latest()->get();
            $posts = Post::whereIn('user_id', $user_ids)->latest()->get();
        }else{
            $posts = Post::latest()->get();
        }

        // return view('dashboard', ('posts' => $posts));
        return view('dashboard', compact('posts'));
    }
}
