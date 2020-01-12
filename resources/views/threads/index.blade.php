@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @forelse ($threads as $thread)
            <div class="card mt-3">
                <div class="card-header">
                    <h3 style="display:inline">
                        <a class="text-success" href="{{ $thread->path() }}">
                            @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                            <strong>
                                {{ $thread->title }}
                            </strong>
                            @else
                            {{ $thread->title }}
                            @endif
                        </a>
                    </h3>
                    <span class="badge badge-info">
                        {{ $thread->replies_count }} {{ Str::plural('Reply', $thread->replies_count) }}
                    </span>
                    <span class="badge badge-warning"> {{ $thread->channel->name }} </span>
                </div>

                <div class="card-body">
                    <article>
                        <p style="font-size:1.1em; letter-spacing: 1px">{{ $thread->body }}</p>
                    </article>
                </div>
            </div>
            @empty
            <p> There Is Nothing Here Yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
