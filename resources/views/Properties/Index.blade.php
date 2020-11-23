@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laravel CRUD Example </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="/create" title="Create a product"> <i class="fas fa-plus-circle"></i>
                    </a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{message}}</p>
        </div>
    @endif

    <table class="table table-bordered table-responsive-lg">
        <tr>
            <th>No</th>
            <th>Country</th>
            <th>description</th>
            <th>Price</th>
            <th>Date Created</th>
            <th>Actions</th>
        </tr>

        @foreach ($properties as $property)
            <tr>
                <td>{{$property->id}}</td>
                 <td>{{$property->country}}</td>
                 <td>{{$property->description}}</td>
                 <td>{{$property->price}}</td>
                 <td>{{$property->created_at}}</td>
                <td>
                     <a href="/show/{{$property->id}}" title="show">
                            <i class="fas fa-eye text-success  fa-lg"></i>
                        </a>

                        <a href="/edit/{{$property->id}}">
                            <i class="fas fa-edit  fa-lg"></i>
                        </a>
                    <form action="/delete/{{$property->id}}" method="post">
                    @csrf
                    
                    <button type="submit"><i  class="fas fa-trash fa-lg text-danger"></i></button>
                    
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {!! $properties->links() !!}

@endsection