@extends('layouts.app')

@section('content')
<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
    <div class="container">
        <div class="row ">
            <div class="col-md-8">

                <!-- Thread Card -->
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('profiles.show', $thread->creator->name) }}">
                            {{ $thread->creator->name }}
                        </a> posted:
                        <strong>{{ $thread->title }}</strong>
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                    <div class="card-footer">
                        @can('update', $thread)
                        <form action="{{ $thread->path() }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        @endcan
                    </div>
                </div>


                <replies :data="{{ $thread->replies }}" @removed="repliesCount--"></replies>

                {{--<!-- Pagination Links For Replies -->
            {{ $replies->links() }} --}}


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
                            and currently has <span v-text="repliesCount"></span> {{ Str::plural('Reply', $thread->replies_count) }}.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>
@endsection
