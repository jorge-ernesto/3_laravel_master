@inject('Image', 'App\Http\Controllers\ImageController')

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            @if( session('mensaje') )
                <div class="alert alert-success">{{ session('mensaje') }}</div>
            @endif
            
            @foreach ($dataImages as $image)
                {{-- @if( $Image->validarImagen($image->image_path) ) <!-- Valida que imagen del post exista --> --}}
                    <div class="card" style="margin-bottom: 60px;">
                        <div class="card-header">
                            @if ($image->user->image) <!-- Valida que imagen del usuario exista -->
                                <a href="#" class="mr-2">
                                    <img class="rounded-circle" src="{{ route('user.avatar', $image->user->image) }}" alt="" width="33px">
                                </a>
                                {{$image->user->name.' '.$image->user->surname}} <span class="text-muted">{{' @'.$image->user->nick}}</span>
                            @endif
                        </div>

                        <div class="card-body p-0">
                            <img src="{{ route('image.view', $image->image_path) }}" alt="" width="100%">
                        </div>

                        <div class="p-2">
                            {{$image->description}}
                        </div>
                    </div>
                {{-- @endif --}}
            @endforeach

            {{$dataImages->links()}}

        </div>

        <div class="col-md-3">
            @if(Auth::user()->image)   
                <a href="#" class="mr-2">
                    <img class="rounded-circle" src="{{ route('user.avatar', Auth::user()->image) }}" alt="" width="53px">
                </a>
                {{Auth::user()->name.' '.Auth::user()->surname}} <span class="text-muted">{{' @'.Auth::user()->nick}}</span>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
