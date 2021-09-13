<?php

namespace App\Http\Controllers;

use App\Todo;
use App\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    //ユーザーが作成したすべてのTodoをJSON(JavaScript Object Notation)という形式で送信。
    public function index()
    {
        $todos = $goal->todos()->orderBy('done', 'asc')->orderBy('position', 'asc')->get();
        return response()->json($todos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     
    //送られてきたリクエストの値を使い、新しくGoalを作成。
    public function store(Request $request) //store = 蓄える
    {
        $todo = new Todo();
        $todo->content = request('content');
        $todo->user_id = Auth::id();
        $todo->goal_id = $goal->id;
        $todo->position = request('position');
        $todo->done = false;
        $todo->save();
        $todos = $goal->todos()->orderBy('done', 'asc')->orderBy('position', 'asc')->get();
        return response()->json($todos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
     
    //送られてきたリクエストの値を使い、既存のGoalを更新。
    public function update(Request $request, Todo $todo)
    {
        $todo->content = request('content');
        $todo->user_id = Auth::id();
        $todo->goal_id = $goal->id;
        $todo->position = request('position');
        $todo->done = (bool) request('done');
        $todo->save();

        $todos = $goal->todos()->orderBy('done', 'asc')->orderBy('position', 'asc')->get();
        return response()->json($todos);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
     
    //送られてきたリクエストの値を使い、既存のGoalを削除。
    public function destroy(Todo $todo)
    {
        $todo->delete();
        $todos = $goal->todos()->orderBy('done', 'asc')->orderBy('position', 'asc')->get();
        return response()->json($todos);
    }
    
    
    //Todoを並び替える sortアクションの実装。
    public function sort(Request $request, Goal $goal, Todo $todo)
    {
        $exchangeTodo = Todo::where('position', request('sortId'))->first();
        $lastTodo = Todo::where('position', request('sortId'))->latest('position')->first();

        if (request('sortId') == 0) {
            $todo->moveBefore($exchangeTodo);
        } else if (request('sortId') - 1 == $lastTodo->position) {
            $todo->moveAfter($exchangeTodo);
        } else {
            $todo->moveAfter($exchangeTodo);
        }

        $todos = $goal->todos()->orderBy('done', 'asc')->orderBy('position', 'asc')->get();

        return response()->json($todos);
    }
    
}