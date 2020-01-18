@forelse ($threads as $thread)

<div class="card mt-3 ">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>

            <h3 style="display:inline">
                <a class="text-dark" href="{{ $thread->path() }}">
                    @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                    <strong>
                        {{ $thread->title }}
                    </strong>
                    @else
                    {{ $thread->title }}
                    @endif
                </a>
            </h3>
            <h5><img src="{{ $thread->creator->avatar() }}" width="30" height="30" class="mr-1" alt="Avatar">
                <a href="{{ route('profiles.show', $thread->creator) }}">{{ $thread->creator->name }}</a></h5>
        </div>
        <div class="d-flex">
            <span class="badge badge-info badge-pill p-1 m-1 flex-fill">
                {{ $thread->replies_count }} {{ Str::plural('Reply', $thread->replies_count) }}
            </span>
            <span class="badge badge-dark p-1 m-1 flex-fill"> {{ $thread->channel->name }} </span>
        </div>
    </div>

    <div class="card-body">
        <article>
            <p style="font-size:1.1em; letter-spacing: 1px">{!! $thread->body !!}</p>
        </article>
    </div>
    <div class="card-footer">
        {{ $thread->visits }} {{ Str::plural('View', $thread->visits ) }}
    </div>
</div>

@empty

<p> There Is Nothing Here Yet.</p>

@endforelse
