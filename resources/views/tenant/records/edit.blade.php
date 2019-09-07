@extends('tenant.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Records -> {{$record_id}}</div>

                <div class="card-body">
                    <form method="post" action="{{ route('update-records-enterprises',['rid' => $record->id, 'id' => $enterprise_id]) }}">
                        @method('PUT')
                        @csrf

                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-center">{{ __('Type') }}</label>
                            <label for="mount" class="col-md-4 col-form-label text-md-center">{{ __('Mount') }}</label>
                            <label for="description" class="col-md-4 col-form-label text-md-center">{{ __('Description') }}</label>

                            <div class="col-md-4">
                                <!--<input id="type" type="text" class="form-control @error('type') is-invalid @enderror" name="type" value="{{ $record->type }}" required autocomplete="type" autofocus>
                                
                                
                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror-->

                                <select  name = "type" class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
                                    <option value="ingreso"selected>Ingreso</option>
                                    <option value="gasto">Gasto</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <input id="mount" type="text" class="form-control @error('mount') is-invalid @enderror" name="mount" value="{{ $record->mount }}" required autocomplete="mount" >
                                @error('mount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                                
                            </div>

                            <div class="col-md-4">
                                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ $record->description }}" required autocomplete="description" >
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                                  
                            </div>




                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-10 offset-md-10">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>
@endsection