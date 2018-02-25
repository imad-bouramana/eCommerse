$(function(){

    'use strict';
   
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
         // astrx required
      $("input").each(function(){
      	if ($(this).attr('required') === 'required'){
      		$(this).after("<span class='astrex'>*</span>");
      	}
      });
      // color form

      $('.may-form h1 span').click(function(){
          $(this).addClass("select").siblings().removeClass('select');
          $('.may-form form').hide();
          $('.' + $(this).data('class')).fadeIn();
      });
      
      //confirm delite
      $(".confirm").click(function(){
        return confirm("You Are Sure?");

      });

      $('.new').keyup(function(){
         $($(this).data('class')).text($(this).val());
      });
      
     
});