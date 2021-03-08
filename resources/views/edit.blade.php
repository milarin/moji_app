@extends('layouts.layout')


@section('content')

<main>

    <div class="container create">

      <h1>{{ $character->title }}の編集</h1>
      @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif
      {{ Form::model($character, ['route' => ['chara.update', $character->id], 'files' => true]) }}
          <div class='form-group'>
              {{ Form::label('title', 'タイトル:') }}
              {{ Form::text('title', null) }}
          </div>
          <div class='form-group'>
              {{ Form::label('image_file', 'ファイル:') }}
              {{ Form::file('image_file', old('image_file')) }}
          </div>
          <div>
            <p>現在の画像</p>
            <img src="{{ $character->image_file }}" alt="image" style="width: 30%; height: auto;"/>
          </div>
          <div class="form-group">
              {{ Form::submit('更新する', ['class' => 'button']) }}
          </div>
      {{ Form::close() }}


      <div>
          <a href="{{ route('chara.list') }}">一覧に戻る</a>
      </div>
    </div><!-- .container-->
      
</main>

@endsection