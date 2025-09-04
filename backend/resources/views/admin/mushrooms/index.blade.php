@extends('admin.layouts.app')

@section('title')
    Mushrooms
@endsection

@section('content')
    <div class="row my-5">
        <div class="col-md-3">
            @include('admin.layouts.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h3 class="mt-2">
                        Mushrooms ({{ $mushrooms->count() }})
                    </h3>
                    <a href="{{route('admin.mushrooms.create')}}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div
                        class="table-responsive"
                    >
                        <table
                            class="table"
                        >
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Positives</th>
                                <th>Negatives</th>
                                <th>Qr Code</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($mushrooms as $key => $mushroom)
                                <tr>
                                    <td>{{ $key += 1 }}</td>
                                    <td>{{ $mushroom->name }}</td>
                                    <td>{{ Str::limit($mushroom->description, 100) }}</td>
                                    <td>
                                        <img src="{{asset($mushroom->image_path)}}"
                                             alt="{{ $mushroom->name }}"
                                             class="img-fluid rounded mb-1"
                                             width="60"
                                             height="60"
                                        >
                                    </td>
                                    <td>
                                        @if ($mushroom->positives->count())
                                            <ul>
                                                @foreach ($mushroom->positives as $positive)
                                                    <li class="d-flex flex-column">
                                                        <strong> {{ $positive->name }}</strong>
                                                        <p>
                                                            {{ $positive->description }}
                                                        </p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="badge bg-danger">
                                                    N/A
                                                </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($mushroom->negatives->count())
                                            <ul>
                                                @foreach ($mushroom->negatives as $negative)
                                                    <li class="d-flex flex-column">
                                                        <strong> {{ $negative->name }}</strong>
                                                        <p>
                                                            {{ $negative->description }}
                                                        </p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="badge bg-success">
                                                    N/A
                                                </span>
                                        @endif
                                    </td>
                                    <td>
                                        <img src="{{asset($mushroom->qr_code_path)}}"
                                             alt="{{ $mushroom->name }}"
                                             class="img-fluid rounded mb-1"
                                             width="60"
                                             height="60"
                                        >
                                    </td>
                                    <td>
                                        <a href="{{route('admin.mushrooms.edit',$mushroom->id)}}" class="btn btn-sm btn-warning mb-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#"
                                           onclick="deleteItem({{$mushroom->id}})"
                                           class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <form id="{{$mushroom->id}}" action="{{route('admin.mushrooms.destroy',$mushroom->id)}}" method="post">
                                            @csrf
                                            @method("DELETE")
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
