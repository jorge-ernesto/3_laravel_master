@inject('FormatTime', 'App\Helpers\FormatTime')

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            @if( session('mensaje') )
                <div class="alert alert-success">{{ session('mensaje') }}</div>
            @endif
            
            @foreach ($dataImagen as $image)                
                <div class="card mb-5">
                    <div class="card-header">
                        @if ($image->user->image) <!-- Valida que imagen del usuario exista -->
                            <a href="#" class="mr-2">
                                <img class="rounded-circle" src="{{ route('user.view', $image->user->image) }}" alt="" width="30px">
                            </a>
                            {{ $image->user->name.' '.$image->user->surname }} <span class="text-muted">{{ ' @'.$image->user->nick }}</span>
                        @endif
                    </div>

                    <div class="card-body p-0">
                        <a href="{{ route('image.detail', $image->id) }}">
                            <img src="{{ route('image.view', $image->image) }}" alt="" width="100%">
                        </a>
                    </div>

                    <div class="card-footer bg-transparent">                        
                        <!-- Fecha y usuario -->
                        <span class="text-muted">{{ ' @'.$image->user->nick.' '.$FormatTime->LongTimeFilter($image->created_at) }}</span><br> 

                        <!-- Descripcion -->
                        {{ $image->description }}<br>                        

                        <!-- Likes y comentarios -->
                        <div class="pt-3 my-auto">                
                            <a href="#" class="mr-2" style="color:#000; text-decoration:none;">
                                <svg width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-heart" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                                </svg>
                            </a>                           
                            <a href="{{ route('image.detail', $image->id) }}" class="btn btn-warning">Comentarios ({{ count($image->comments) }})</a>
                        </div>
                    </div>                    
                </div>
            @endforeach

            {{ $dataImagen->links() }}

        </div>

        <div class="col-md-3">
            @if(Auth::user()->image)   
                <a href="#" class="mr-2">
                    <img class="rounded-circle" src="{{ route('user.view', Auth::user()->image) }}" alt="" width="50px">
                </a>
                {{Auth::user()->name.' '.Auth::user()->surname}} <span class="text-muted">{{' @'.Auth::user()->nick}}</span>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
