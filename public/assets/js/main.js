/* Funcionalidad para dar like y dislike */
var url = "http://localhost:8000";

$(document).ready(function() {
    like();
    dislike();

    function like(){
        $('.btn-like').unbind('click').click( function(event){
            event.preventDefault();
            $(this).addClass('btn-dislike').removeClass('btn-like');

            image_id = $(this).data('imageid');

            $.ajax({
                type: 'GET',
                url: `${url}/like/dislike/${image_id}`
            })
            .done(function(res){
                console.log('Funcion para generar dislike');
                console.log(res);
                $(`#cantidad-likes-${image_id}`).text(res.cantidad_likes);
            });

            dislike();
        });
    }

    function dislike(){
        $('.btn-dislike').unbind('click').click( function(event){
            event.preventDefault();
            $(this).addClass('btn-like').removeClass('btn-dislike');

            image_id = $(this).data('imageid');

            $.ajax({
                type: 'GET',
                url: `${url}/like/like/${image_id}`
            })
            .done(function(res){
                console.log('Funcion para generar like');
                console.log(res);
                $(`#cantidad-likes-${image_id}`).text(res.cantidad_likes);
            });

            like();
        });
    }
});
