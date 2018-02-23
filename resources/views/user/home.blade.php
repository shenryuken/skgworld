@extends('layouts.Homer.default')

{{-- Page title --}}
@section('title')
    Admin List
    @parent
@stop
<?php $page_title = 'Dashboard'; ?>
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Dashboard</div>

            <div class="panel-body">
                You are logged in!
            </div>
        </div>
    </div>
</div>

@endsection
