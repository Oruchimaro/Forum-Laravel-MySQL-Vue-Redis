@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row  ">
        <div class="col-md-8 ">
            @include ('threads.list')
            <div class="m-3">{{ $threads->render() }}</div>
        </div>
        <div class="col-md-4">
            <div class="card mt-3">
                <div class="card-header bg-dark text-white">
                    <span class="h4"> Trending Threads </span>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse ($trending as $thread)
                        <li class="list-group-item"><a href="{{ $thread->path }}">{{ $thread->title }}</a></li>
                        @empty
                        <p>No Hot Threads HERE !!! </p>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>



</div>
@endsection
