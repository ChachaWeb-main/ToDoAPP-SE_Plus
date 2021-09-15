<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //ログインしているユーザーのTagのみをレスポンスとして返すため

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* indexアクションではユーザーが作成したすべてのTagをJSON(JavaScript Object Notation)という形式で送信。
        Laravelではresponseというヘルパーを使うことでアクションからレスポンスを返すことができ、
        今回はユーザーが作成したすべてのTagをJSON形式でレスポンスとして返しています。*/
        $user = Auth::user();
        $tags = $user->tags;
        return response()->json($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*storeアクションでは送られてきたリクエストの値を使い、新しくTagを作成し、
        indexアクション同様にJSON形式でレスポンスを返す。*/
        $tag = new Tag();
        $tag->title = request('title');
        $tag->user_id = Auth::id();
        $tag->save();

        $user = Auth::user();

        $tags = $user->tags;
        return response()->json($tags);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        //送られてきたリクエストの値を使い、既存のTagを更新。
        $tag->title = request('title');
        $tag->user_id = Auth::id();
        $tag->save();

        $user = Auth::user();

        $tags = $user->tags;
        return response()->json($tags);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        //送られてきたリクエストの値を使い、既存のTagを削除。
        $tag->delete();

        $user = Auth::user();

        $tags = $user->tags;
        return response()->json($tags);
    }
}