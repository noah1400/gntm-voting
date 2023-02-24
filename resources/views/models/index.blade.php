@extends('layouts.app')

@section('content')

@foreach ($models as $model)
<div>
    <pre>{{$model->name}}</pre>
</div>
@endforeach