@extends ('layouts.app')

@section ('content')

<div class="col-md-8 m-auto">
    <div class="card">
        <h1 class="p-3">
            {{ $profileUser->name }}
            <small class="lead"> Since {{ $profileUser->created_at->diffForHumans() }} </small>
        </h1>
    </div>

    <div class="col-md-11 mx-auto">
        @forelse ( $activities as $date => $activity)
        <h3 style="color:#333;" class="my-5"> {{ $date }} </h3>
        <hr>

        @foreach ( $activity as $record )
        @if (view()->exists("profiles.activities.{$record->type}"))
        @include ("profiles.activities.{$record->type}", ['activity' => $record])
        @endif
        @endforeach
        @empty
        <h5 class="text-muted m-4"> There is no Activity here YET!!! </h5>
        @endforelse
    </div>
</div>

@endsection
