<!-- logged in Dashboard template -->
@extends('layouts.app')

@section('content')
<div class="container">
    @foreach ($users as $user)
        <div class="row my-3">
            <a  class="d-flex flex-column col-4 d-flex align-items-center justify-content-baseline"
                href="{{ url('/profile/' . $user->username) }}">
               <h1>{{ $user->name }}</h1>
                <img class='img-fluid rounded-circle' src='{{ '/storage/' . $user->profile->image }}'
                    alt='profile pic' style="max-height: 200px"/>
            </a>
            @foreach( $user->latestPosts(2) as $post ) 
                <a  class='col-4'                    
                    href='/p/{{ $post->id }}'>
                    <img class='img-fluid' src='{{ '/storage/' . $post->image }}' alt='image'/>
                    @if ( !empty($post->caption) )
                        <caption>{{$post->caption}}</caption>
                    @endif
                </a>
                
            @endforeach 
        </div>
    @endforeach
</div>
@endsection
