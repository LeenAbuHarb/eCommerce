$(document).ready(function(e) {
    $(".confirmation").click(function () {
        // Display a confirmation dialog
        var isConfirmed = confirm('Are you sure you want to delete?');

      
    });


    $(function(){
'use strict';
$('.toggle-info').click(function(){
      $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);
      if($(this).hasClass('selected')){
        $(this).html('<i class="fa fa-minus"></i>');
      }
      else{
        $(this).html('<i class="fa fa-plus fa-lg"></i>');
      }
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


//convert pass to text field
// var pass= $('.password');
// $('.show-pass').hover(function(){

//     pass.attr('type','text');

// }, function(){
//     pass.attr('type','password');
// });

document.getElementById('showPasswordLink').addEventListener('click', function() {
    var passwordInput = document.getElementById('password');
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
    } else {
      passwordInput.type = 'password';
    }
  });


  // jQuery code

      // Click event handler for a button with the id "deleteButton"
   




});

// Category show option
$('.cat h3').click(function(){
    $(this).next('.full-view').fadeToggle(200);
});

$('.option span').click(function(){
    $(this).addClass('active').siblings('span').removeClass('active');
    if($(this).data('view')==='full'){
        $('.cat .full-view').fadeIn(200);

    }
    else{
        $('.cat .full-view').fadeOut(200);
    }
});

$('.child-link').hover(function(){

$(this).find('.show-delete').fadeIn(400);

},function(){
    $(this).find('.show-delete').fadeOut(400);
});




});