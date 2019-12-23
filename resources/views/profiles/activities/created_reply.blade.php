@component ('profiles.activities.activity')

@slot ('color')
bg-primary
@endslot

@slot ('heading')

{{ $profileUser->name }} Replied to :
<a href="{{ $activity->subject->thread->path() }}" class="text-white" style="font-size: 1.2em;">
	{{ $activity->subject->thread->title }}
</a>

@endslot

@slot ('body')

{{ $activity->subject->body }}

@endslot

@endcomponent
