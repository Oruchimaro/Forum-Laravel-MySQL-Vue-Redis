@extends ('layouts.app')

@section ('content')

<div class="col-md-8 m-auto">
    @can ('update', $profileUser)
    <div class="d-flex bg-info justify-content-between ">
        <div class="d-flex">
            <img src="{{ $profileUser->avatar() }}" width="100" height="100" alt="Avatar">
            <h1 class="p-3 text-white">
                {{ $profileUser->name }}
                <small class="lead"> Since {{ $profileUser->created_at->diffForHumans() }} </small>
            </h1>
        </div>


        <form method="POST" action="/api/users/{{ $profileUser->id }}/avatar" enctype="multipart/form-data" class="m-2 form-group">
            @csrf
            <div class="input-group">
                <input name="avatar" type="file" class="form-control">
                <button class="btn btn-secondary input-group-append " type="submit">upload</button>
            </div>
        </form>
    </div>
    @endcan

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
