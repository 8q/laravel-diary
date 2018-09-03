@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <aside-component></aside-component>
        </div>
        <div class="col-md-9">
            <submit-component></submit-component>
        </div>
    </div>
</div>
@endsection