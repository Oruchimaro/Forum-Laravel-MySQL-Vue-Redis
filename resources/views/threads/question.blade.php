<!-- Editing -->
<div class="card" v-if="editing">
    <div class="card-header d-flex">
        <input class="form-control" type="text" v-model="form.title">
        <div class="">
            <form action="{{ $thread->path() }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger mx-2">DELETE </button>
            </form>
        </div>
    </div>

    <div class="card-body">
        <div class="form-group">
            <wysiwyg v-model="form.body" :value="form.body"></wysiwyg>
        </div>
    </div>
    <div class="card-footer">
        @can('update', $thread)
        <div class="d-flex ">
            <button class="btn btn-outline-primary flex-fill" @click="update">Submit</button>
            <button class="btn btn-outline-danger flex-fill" @click="resetForm">Cencel</button>
        </div>
        @endcan
    </div>
</div>

<!-- Viewing -->
<div class="card" v-else>
    <div class="card-header">
        <img src="{{ $thread->creator->avatar() }}" width="50" height="50" class="mr-1" alt="Avatar">

        <a href="{{ route('profiles.show', $thread->creator->name) }}">
            {{ $thread->creator->name }}
        </a> posted:
        <strong v-text="title"></strong>
    </div>

    <div class="card-body" v-html="body"></div>


    <div class="card-footer d-flex justify-content-end" v-if="authorize('owns', thread)">
        @can('update', $thread)

        <!-- update sect -->
        <button class="btn btn-warning btn-block mx-2" @click="editing = true">Update</button>
        @endcan
    </div>
</div>
