$(function (){
    // hie place holder

    //switch betwenn login and signup
    $('.login-page h1 span').click(function(){

        $(this).addClass('selected').siblings().removeClass('selected');
        $('.login-page form').hide();
        $('.'+ $(this).data('class')).fadeIn(200);

    } )



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


    //confirmation mesage on button

    $('.confirm').click(function (){

return confirm('are u sure?');

    }); 

    $('.live-name').keyup(function(){

        // console.log($(this).val());
        $('.live-preview .caption h3').text($(this).val());

    });

    $('.live-description').keyup(function(){

        // console.log($(this).val());
        $('.live-preview  p').text($(this).val());

    });

    $('.live-price').keyup(function(){

        // console.log($(this).val());
        $('.live-preview  span').text('$'+$(this).val());

    });
    
    
    });

