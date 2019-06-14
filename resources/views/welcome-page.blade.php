@extends('layouts.app')

@section('content')
<div class="page-header" style="background: url('/img/slider.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1>
                    {{ config('app.name')}}
                </h1>
                <p class="header-subtext">{{config('app.site_description', 'Supplier Payment Management System')}}</p>
                <div>
                    <a href="{{route('login')}}" class="btn btn-success btn-lg">Login</a>
                </div>
            </div>
                
        </div>
        
    </div>
    
</div>
@endsection