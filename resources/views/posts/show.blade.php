@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-8">
      <img class="w-100" src="/storage/{{ $post->image }}">
    </div>
    <div class="col-4">
      <h3>{{ $post->user->username }}</h3>
      <p>{{ $post->caption }}</p>
    </div>
  </div>
</div>
@endsection
