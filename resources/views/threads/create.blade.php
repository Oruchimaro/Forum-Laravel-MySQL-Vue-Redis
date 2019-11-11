@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create New Threads</div>

                <div class="card-body">
                    <form action="/threads" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input name="title" id="title" placeholder="Title..." class="form-control" value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                            <label for="channel_id">Select Channel</label>
                            <select name="channel_id" id="channel_id" class="form-control">
                                <option >Choose One...</option>
                                @foreach (App\Channel::all() as $channel)
                                    <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea name="body" id="body" rows="10" placeholder="have anything to say..." class="form-control">{{ old('body') }}</textarea>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Publish</button>
                        </div>


                        @if (count($errors))
                            @foreach ($errors as $error)
                            <ul class="alert alert-danger">
                                <li>{{ $error }}</li>
                            </ul>
                            @endforeach
                        @endif
                    </form>
                </div>
            </div>    
        </div>
    </div>
</div>
@endsection