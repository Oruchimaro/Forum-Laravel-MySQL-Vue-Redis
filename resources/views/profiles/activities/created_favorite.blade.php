@component ('profiles.activities.activity')

@slot ('color')
bg-warning
@endslot

@slot ('heading')

<a href="{{ $activity->subject->favorited->path() }}" class="text-white" style="font-size: 1.2em;">
    {{ $profileUser->name }} Favorited a Reply.
</a>


@endslot

@slot ('body')

{{ $activity->subject->favorited->body }}

@endslot

@endcomponent
