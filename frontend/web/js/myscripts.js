$('.show_code').click(function(){
    $('.sol_code').css('display', 'block');
})

$("#task_pjax").on("pjax:start", function() {
    $('.solve_button').html('<i class="fa fa-spinner fa-spin fa-fw"></i> Отправка');
    $('.solve_button').attr('disabled',true);

});
$("#task_pjax").on("pjax:end", function() {
    $('.solve_button').html('Отправить');
    $('.solve_button').removeAttr('disabled');

});