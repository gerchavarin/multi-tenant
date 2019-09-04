@extends('tenants.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tenant</div>

                <div class="card-body">
                    <form method="post" action="{{ route('tenants.update', $tenant->id) }}">
                        @method('PATCH')
                        @csrf

                        <div class="form-group row">
                            <label for="fqdn" class="col-md-4 col-form-label text-md-right">{{ __('FQDN') }}</label>

                            <div class="col-md-6">
                                <input id="fqdn" type="text" class="form-control @error('fqdn') is-invalid @enderror" name="fqdn" value="{{ $tenant->fqdn }}" required autocomplete="fqdn" autofocus>

                                @error('fqdn')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
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