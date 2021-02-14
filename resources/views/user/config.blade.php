@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if( session('mensaje') )
                <div class="alert alert-success">{{ session('mensaje') }}</div>
            @endif

            <div class="card">
                <div class="card-header">Configuración de mi cuenta</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.update', Auth::user()->id) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf                        

                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>

                            <div class="col-md-6">  
                                @if(Auth::user()->image)    
                                    <img src="{{ route('user.avatar', Auth::user()->image) }}" alt="" class="rounded-circle" width="120px">
                                @endif                                                            
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Surname') }}</label>

                            <div class="col-md-6">
                                <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ Auth::user()->surname }}" required autocomplete="surname" autofocus>

                                @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nick" class="col-md-4 col-form-label text-md-right">{{ __('Nick') }}</label>

                            <div class="col-md-6">
                                <input id="nick" type="text" class="form-control @error('nick') is-invalid @enderror" name="nick" value="{{ Auth::user()->nick }}" required autocomplete="nick" autofocus>

                                @error('nick')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>                         
                        
                        <!-- Input file donde se adjunta la imagen -->
                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">Introduce tu imagen</label>
                            
                            <div class="col-md-6">  
                                <div class="custom-file">                                    
                                    <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" lang="es">
                                    <label class="custom-file-label" for="image">Seleccionar Archivo</label>
                                </div>    
                                
                                {{-- Esto no funciona con la clase 'invalid-feedback' por el tipo nuevo de custom file input, se puede arreglar usando estilos css --}}
                                @error('image')
                                    <span style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #e3342f;" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>                                
                        </div>

                        <!-- Editor donde se recortará la imagen con la ayuda de croppr.js -->
                        <div class="form-group row">
                            <label for="editor" class="col-md-4 col-form-label text-md-right">Recorta</label>

                            <div class="col-md-6" style="width: 329px;">
                                <div id="editor"></div>
                            </div>
                        </div>

                        <!-- Previa del recorte -->
                        <canvas id="preview" class="d-none"></canvas>
                    
                        <!-- Muestra de la imagen recortada en Base64 -->
                        <code id="base64" class="d-none"></code>

                        <!-- Muestra de la imagen recortada en Base64 en un input con name para enviar por POST -->
                        <input id="base64_image" type="text" class="d-none" name="base64">

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Guardar cambios
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
<!-- Para el editor usaremos croppr.js, importamos sus CDNs -->
<script src="https://cdn.jsdelivr.net/gh/jamesssooi/Croppr.js@2.3.1/dist/croppr.min.js"></script>
<link href="https://cdn.jsdelivr.net/gh/jamesssooi/Croppr.js@2.3.1/dist/croppr.min.css" rel="stylesheet"/>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Input File
        const inputImage = document.querySelector('#image');
        // Nodo donde estará el editor
        const editor = document.querySelector('#editor');
        // El canvas donde se mostrará la previa
        const miCanvas = document.querySelector('#preview');
        // Contexto del canvas
        const contexto = miCanvas.getContext('2d');
        // Ruta de la imagen seleccionada
        let urlImage = undefined;
        // Evento disparado cuando se adjunte una imagen
        inputImage.addEventListener('change', abrirEditor, false);

        /**
         * Método que abre el editor con la imagen seleccionada
         */
        function abrirEditor(e) {
            // Obtiene la imagen
            urlImage = URL.createObjectURL(e.target.files[0]);                

            // Borra editor en caso que existiera una imagen previa
            editor.innerHTML = '';
            let cropprImg = document.createElement('img');
            cropprImg.setAttribute('id', 'croppr');
            editor.appendChild(cropprImg);

            // Limpia la previa en caso que existiera algún elemento previo
            contexto.clearRect(0, 0, miCanvas.width, miCanvas.height);

            // Envia la imagen al editor para su recorte
            document.querySelector('#croppr').setAttribute('src', urlImage);

            // Crea el editor
            var croppr = new Croppr('#croppr', {
                aspectRatio: 1,
                startSize: [70, 70],                    
                onInitialize: function onInitialize(value) {                                                
                    console.log(value);
                    var value = croppr.getValue();
                    recortarImagen(value);
                },
                onCropEnd: recortarImagen
            })                
        }

        /**
         * Método que recorta la imagen con las coordenadas proporcionadas con croppr.js
         */
        function recortarImagen(data) {                
            console.log(data);

            // Variables
            const inicioX = data.x;
            const inicioY = data.y;
            const nuevoAncho = data.width;
            const nuevaAltura = data.height;
            const zoom = 1;
            let imagenEn64 = '';
            // La imprimo
            miCanvas.width = nuevoAncho;
            miCanvas.height = nuevaAltura;
            // La declaro
            let miNuevaImagenTemp = new Image();
            // Cuando la imagen se carge se procederá al recorte
            miNuevaImagenTemp.onload = function() {
                // Se recorta
                contexto.drawImage(miNuevaImagenTemp, inicioX, inicioY, nuevoAncho * zoom, nuevaAltura * zoom, 0, 0, nuevoAncho, nuevaAltura);
                // Se transforma a base64
                imagenEn64 = miCanvas.toDataURL("image/jpeg");
                // Mostramos el código generado
                document.querySelector('#base64').textContent = imagenEn64;
                document.querySelector('#base64_image').value = imagenEn64;
            }
            // Proporciona la imagen cruda, sin editarla por ahora
            miNuevaImagenTemp.src = urlImage;
        }
    });

    $('.custom-file-input').on('change', function(event) {
        var inputFile = event.currentTarget;
        $(inputFile).parent()
            .find('.custom-file-label')
            .html(inputFile.files[0].name);
    });  
</script>
@endsection
