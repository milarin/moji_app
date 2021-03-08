@extends('layouts.layout')


@section('content')

<header>

<div class="container">

  <div class="profile">

    @empty($user->user_image)
    <div class="profile-image">

      <img src="https://images.unsplash.com/photo-1513721032312-6a18a42c8763?w=152&h=152&fit=crop&crop=faces" alt="">

    </div>
    @endempty
    @isset($user->user_image)
    <div class="profile-image">

      <img src="{{ $user->user_image }}" alt="">

    </div>
    @endisset
    
    <div class="profile-user-settings">
      
      <h1 class="profile-user-name">{{ $user->name }}</h1>
      @auth
        @if ($user->id === $login_user_id)
      <a href="{{ route('user.edit', ['id' =>  $user->id]) }}" class="prof-btn profile-edit-btn">Edit Profile</a>
        @endif
      @endauth

    </div>


    <div class="profile-bio">

      <p> {{ $user->content }}</p>

    </div>

  </div>
  <!-- End of profile section -->

</div>
<!-- End of container -->

</header>


<main>

<div class="container">

  <div class="gallery">
    
    @foreach ($character as $chara)
    <div class="gallery-item" tabindex="0">
      <a href="/character/{{ $chara->id }}">
        <img src="{{ $chara->image_file }}" class="gallery-image" alt="">
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
  
</div><!-- .container -->

</main>

<a href="{{ route('chara.new') }}">
<div class="icon icon--plus">
    <span class="icon_mark"></span>
</div>
</a>


@endsection