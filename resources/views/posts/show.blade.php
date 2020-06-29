<!-- logged in Dashboard template -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-1">
            
            <img class='img-fluid' src={{ '/storage/'. $post->image }} />
            
        </div>
        <div class="col-md-2">
            <h2>{{ $post->user->username }}</h2>
            <p>{{ $post->caption }}</p>
        </div>

    </div>
</div>
@endsection
