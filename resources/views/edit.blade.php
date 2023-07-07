@extends('master')

@section('title')
    Update
@endsection

@section('content')
    <div class="container mt-5 mb-3">
        <div class="row">
            <div class="col-6 offset-3 ">
                <div class="my-3 fs-5">
                    <a href="{{ route('post#updatePage', $post['id']) }}" class="text-decoration-none text-dark"><i
                            class="fa-solid fa-arrow-left"></i> back</a>
                </div>
                {{-- <h3>{{ $post["title"] }}</h3>
                <p class="text-muted">{{ $post["description"] }}</p> --}}
                <form action="{{ route('post#update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="postId" value="{{ $post['id'] }}">
                    <div class="mb-3">
                        <label for="" class="form-label">Post Title</label>
                        <input type="text" name="postTitle"
                            class="form-control mb-3 @error('postTitle') is-invalid @enderror"
                            value="{{ old('postTitle', $post['title']) }}" placeholder="Enter post title">
                        @error('postTitle')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="postImage" class="form-label">Image</label>
                        <div>
                            @if ($post["image"] == null)
                                <img src="{{ asset('default-image.jpg') }}" class="img-fluid img-thumbnail shadow-sm"
                                    alt="">
                            @else
                                <img src="{{ asset('storage/' . $post['image']) }}" class="img-fluid img-thumbnail shadow-sm"
                                    alt="">
                            @endif
                        </div>
                        <input type="file" name="postImage" class="form-control mb-3">
                        @error('postImage')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label ">Post Description</label>
                        <textarea class="form-control mb-3 @error('postTitle') is-invalid @enderror" name="postDescription" id=""
                            cols="30" rows="15" placeholder="Enter post description">{{ old('postDescription', $post['description']) }}</textarea>
                        @error('postDescription')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="postAddress" value="{{ old('postAddress', $post['address']) }}"
                            class="form-control @error('postAddress') is-invalid @enderror" id="address"
                            placeholder="Enter address">

                        @error('postAddress')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">price (must be between 2000 and 50000)</label>
                        <input type="text" name="postPrice" value="{{ old('postPrice', $post['price']) }}"
                            class="form-control @error('postPrice') is-invalid @enderror" id="price"
                            placeholder="Enter price">

                        @error('postPrice')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating (must be between 0 and 5)</label>
                        <input type="number" name="postRating" value="{{ old('postRating', $post['rating']) }}"
                            min="0" max="5"class="form-control @error('postRating') is-invalid @enderror"
                            id="rating" placeholder="Enter rating">

                        @error('postRating')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="text-end mb-3">
                        <button type="submit" class="btn btn-dark">Update</button>
                    </div>



                </form>

            </div>

        </div>



    </div>
    </div>
@endsection
