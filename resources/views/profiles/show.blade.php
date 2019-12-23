@extends('layouts.app')

@section('content')

<div class="col-md-8 m-auto">
	<div class="card">
		<h1 class="p-3">
			{{ $profileUser->name }}
			<small class="lead"> Since {{ $profileUser->created_at->diffForHumans() }} </small>
		</h1>
	</div>

	<div class="col-md-11 mx-auto">
		@foreach ( $threads as $thread )
		<div class="card mt-2">
			<div class="card-header">
				<a href="#"> {{ $thread->title }} <a>
						<span> {{ $thread->created_at->diffForHumans() }} </span>
			</div>

			<div class="card-body">
				{{ $thread->body }}
			</div>
		</div>
		@endforeach
	</div>

	<div class="m-5">
		{{ $threads->links() }}
	</div>
</div>

@endsection
