@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome, {{ auth()->user()->name }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ url('suppliers') }}" class="btn btn-primary">Manage suppliers</a>
                    <a href="{{ url('payments') }}" class="btn btn-secondary">View payment record</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
