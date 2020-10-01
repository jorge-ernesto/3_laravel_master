@inject('FormatTime', 'App\Helpers\FormatTime')

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6"> <!-- Barra izquierda -->

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
                        <a href="{{ route('image.show', $image->id) }}">
                            <img src="{{ route('image.view', $image->image) }}" alt="" width="100%">
                        </a>
                    </div>

                    <div class="card-footer bg-transparent">                        
                        <!-- Usuario y fecha -->
                        <span class="text-muted">{{ ' @'.$image->user->nick.' '.$FormatTime->LongTimeFilter($image->created_at) }}</span><br>

                        <!-- Descripcion -->
                        {{ $image->description }}<br>

                        <!-- Likes y comentarios -->
                        <div class="pt-3 my-auto">   
                            <?php $user_like = false; ?>
                            @foreach ($image->likes as $like)
                                @if ($like->user_id == Auth::user()->id)
                                    <?php $user_like = true; ?>
                                @endif                                
                            @endforeach

                            @if ($user_like == true)
                                <a href="#" class="btn-like" data-imageid="{{ $image->id }}">
                                    <i class="fas fa-heart" style="font-size: 18px;"></i>                                                            
                                </a>                                                                   
                            @else
                                <a href="#" class="btn-dislike" data-imageid="{{ $image->id }}">  
                                    <i class="fas fa-heart" style="font-size: 18px;"></i>                                                                                                          
                                </a>                                
                            @endif

                            <span id="{{ "cantidad-likes-".$image->id }}" class="mr-2">{{ count($image->likes) }}</span>                           
                            <a href="{{ route('image.show', $image->id) }}" class="btn btn-warning">Comentarios ({{ count($image->comments) }})</a>
                        </div>
                    </div>                    
                </div>
            @endforeach
            
            {{ $dataImagen->links() }}

        </div>

        <div class="col-md-3"> <!-- Barra derecha -->
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
