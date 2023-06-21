<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TasksController extends Controller
{
    public function index()
    {
        // メッセージ一覧を取得
        $taskes = Task::where('user_id', $userId)->get();

        // メッセージ一覧ビューでそれを表示
        return view('taskes.index', [     // 追加
            'taskes' => $taskes,        // 追加
        ]);
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
        $userId = \Auth::user()->id;
        $result = Task::where('user_id', $userId)->where('id', $id)->get();
        if (!$result->isEmpty()) {
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
        $userId = \Auth::user()->id;
        $result = Task::where('user_id', $userId)->where('id', $id)->get();
        if (!$result->isEmpty()) {
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
        
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        // メッセージを更新
        $task->content = $request->content;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    // deleteでmessages/idにアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        $userId = \Auth::user()->id;
        $result = Task::where('user_id', $userId)->where('id', $id)->get();
        if (!$result->isEmpty()) {
            // idの値でメッセージを検索して取得
            $task = Task::findOrFail($id);
            // メッセージを削除
            $task->delete();
        }

        // トップページへリダイレクトさせる
        return redirect('/');
    }
}
