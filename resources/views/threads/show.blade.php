@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> {{ $thread->title }} </div>

                <div class="card-body">
                        {{ $thread->body }}
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach ($thread->replies as $reply)            
            <div class="card">
                <div class="card-header">
                    <a href="#">{{ $reply->owner->name }}</a> said 
                    <span class="text-muted">{{ $reply->created_at->diffForHumans() }}... </span>
                </div>
                <div class="card-body"  style="color:darkslateblue">
                    {{ $reply->body }}
                </div>
            </div>
            @endforeach
        </div>
    </div>


</div>
@endsection
