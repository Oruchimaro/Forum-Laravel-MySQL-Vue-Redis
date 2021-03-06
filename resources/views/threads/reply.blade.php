<reply inline-template :attributes="{{ $reply }}" v-cloak>
    <div id="reply-{{ $reply->id }}" class="card my-3">
        <div class="card-header d-flex">
            <div style="flex: 1">
                <a href="{{ route('profiles.show', $reply->owner->name ) }}">
                    {{ $reply->owner->name }}
                </a> said
                <span class="text-muted">{{ $reply->created_at->diffForHumans() }}... </span>
            </div>
            @auth
            <div>
                <favorite :reply="{{ $reply }}"></favorite>
            </div>
            @endauth
        </div>
        <div class="card-body" style="color:darkslateblue">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-sm btn-success" @click="update"> Update </button>
                <button class="btn btn-sm btn-danger" @click=" editing = false "> Cancel </button>
            </div>

            <div v-else v-text="body"></div>
        </div>

        <div class="card-footer d-flex">

            @can ('update', $reply)
            <button class="btn btn-warning btn-sm mr-2" @click="editing = true"> EDIT </button>

            <button class="btn btn-danger btn-sm" @click="destroy"> DELET </button>
            @endcan
        </div>
    </div>
</reply>
