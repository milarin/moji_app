@extends('layouts.layout')




@section('content')

<main>

<div class="container">

  <p>{{ $message }}</p>
  <div class="gallery">

    @foreach($characters as $character)
    <div class="gallery-item" tabindex="0">

      <a href="{{ route('chara.detail', ['id' =>  $character->id]) }}">
        <img src="{{ $character->image_file }}" class="gallery-image" alt="">
      </a>
        
    </div>
    @endforeach
    
    <div class="gallery-item" tabindex="0">
  
      <div class="gallery-image gallery-item-none"></div>
  
    </div>

    <div class="gallery-item" tabindex="0">
  
      <div class="gallery-image gallery-item-none"></div>
  
    </div>
  </div><!-- gallery -->
  {{ $characters->appends(Request::query())->links() }}
  
</div><!-- .container -->

</main>

@endsection
