@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			@forelse ($threads as $thread)
			<div class="card mt-3">
				<div class="card-header">
					<h4 style="display:inline">
						<a class="lead text-success" style="font-size: 1.5em; font-weight: 800;" href="{{ $thread->path() }}"> {{ $thread->title }}</a>
					</h4>
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
