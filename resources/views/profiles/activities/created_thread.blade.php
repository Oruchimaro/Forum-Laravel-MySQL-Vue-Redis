@component ('profiles.activities.activity')

@slot ('color')
bg-success
@endslot

@slot ('heading')

{{ $profileUser->name }} Published :
<a href="{{ $activity->subject->path() }}" class="text-white" style="font-size: 1.2em;">
	{{ $activity->subject->title }}
</a>

@endslot

@slot ('body')

{{ $activity->subject->body }}

@endslot

@endcomponent
