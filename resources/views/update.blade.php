@extends('master')

@section('title')
    Update
@endsection

@section('content')
    <div class="container mt-5 mb-3">
        <div class="row">
            <div class="col-6 offset-3 ">
                <div class="my-3 fs-5">
                    <a href="{{ route('post#home') }}" class="text-decoration-none text-dark"><i
                            class="fa-solid fa-arrow-left"></i> back</a>
                </div>
                <div class="mt-2">
                    <button class="btn btn-sm btn-dark">
                            <i class="fa-solid fa-dollar-sign text-primary"></i> {{ $post->price }} kyats
                    </button>
                    <button class="btn btn-sm btn-dark">

                            <i class="fa-sharp fa-solid fa-location-dot text-danger"></i> {{ $post['address'] }}
                    </button>
                    <button class="btn btn-sm btn-dark">
                            <i class="fa-solid fa-star text-warning"></i> {{ $post['rating'] }}

                    </button>
                    <button class="btn btn-sm btn-dark">
                        <i class="fa-solid fa-calendar"></i> {{ $post['created_at']->format('d-M-Y') }}
                    </button>
                    <button class="btn btn-sm btn-dark">
                        <i class="fa-solid fa-clock"></i> {{ $post['created_at']->format('h:i A') }}
                    </button>
                </div>
                <h4 class="my-4">{{ $post->title }} </h4>
                <div class="my-3">
                    @if ($post->image == null)
                        <img src="{{ asset('default-image.jpg') }}" class="img-fluid img-thumbnail shadow-sm" alt="">
                    @else
                        <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid img-thumbnail shadow-sm" alt="">
                    @endif
                </div>
                <p class="text-muted">{{ $post['description'] }}</p>


            </div>
        </div>
        <div class="row mt-3">
            <div class="col-3 offset-8">
                <a href="{{ route('post#editPage', $post['id']) }}">
                    <button class="btn btn-dark">Edit</button>
                </a>
            </div>
        </div>
    </div>
@endsection
