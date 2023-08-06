import $ from 'jquery';

$.ajaxSetup({
    headers:{
        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content'),
    }
})

$('.content').on('click',function (){
   $('.searchable ul').hide();
});

$('.content').on('click','.searchable input',function(e){
    e.stopPropagation();
    $(this).parent().find('ul').show();
})

$('.content').on('click','.searchable ul li',function (){
    $(this).parent().parent().find('input[type="hidden"]').val($(this).attr('value'));
    $(this).parent().parent().find('input[search="true"]').val($(this).html());
    console.log($(this).parent());
    $(this).parent().hide();
})

$('.content').on('keyup','.searchable input:last-of-type',function (){
    for(let val of $(this).parent().find('ul li')){
        if($(val).html().indexOf($(this).val()) >= 0){
            $(val).show();
        }else{
            $(val).hide();
        }
    }
})



$('.content').on('click','.outer-nav > span',function (){
    $(event.target).toggleClass('closed');
    if($(event.target).hasClass('closed')){
        $('nav').animate({
            width:'0px',
        });
        $('.page-content').animate({
            width:'100%'
        })
    }else{
        $('nav').animate({
            width:'200px',
        });
        $('.page-content').animate({

        }, {duration:500, complete:function(){ $('.page-content').width("calc(100% - 200px)"); } })
    }
})


$('.content').on('click','nav .list_data p',function (){
    $(this).next().slideToggle();
})
