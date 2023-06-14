@extends('layouts.app')

@section('content')

    <div class="prose ml-4">
        <h2>メッセージ 一覧</h2>
    </div>

    @if (isset($taskes))
        <table class="table table-zebra w-full my-4">
            <thead>
                <tr>
                    <th>ステータス</th>
                    <th>メッセージ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($taskes as $task)
                <tr>
                    <td><a class="link link-hover text-info" href="{{ route('taskes.show', $task->id) }}">{{ $task->id }}</a></td>
                    <td>{{ $task->status }}</td>
                    <td>{{ $task->content }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    {{-- メッセージ作成ページへのリンク --}}
    <a class="btn btn-primary" href="{{ route('taskes.create') }}">新規メッセージの投稿</a>

@endsection