@extends('tenant.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Users
                    <a href="{{ route('users.create')}}" class="btn btn-success btn-sm float-right">Crear</a>
                    
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
                            <td>Name</td>
                            <td>Email</td>
                            <td>Enterprise</td>
                            <td colspan="2">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @foreach($user->enterprises as $index => $enterprise)
                                    {{$index > 0 ? ', ' . $enterprise->name : $enterprise->name}}
                                    @endforeach
                                </td>
                                <td><a href="{{ route('users.edit',$user->id)}}" class="btn btn-primary btn-sm">Edit</a></td>
                                <td>
                                    <form action="{{ route('users.destroy', $user->id)}}" method="post">
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