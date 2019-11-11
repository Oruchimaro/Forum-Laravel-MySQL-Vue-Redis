@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="#">{{ $thread->creator->name }}</a> posted: 
                    <strong>{{ $thread->title }}</strong>
                </div>

                <div class="card-body">
                        {{ $thread->body }}
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach ($thread->replies as $reply)            
                @include('threads.reply')
            @endforeach
        </div>
    </div>

    <div class="row justify-content-center mt-5">
    @if (auth()->check())
            <div class="col-md-8">
                <form action="{{ $thread->path() . '/replies' }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <textarea name="body" id="body" rows="10" placeholder="have anything to say..." class="form-control"></textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">Post</button>
                </form>
            </div>
    @else
        <p>Please <a href="{{ route('login') }}">Sign In</a> to participate!!!</p>
    @endif
    </div>


</div>
@endsection
