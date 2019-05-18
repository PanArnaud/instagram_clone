@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-8">
      <img class="w-100" src="/storage/{{ $post->image }}">
    </div>
    <div class="col-4">
      <div class="d-flex align-items-center">
        <div class="pr-3">
          <img class="rounded-circle w-100" style="max-width: 40px;" src="{{ $post->user->profile->profileImage() }}" alt="">
        </div>
        <div>
          <div class="d-flex align-items-center font-weight-bold">
            <a href="/profile/{{ $post->user->id }}">
              <span class="text-dark">{{ $post->user->username }}</span>
            </a>
            <follow-button user-id="{{ $post->user->id }}" follows="{{ $follows }}"></follow-button>
          </div>
        </div>
      </div>
  
      <hr>

      <p class="mb-1">
        <span class="font-weight-bold">
          <a href="/profile/{{ $post->user->id }}">
            <span class="text-dark">
              {{ $post->user->username }}
            </span>
          </a>
        </span>
        {{ $post->caption }}
      </p>
      @foreach($comments as $comment)
        <p class="mb-0">
          <span class="font-weight-bold">
            <a href="/profile/{{ $comment->user_id }}">
              <span class="text-dark">
                {{ $comment->user->username }}
              </span>
            </a>
          </span>
          {{ $comment->content }}
        </p>
      @endforeach

      <hr>

      <form action="/p/{{ $post->id }}/comment/add" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="input-group mb-3">
          <input id="content" name="content" type="text" class="form-control  @error('content') is-invalid @enderror" placeholder="..." aria-label="..." aria-describedby="button-submit-comment" required>

          @error('content')
            <strong>{{ $message }}</strong>
          @enderror

          <button class="btn btn-outline-secondary" hidden type="submit" id="button-submit-comment">+</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
