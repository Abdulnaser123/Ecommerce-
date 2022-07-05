$(function (){
    // hie place holder
    $('[placeholder]').focus(function (){
    
    $(this).attr('data-text',$(this).attr('placeholder'));
    $(this).attr('placeholder','');
    
    
    }).blur(function(){
    $(this).attr('placeholder',$(this).attr('data-text'));
    
    });
    
    // add astrerix on required field
    
    $('input').each(function(){
        if($(this).attr('required') == 'required') {
            $(this).after('<span class="asterix">*</span>');
        
        }
        
        
        });
    // convert password field on hover
    var passwordField = $('.password');
    $('.show').hover(function (){
        passwordField.attr('type','text');
    
    }, function () {
        passwordField.attr('type','password');
    });

    //confirmation mesage on button

    $('.confirm').click(function (){

return confirm('are u sure?');

    });
    $('.categories .cats h3').click(function(){
        
        $(this).next().fadeToggle();
    });

    $('.toggleee').click(function(){
       $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);

       if($(this).hasClass('selected')){
           $(this).html('<i class = "fa fa-plus fa-lg "></i>');
       }
       else
       {
        $(this).html('<i class = "fa fa-minus fa-lg "></i>');

       }
    });

    
    
    
    
    });

