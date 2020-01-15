@extends ('layouts.app')

@section ('content')

<div class="col-md-8 m-auto">
    <avatar-form :user="{{ $profileUser }}"></avatar-form>


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
