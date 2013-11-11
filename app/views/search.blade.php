@extends('layouts/master')

@section('content')


    @if($errors->count() > 0)

    <h2>Ooops! <small>There was a problem with your search query</small></h2>

    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $message)
            <li>{{$message}}</li>
            @endforeach
        </ul>
    </div>

    @else

        <?php var_dump($projects->toArray()); ?>

        <?php var_dump($users->toArray()); ?>

    @endif



@stop
