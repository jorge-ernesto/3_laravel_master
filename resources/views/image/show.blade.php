@inject('FormatTime', 'App\Helpers\FormatTime')

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">                            

            @if( session('mensaje') )
                <div class="alert alert-success">{{ session('mensaje') }}</div>
            @endif

            <a href="{{ route('image.index') }}" class="btn btn-warning mb-3">Atrás</a>

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
                    <img src="{{ route('image.view', $image->image) }}" alt="" width="100%">
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
                            <a href="#" class="btn-like" data-id="{{ $image->id }}">
                                <i class="fas fa-heart" style="font-size: 18px;"></i>                                                            
                            </a>                                                                   
                        @else
                            <a href="#" class="btn-dislike" data-id="{{ $image->id }}">  
                                <i class="fas fa-heart" style="font-size: 18px;"></i>                                                                                                          
                            </a>                                
                        @endif

                        <span class="mr-2">{{ count($image->likes) }}</span> 
                    </div>

                    <!-- Comentarios -->
                    <div class="pt-3">
                        <h2>Comentarios ({{ count($image->comments) }})</h2>
                        <hr>

                        <form method="POST" action="{{ route('comment.store') }}">
                            @csrf

                            <input type="hidden" name="image_id" value="{{ $image->id }}">
                            
                            <div class="form-group row">
                                {{-- <label for="content" class="col-md-4 col-form-label text-md-right">Descripción</label> --}}
    
                                <div class="col-md-12">
                                    <textarea id="content" class="form-control @error('content') is-invalid @enderror" name="content" value="" required autocomplete="content" autofocus rows="3"></textarea>
    
                                    @error('content')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>   
                                                            
                            <button type="submit" class="btn btn-success">
                                Enviar
                            </button>
                        </form>
                        <hr>
                        
                        @foreach($dataComment as $key=>$comment)
                            <div class="mb-2">
                                <span class="text-muted">{{ ' @'.$comment->user->nick.' '.$FormatTime->LongTimeFilter($comment->created_at) }}</span><br>
                                
                                <div class="d-flex justify-content-between">
                                    {{ $comment->content }}
                                    @if($comment->user->id == Auth::user()->id) <!-- Comprobar si es el dueño del comentario -->
                                        <form method="POST" action="{{ route('comment.destroy', $comment->id) }}">
                                            @method('DELETE')
                                            @csrf                                        
                                            <button class="btn btn-sm btn-warning">Eliminar</button>     
                                        </form>
                                    @elseif($image->user->id == Auth::user()->id) <!-- Comprobar si es el dueño de la publicacion -->
                                        <form method="POST" action="{{ route('comment.destroy', $comment->id) }}">
                                            @method('DELETE')
                                            @csrf                                        
                                            <button class="btn btn-sm btn-warning d-flex justify-content-end">Eliminar</button>     
                                        </form>
                                    @endif                 
                                </div>                                                                             
                            </div>                                
                        @endforeach
                        {{ $dataComment->links() }}
                    </div>
                </div>                    
            </div>  
            
        </div>
    </div>
</div>
@endsection
