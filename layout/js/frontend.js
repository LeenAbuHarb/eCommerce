$(document).ready(function(e) {
    $(".confirmation").click(function () {
        // Display a confirmation dialog
        var isConfirmed = confirm('Are you sure you want to delete?');

      
    });


    $(function(){
'use strict';
$('.login-page h1 span').click(function(){
    $(this).addClass('active').siblings().removeClass('active');
    $('.login-page form').hide();
    $('.' + $(this).data('class')).fadeIn(100);  // استخدام .show() بدلاً من .hide()
});


$("select").selectBoxIt({
    autoWidth:false
});

$('[placeholder]' ).focus(function(){
    $(this).attr('data-text',$(this).attr('placeholder'));
    $(this).attr('placeholder','');

}).blur(function(){
    $(this).attr('placeholder',$(this).attr('data-text'));
});


$('input').each(function(){
    if($(this).attr('required')==='required'){
        $(this).after('<span class="asterisk">*</span>');
    }
});

});

$('.live').keyup(function(){
    $($(this).data('class')).text($(this).val());

});




});