@extends ('layouts.app')
@section ('header')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
@section ('content')
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
                            <input name="title" id="title" placeholder="Title..." class="form-control" value="{{ old('title') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="channel_id">Select Channel</label>
                            <select name="channel_id" id="channel_id" required class="form-control" placeholder="choose">
                                <option value="">Choose One...</option>
                                @foreach ( $channels as $channel ) {{--$channelsDoc6--}}
                                <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>

                                    {{ $channel->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="body">Body</label>

                            <wysiwyg name="body"></wysiwyg>
                            {{-- <textarea name="body" id="body" rows="10" placeholder="have anything to say..." class="form-control" required>{{ old('body') }}</textarea> --}}
                        </div>

                        <!-- RECAPTCHA -->
                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="6LcDQtAUAAAAALPe9BOxWA-6zIrVBWlwIgCag9mT"></div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Publish</button>
                        </div>


                        @if (count($errors))
                        @foreach ($errors->all() as $error)
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
