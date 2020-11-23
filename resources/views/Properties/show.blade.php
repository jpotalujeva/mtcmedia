@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>  </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="/properties" title="Go back"> <i class="fas fa-backward "></i> </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                Country: <strong>{{$property->country}}</strong>

            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                Town: <strong>{{$property->town}}</strong>

            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                Address: <strong>{{$property->address}}</strong>

            </div> 
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                Price: <strong>{{$property->price}}</strong>

            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                Rent/Sale: <strong>{{$property->sale_rent}}</strong>

            </div> 
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                Description: <strong>{{$property->description}}</strong>

            </div> 
        </div>
    </div>
@endsection