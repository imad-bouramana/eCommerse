$(function(){

    'use strict';
    $('.inc_list').click(function(){
        $(this).toggleClass('active').parent().next('.panel-body').fadeToggle();
        if($(this).hasClass('active')) {
             $(this).html('<i class="fa fa-minus"></i>');
     
           }else{
        $(this).html('<i class="fa fa-plus"></i>');
       }
    });

       // Calls the selectBoxIt 
    $("select").selectBoxIt({
      autoWidth: false
    });
  
    $('[placeholder]').focus(function(){

    	 $(this).attr('data-text', $(this).attr('placeholder'));
    	 $(this).attr('placeholder', "");
      }).blur(function(){
      
         $(this).attr('placeholder', $(this).attr('data-text'));
      });

      $("input").each(function(){
      	if ($(this).attr('required') === 'required'){
      		$(this).after("<span class='astrex'>*</span>");
      	}
      });
      // pass-eye function
      $(".pass-eye").hover(function(){
           $('.password').attr("type", "text");
      }, function(){
           $(".password").attr('type', "password");
      });
      //confirm delite
      $(".confirm").click(function(){
        return confirm("You Are Sure?");

      });
      // full-view toggle
      $('.cat h3').click(function(){
         $(this).next('.full-view').fadeToggle();
      });
      $('.options span').click(function(){
        $(this).addClass('active').siblings('span').removeClass('active');
        if($(this).data('view') === 'Full'){
          $('.cat .full-view').fadeIn(300);
        }else{
          $('.cat .full-view').fadeOut(300);
        }
        
      });
      // show delit-child
      $('.child-cat').hover(function(){
          $(this).find('.delite').fadeIn(300);
      },function(){
          $(this).find('.delite').fadeOut(300);
     
      });
});










