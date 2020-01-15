@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center ">
        <div class="col-md-8 ">
            @include ('threads.list')
        </div>
    </div>
    <div class="row justify-content-center my-4 ">
        {{ $threads->render() }}
    </div>


</div>
@endsection
