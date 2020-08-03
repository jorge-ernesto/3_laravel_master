@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if( session('mensaje') )
                <div class="alert alert-success">{{ session('mensaje') }}</div>
            @endif

            <div class="card">
                <div class="card-header">Subir nueva image</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('image.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">Imagen</label>

                            <div class="col-md-6">  
                                <div class="custom-file">                                    
                                    <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" lang="es" required>
                                    <label class="custom-file-label" for="image">Seleccionar Archivo</label>
                                </div>

                                {{-- Esto no funciona con la clase 'invalid-feedback' por el tipo nuevo de custom file input, se puede arreglar usando estilos css --}}
                                @if( $errors->has('image') )
                                    <span style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #e3342f;" role="alert">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Descripción</label>

                            <div class="col-md-6">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" value="" required autocomplete="description" autofocus rows="3"></textarea>

                                @if( $errors->has('description') )
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Subir imagen
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
