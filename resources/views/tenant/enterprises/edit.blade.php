@extends('tenant.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Enterprises -> {{$enterprise->name}}</div>

                <div class="card-body">
                    <form method="post" action="{{ route('enterprises.update', $enterprise->id) }}">
                        @method('PATCH')
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-center">{{ __('Name') }}</label>
                            <label for="rfc" class="col-md-4 col-form-label text-md-center">{{ __('Rfc') }}</label>
                            <label for="description" class="col-md-4 col-form-label text-md-center">{{ __('Description') }}</label>

                            <div class="col-md-4">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $enterprise->name }}" required autocomplete="name" autofocus>
                                
                                
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <input id="rfc" type="text" class="form-control @error('rfc') is-invalid @enderror" name="rfc" value="{{ $enterprise->rfc }}" required autocomplete="rfc" >
                                @error('rfc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                                
                            </div>

                            <div class="col-md-4">
                                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ $enterprise->description }}" required autocomplete="description" >
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