@extends('enterprises.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Enterprises
                    <a href="{{ route('enterprises.create')}}" class="btn btn-success btn-sm float-right">Crear</a>
                    
                </div>
                
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <td>RFC</td>
                            <td>Descripción</td>
                            <td>Nombre</td>
                            <td colspan="2">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enterprises as $enterprise)
                            <tr>
                                <td>{{$enterprise->rfc}}</td>
                                <td>{{$enterprise->description}}</td>
                                <td>{{$enterprise->name}}</td>
                                <td><a href="{{ route('enterprises.edit',$enterprise->id)}}" class="btn btn-primary btn-sm">Edit</a></td>
                                <td>
                                    <form action="{{ route('enterprises.destroy', $enterprise->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection