@extends('tenant.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Records FROM {{$enterprise_id}}
                    <a href="{{ route('create-records-enterprises',$enterprise_id)}}" class="btn btn-success btn-sm float-right">Crear</a>
                    
                </div>
                
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                <div class="text-right">

                    <form action="{{ route('search-by-date',$enterprise_id )}}" method="post">
                    @csrf
                         <label for="">fecha inicio</label>   
                        <input type="date" class="datepicker" name="init">
                        <label for="">fecha final</label>
                        <input type="date" class="datepicker" name="last">
                        <button type="submit" class="btn btn-primary btn-sm">Buscar</button>                  
                    </form>
                
                </div>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <td>Type</td>
                            <td>Amount</td>
                            <td>Description</td>
                            <td>Date</td>
                            <td colspan="2">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $record)
                            <tr>
                                <td>{{$record->type}}</td>
                                <td>{{$record->mount}}</td>
                                <td>{{$record->description}}</td>
                                <td>{{$record->created_at}}</td>
                                <td><a href="{{ route('edit-records-enterprises',['id' => $enterprise_id, 'rid' =>$record->id])}}" class="btn btn-primary btn-sm">Edit</a></td>
                                <td>
                                    <form action="{{ route('records.destroy', $record->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                    Ingresos: <span class="badge badge-success">${{ number_format($positive,2 )}}</span>    Gastos: <span class="badge badge-danger">${{ number_format($negative,2) }}</span> 
                    
                    <div class="text-right">
                        <h2>Saldo:<span class="badge badge-primary"> ${{ number_format($positive - $negative,2) }}</span></h2>
                    </div>    

                </div>
            </div>
        </div>
    </div>
    <script>
    $('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        autoclose: true
    });
</script>
</div>
@endsection