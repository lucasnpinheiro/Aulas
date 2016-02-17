
$(document).ready(function(){
    $('.bt-excluir').click(function(eve){
        eve.preventDefault();
        if(confirm('Deseja Excluir Esse Registro?')){
            window.location.href=$(this).attr('href');
        }
    });
    
});

