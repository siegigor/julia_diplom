$('.show_code').click(function(){
    var id=$(this).attr('data-id');
    if($('.sol_code'+id).css('display')=='none')
    {
        $(this).text('Скрыть код решения')
        $('.sol_code'+id).css('display', 'block');
    }
    else
    {
        $(this).text('Показать код решения');
        $('.sol_code'+id).css('display', 'none');
    }
})

$("#task_pjax").on("pjax:start", function() {
    $('.solve_button').html('<i class="fa fa-spinner fa-spin fa-fw"></i> Отправка');
    $('.solve_button').attr('disabled',true);

});
$("#task_pjax").on("pjax:end", function() {
    $('.solve_button').html('Отправить');
    $('.solve_button').removeAttr('disabled');

});