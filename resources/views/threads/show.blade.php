@extends('layouts.app')

@section ('header')
<link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection

@section('content')
<thread-view :thread="{{ $thread }}" inline-template>
    <div class="container">
        <div class="row ">
            <div class="col-md-8">

                <!-- Thread Card -->
                <div class="card">
                    <div class="card-header">
                        <img src="{{ $thread->creator->avatar() }}" width="50" height="50" class="mr-1" alt="Avatar">

                        <a href="{{ route('profiles.show', $thread->creator->name) }}">
                            {{ $thread->creator->name }}
                        </a> posted:
                        <strong>{{ $thread->title }}</strong>
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                    <div class="card-footer">
                        @can('update', $thread)
                        <form action="{{ $thread->path() }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        @endcan
                    </div>
                </div>


                <replies @added="repliesCount++" @removed="repliesCount--"></replies>


            </div>

            <!-- Right Column -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>
                            This Thread was published <strong class="text-success">{{ $thread->created_at->diffForHumans() }}</strong>
                            By : <a href="#" class="text-success">{{ $thread->creator->name }}</a>
                            and currently has <span v-text="repliesCount"></span> {{ Str::plural('Reply', $thread->replies_count) }}.
                        </p>


                        <p>
                            <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}" v-if="signedIn"></subscribe-button>
                            <button class="btn btn-secondary btn-block m-2" v-if="authorize('isAdmin')" @click="toggleLock">
                                <i v-if="!locked" class="fa fa-eye-slash fa-2x"></i> <i v-if="locked" class="fa fa-eye fa-2x"></i>
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>
@endsection
