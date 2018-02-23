@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Confirm Email</div>

                <div class="panel-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @elseif(session('failed'))
                        <div class="alert alert-danger">
                            {{ session('failed') }}
                        </div>
                    @else
                        <form class="form-horizontal" method="POST" action="{{ route('user.confirm.email.submit') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="email_token" value="{{ $token }}">
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <label for=""></label>
                                    <button type="submit" class="btn btn-primary">
                                        Confirm Email
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection