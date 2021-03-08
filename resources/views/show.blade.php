@extends('layouts.layout')


@section('content')

<main>

    <div class="container">

      <div class="container show-user-name">
        <a href="/profile/{{ $character->user_id }}">{{ $character->user->name }}</a>
      </div>
      <div class="gallery  detail-gallery">

        <div class="gallery-item gallery-item-none" tabindex="0">
          
          <img src="{{ $character->image_file }}" class="gallery-image detail-image" alt="">
          
        </div>
        
      </div><!-- .gallery .detail-gallary-->
      
      <div class="container detail-gallery-item">
        <p>{{ $character->title }}</p>
      </div>
      @auth
        @if ($character->user_id === $login_user_id)
      <div class="container detail-gallery-item">
        <a href="{{ route('chara.edit', ['id' => $character->id]) }}" class='button'>編集</a>
        {{ Form::open(['method' => 'delete', 'route' => ['chara.destroy',  $character->id ]]) }}
          {{ Form::submit('削除', ['class' => 'button']) }}
        {{ Form::close() }}
      </div>
        @endif
      @endauth
      <div class="container detail-gallery-item">
        <a href="{{ route('chara.list') }}">一覧へ戻る</a>
      </div>

    </div><!-- .container-->
      
  </main>

@endsection