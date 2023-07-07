@extends('master')

@section('title')
    Home | Create
@endsection

@section('content')
    <div class="container">
        <div class="row mt-3 ">
            <div class="col-5">

                <div class="p-4">
                    @if (session('successMessage'))
                        <div class="alert-message">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('successMessage') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif




                    {{-- တစ်ခုခု error တက်ခဲ့ရင် errors တွေအားလုံးကို list အနေနဲ့ loop ပတ်ပြီးထုတ်ပေးတာ --}}
                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>

                                @endforeach
                            </ul>
                        </div>
                    @endif --}}

                    <form action="{{ route('post#create') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="postTitle" value="{{ old('postTitle') }}"
                                class="form-control @error('postTitle') is-invalid @enderror" id="title"
                                placeholder="Enter post title">

                            @error('postTitle')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="postDescription" id="description" cols="30" rows="10"
                                class="form-control @error('postDescription') is-invalid @enderror" placeholder="Enter post description...">{{ old('postDescription') }}</textarea>
                            @error('postDescription')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="postAddress" value="{{ old('postAddress') }}"
                                class="form-control @error('postAddress') is-invalid @enderror" id="address"
                                placeholder="Enter address">

                            @error('postAddress')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="postImage" class="form-label">Image</label>
                            <input type="file" name="postImage"
                                class="form-control @error('postImage') is-invalid @enderror" id="postImage" placeholder="">
                            @error('postImage')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">price (must be between 2000 and 50000)</label>
                            <input type="text" name="postPrice" value="{{ old('postPrice') }}"
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

                            <input type="number" name="postRating" value="{{ old('postRating') }}" min="0"
                                max="5" class="form-control @error('postRating') is-invalid @enderror" id="rating"
                                placeholder="Enter rating">

                            @error('postRating')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" value="submit" class="btn btn-danger">Create</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-7">
                <div class="data-container p-4">
                    <div class="row justify-content-between mb-3">
                        <div class="col-4">
                            <h3>Total - {{ $posts->total() }}</h3>
                        </div>
                        <div class="col-6">
                            <form action="{{ route('post#createPage') }}" method="get">
                                <div class="input-group mb-3">
                                    {{-- request('searchKey') => ရှာထားတဲ့ old value ပြချင်လို့ --}}
                                    <input type="text" name="searchKey" value="{{ request('searchKey') }}"
                                        class="form-control" placeholder="Enter Post Title ...">
                                    <button type="submit" class="btn btn-danger" type="button"><i
                                            class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @if (count($posts) != 0)
                        @foreach ($posts as $item)
                            <div class="post p-3 mb-5 shadow-sm">

                                <div class="row d-flex justify-content-between">
                                    <div class="col-7">
                                        <h5>{{ Str::limit($item->title, 30, '...') }} </h5>
                                    </div>
                                    <div class="col-5 text-end">
                                        <h6>{{ $item['created_at']->format('d-m-Y | n:i A') }}</h6>
                                    </div>

                                    {{-- <span>{{ date('d-m-Y ', strtotime($item['created_at'])) }}</span> --}}
                                </div>

                                {{-- php way --}}
                                {{-- <p class="text-muted">{{ substr($item["description"], 0, 20) }}</p> --}}
                                {{-- laravel way  --}}
                                <p class="text-muted">{{ Str::words($item['description'], 10, '...') }}</p>
                                <span>

                                    <i class="fa-solid fa-dollar-sign text-primary"></i>{{ $item->price }} kyats
                                </span> |
                                <span>
                                    <i class="fa-sharp fa-solid fa-location-dot text-danger"></i> {{ $item['address'] }} |
                                </span>
                                <span>
                                    <i class="fa-solid fa-star text-warning"></i> @if($item["rating"]) {{ $item['rating'] }} @else 0 @endif
                                </span>

                                <div class="d-flex justify-content-end gap-3">

                                    <button class="btn btn-sm btn-danger " data-bs-toggle="modal"
                                        data-bs-target="#confirmModal">
                                        <i class="fa-sharp fa-solid fa-trash "></i>
                                        <span class="fw-bold">ဖျက်ရန်</span>
                                    </button>
                                    <form id="remove_post" action="{{ route('post#delete', $item['id']) }}"
                                        method="post">
                                        @csrf
                                    </form>
                                    {{-- <form action="{{ route('post#delete', $item["id"]) }}" method="POST">
                                    @csrf
                                    @method("delete")
                                     <button class="btn btn-sm btn-danger">
                                        <i class="fa-sharp fa-solid fa-trash "></i>
                                        <span class="fw-bold">ဖျက်ရန်</span>
                                    </button>
                                </form> --}}
                                    {{-- get method --}}
                                    {{-- <a href="{{ route('post#delete', $item["id"]) }}" class="btn btn-sm btn-danger">
                                    <i class="fa-sharp fa-solid fa-trash "></i>
                                    <span class="fw-bold">ဖျက်ရန်</span>
                                </a> --}}

                                    <div>
                                        <a href="{{ route('post#updatePage', $item['id']) }}">
                                            <button class="btn btn-sm btn-primary">
                                                <i class="fa-solid fa-file-lines"></i>
                                                <span class="fw-bold">အပြည့်အစုံဖတ်ရန်</span>
                                            </button>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        @if (request('searchKey'))
                            <div style="margin-top: 150px;"
                                class="border border-2 border-dark w-50 text-center mx-auto p-5">
                                <h2 class="text-danger">No data found!</h2>
                            </div>
                        @else
                            <div style="margin-top: 150px;"
                                class="border border-2 border-dark w-50 text-center mx-auto p-5">
                                <h2 class="text-danger">No data</h2>
                            </div>
                        @endif
                    @endif
                    {{ $posts->appends(request()->query())->links() }}
                    <!-- Button trigger modal -->
                    <!-- Modal -->
                    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="confirmModalLabel">Confirmation</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><span
                                            class="fw-bold">ပိတ်သည်</span></button>
                                    <button type="button" class="btn btn-danger"
                                        onclick="document.querySelector('#remove_post').submit()"><span
                                            class="fw-bold">ဖျက်မည်</span></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- @for ($i = 0; $i < count($posts); $i++)
                        <div class="post p-3 mb-5 shadow-sm">
                            <h5>{{ $posts[$i]["title"] }}</h5>
                            <p class="text-muted">{{ $posts[$i]["description"] }}</p>
                            <div class="text-end">
                                <button class="btn btn-sm btn-danger"><i class="fa-sharp fa-solid fa-trash "></i></button>
                                <button class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-file-lines"></i>
                                </button>
                            </div>
                        </div>

                    @endfor --}}


                </div>
            </div>
        </div>
    </div>
@endsection
