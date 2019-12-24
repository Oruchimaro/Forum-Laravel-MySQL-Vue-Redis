<div id="reply-{{ $reply->id }}" class="card my-3">
    <div class="card-header d-flex">
        <div style="flex: 1">
            <a href="{{ route('profiles.show', $reply->owner->name ) }}">
                {{ $reply->owner->name }}
            </a> said
            <span class="text-muted">{{ $reply->created_at->diffForHumans() }}... </span>
        </div>
        <div>
            <form action="{{ route('replies.favorite', $reply->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-secondary" {{ $reply->isFavorited() ? 'disabled' : '' }}>

                    {{ $reply->favorites_count }}
                    {{ Str::plural('Favorite',  $reply->favorites_count ) }}
                </button>
            </form>
        </div>
    </div>
    <div class="card-body" style="color:darkslateblue">
        {{ $reply->body }}
    </div>

    <div class="card-footer">
        @can ('update', $reply)
        <form method="POST" action="{{ route('replies.delete', $reply->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">DELETE </button>
        </form>
        @endcan
    </div>
</div>
