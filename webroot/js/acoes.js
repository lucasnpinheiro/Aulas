
$(document).ready(function () {
    $('.bt-excluir').click(function (eve) {
        eve.preventDefault();
        if (confirm('Deseja Excluir Esse Registro?')) {
            window.location.href = $(this).attr('href');
        }
    });
    $('.bt-alterar').click(function (ev) {
        ev.preventDefault();
        var obj = $(this).closest('tr');
        var id = $(obj).attr('rel');
        var qtde = $(obj).find(':input').val();
        window.location.href = $(this).attr('href')+'/'+id+'/'+qtde; 
    });

});

