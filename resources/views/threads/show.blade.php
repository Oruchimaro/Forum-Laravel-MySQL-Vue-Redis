@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-8">

            <!-- Thread Card -->
            <div class="card">
                <div class="card-header">
                    <a href="#">{{ $thread->creator->name }}</a> posted: 
                    <strong>{{ $thread->title }}</strong>
                </div>

                <div class="card-body">
                        {{ $thread->body }}
                </div>
            </div>


            <!-- Get All Replies -->
            @foreach ($replies as $reply)            
                @include('threads.reply')
            @endforeach

            <!-- Pagination Links For Replies -->
            {{ $replies->links() }}

        
            <!-- Add A Reply -->
            @if (auth()->check())
                <form action="{{ $thread->path() . '/replies' }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <textarea name="body" id="body" rows="10" placeholder="have anything to say..." class="form-control"></textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">Post</button>
                </form>
            @else
                <p>Please <a href="{{ route('login') }}">Sign In</a> to participate!!!</p>
            @endif

        </div>

        <!-- Right Column -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p>
                        This Thread was published <strong class="text-success">{{ $thread->created_at->diffForHumans() }}</strong>
                        By : <a href="#" class="text-success">{{ $thread->creator->name }}</a> 
                        and currently has {{ $thread->replies_count }} {{ Str::plural('Reply', $thread->replies_count) }}.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
