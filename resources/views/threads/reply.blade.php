<div class="card my-3" >
    <div class="card-header">
        <a href="#">{{ $reply->owner->name }}</a> said 
        <span class="text-muted">{{ $reply->created_at->diffForHumans() }}... </span>
    </div>
    <div class="card-body"  style="color:darkslateblue">
        {{ $reply->body }}
    </div>
</div>