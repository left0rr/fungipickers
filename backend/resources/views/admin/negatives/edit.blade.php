@extends('admin.layouts.app')

@section('title')
    Edit recipe
@endsection

@section('content')
    <div class="row my-5">
        <div class="col-md-3">
            @include('admin.layouts.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-white">
                    <h3 class="mt-2">
                        Edit recipe
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <form action="{{route('admin.negatives.update',$negative->id)}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                @method("PUT")
                                <div class="mb-3">
                                    <label for="mushroom_id" class="form-label">mushroom*</label>
                                    <select
                                        class="form-select @error('mushroom_id') is-invalid @enderror"
                                        name="mushroom_id"
                                        id="mushroom_id"
                                    >
                                        <option selected disabled value="">Choose a mushroom</option>
                                        @foreach ($mushrooms as $mushroom)
                                            <option
                                                value="{{$mushroom->id}}"
                                                @selected(old('mushroom_id',$negative->mushroom_id) == $mushroom->id)
                                            >{{$mushroom->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('mushroom_id')
                                    <div class="invalid-feedback">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name*</label>
                                    <input
                                        type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        name="name"
                                        id="name"
                                        placeholder="Name*"
                                        value="{{old('name',$negative->name)}}"
                                    />
                                    @error('name')
                                    <div class="invalid-feedback">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Description*</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              name="description"
                                              id="description" rows="3"
                                              placeholder="Description*"
                                    >{{old('description',$negative->description)}}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-sm btn-dark">
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
