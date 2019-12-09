@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Forum Threads</div>

                <div class="card-body">
                    @foreach ($threads as $thread)
                        <article>
                            <div>
                                <h4 style="display:inline"><a class="lead" href="{{ $thread->path() }}"> {{ $thread->title }}</a></h4>

                                <span class="badge badge-info">
                                    {{ $thread->replies_count }} {{ Str::plural('Reply', $thread->replies_count) }}
                                </span>
                            </div>
                            <div class="body">{{ $thread->body }}</div>
                            
                        </article>
                        <hr>
                    @endforeach
                </div>
            </div>    
        </div>
    </div>
</div>
@endsection
