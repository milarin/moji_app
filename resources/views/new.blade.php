@extends('layouts.layout')


@section('content')

<main>

    <div class="container create">

      <h1>新規投稿</h1>
        @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif

      {{ Form::open(['route' => 'chara.store', 'files' => true]) }}
          <div class='form-group'>
              {{ Form::label('title', 'タイトル:') }}
              {{ Form::text('title', null) }}
          </div>
          <div class='form-group'>
              {{ Form::label('image_file', 'ファイル:') }}
              {{ Form::file('image_file', null) }}
          </div>
          <div class="form-group">
              {{ Form::submit('作成する', ['class' => 'button']) }}
          </div>
      {{ Form::close() }}

      <div>
          <a href="{{ route('chara.list') }}">一覧に戻る</a>
      </div>
    </div><!-- .container-->
      
</main>

@endsection