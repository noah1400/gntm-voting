@extends('layouts.app')

@section('content')

@foreach ($models as $model)
<div>
    <pre>{{$model->name}}</pre>
    <pre>{{$model->slug}}</pre>
</div>
@endforeach