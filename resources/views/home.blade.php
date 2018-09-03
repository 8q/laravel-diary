@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <aside-component></aside-component>
        </div>
        <div class="col-md-9">
            <diary-component v-for="diary in diaries"
                v-bind:key="diary.id"
                v-bind:diary="diary">
            </diary-component>
        </div>
    </div>
</div>
@endsection
