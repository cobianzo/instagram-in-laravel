<!-- logged in Dashboard template -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3 text-center p-5 justify-content-center">
            <img class='img-fluid rounded-circle' src='{{ '/storage/' . $user->profile->image }}' alt='profile pic'/>
        </div>
        <div class="col-md-9 pt-5">
            <div class='d-flex justify-content-between'>
                <div class=''>
                    <h2>
                        {{ $user->username }}
                        @if ( !Auth::check() )
                        <a href="{{ route('login') }}">
                        @endif
                            <button 
                                    {{ ( Auth::check() ) ? 'data-follow-profile=' . $user->profile->id . ' '  : "" }} 
                                    class='btn btn-{{ $user->isFollowedByCurrentUser() ? 'warning' : 'success' }}'>
                                {{ $user->isFollowedByCurrentUser() ? __('Unfollow') : __('Follow') }}
                            </button>
                        @if ( !Auth::check() )
                        </a>
                        @endif
                        
                    </h2>
                    @if ( Auth::check() && Auth::user()->id === $user->id )
                        <a href='{{ url('edit-profile') }}' class='small'>
                            Edit profile
                        </a>
                    @endif

                    <h3 class='lead'>
                        <span class='text-muted'>{{ $user->name }}</span>
                        @if ( $user->profile->title ) 
                            {{ $user->profile->title }}
                        @endif
                    </h3>
                </div>
                
                @if ( Auth::check() )
                    <a href='{{ url('/p/create') }}'>{{ __('Create new post') }}</a>
                @endif
            </div>
            
            <ul class='list-unstyled d-flex'>
            <li class='pr-3'>{{ $user->postscount() }} <b>post{{ $user->postscount() === 1 ? '' : 's' }}</b></li>
                <li class='pr-3'>{{ $user->profile->followedBy->count() }} <b>followers</b></li>
                <li class='pr-3'>{{ $user->following->count() }} <b>following</b></li>
            </ul>
            <div class='bold'><b>
                {{ $user->email }}
            </b></div>
            <div class=''>
                {{ $user->profile ? $user->profile->description : '' }}
            </div>
            <div class='bold'><a href='{{ $user->profile? $user->profile->url : ''}}'>
                {{ $user->profile->url ?? 'N/A' }}
            </a></div>
        </div>
    </div>
    <div class='row pt-5'>
        <ul class='col-12 d-flex list-unstyled justify-content-around'>
            <li>Posts</li>
            <li>Tagged</li>
        </ul>
    </div>
    <div class='row'>
        @foreach ($user->posts as $post)
            <a  class='col-6 col-sm-4 mb-4'
                href='/p/{{ $post->id }}'>
                <img class='img-fluid' src='{{ '/storage/' . $post->image }}' alt='image'/>
                @if ( !empty($post->caption) )
                    <caption>{{$post->caption}}</caption>
                @endif
            </a>
        @endforeach
        
    </div>
</div>
@endsection
