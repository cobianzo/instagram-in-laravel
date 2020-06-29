<!-- logged in Dashboard template -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="form-group row">
                <h2>{{ __('Create a new post') }}</h2>
            </div>

            <form action='/p/store' enctype="multipart/form-data" method="post">
                
                @csrf

                <div class="form-group row">
                    <label for="caption" class="col-form-label d-block w-100">
                        {{ __('Post caption') }}
                    </label>

                    <div class="d-block">
                        <input  id="caption"
                                name="caption"
                                type="text"
                                class="form-control @error('caption') is-invalid @enderror"
                                caption="caption"
                                value="{{ old('caption') }}" 
                                autocomplete="caption" autofocus >

                        @error('caption')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="caption" class="col-form-label d-block w-100">
                        {{ __('Post image') }}
                    </label>
                    <input  type="file"
                            id="image"
                            name="image"
                            class="form-control-file"
                    />
                    @error('image')
                        <strong class="">{{ $message }}</strong>
                    @enderror
                </div>


                <div class="form-group row mt-5">
                    <button type="submit" class="btn btn-success">{{ __('Create Post') }} </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
