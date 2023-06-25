<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    public function index()
    {
        $taskes = [];
        if (\Auth::check()) { // 認証済みの場合
        
            // 認証済みユーザを取得
            $user = \Auth::user();

            // メッセージ一覧を取得
            $task = Task::where('user_id', $user->id)->get();
            // メッセージ一覧ビューでそれを表示
            // dd($task);
            return view('taskes.index', [     // 追加
                'taskes' => $task,        // 追加
            ]);
        }

        return view('dashboard');
    }

    public function create()
    {
        $task = new Task;

        // メッセージ作成ビューを表示
        return view('taskes.create', [
            'task' => $task,
        ]);
    }

    // postでmessages/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        // dd($request);
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required',
        ]);
        
        // メッセージを作成
        $task = new Task;
        $task->content = $request->content;
        $task->status = $request->status;
        $task->user_id = \Auth::user()->id;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    // getでmessages/idにアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        $result = \App\Models\Task::findOrFail($id);
        if (\Auth::id() === $result->user_id) {
            // idの値でメッセージを検索して取得
            $task = Task::findOrFail($id);
    
            // メッセージ詳細ビューでそれを表示
            return view('taskes.show', [
                'task' => $task,
            ]);
        }

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    // getでmessages/id/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        $result = \App\Models\Task::findOrFail($id);
        if (\Auth::id() === $result->user_id) {
            // idの値でメッセージを検索して取得
            $task = Task::findOrFail($id);
    
            // メッセージ編集ビューでそれを表示
            return view('taskes.edit', [
                'task' => $task,
            ]);
        }
        // トップページへリダイレクトさせる
        return redirect('/');
    }

    // putまたはpatchでmessages/idにアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',   // 追加
            'content' => 'required',
        ]);
        $result = \App\Models\Task::findOrFail($id);
        if (\Auth::id() === $result->user_id) {
            // idの値でメッセージを検索して取得
            $task = Task::findOrFail($id);
            // メッセージを更新
            $task->content = $request->content;
            $task->save();
        }
        // トップページへリダイレクトさせる
        return redirect('/');
    }

    // deleteでmessages/idにアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        $result = \App\Models\Task::findOrFail($id);
        if (\Auth::id() === $result->user_id) {
            // idの値でメッセージを検索して取得
            $task = Task::findOrFail($id);
            // メッセージを削除
            $task->delete();
        }

        // トップページへリダイレクトさせる
        return redirect('/');
    }
}
