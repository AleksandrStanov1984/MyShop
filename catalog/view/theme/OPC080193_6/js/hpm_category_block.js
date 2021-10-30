  $(document).ready(function(){
    var bottomLim = ($('.hpm-cat-box').data('count-hpm') - 7)*47;
    $('.prev-hpm-item').click(function(){
    
     
      $(this).parent('.hpm-cat-box').find('.hpm-cat-content').css('top', (parseFloat($(this).parent('.hpm-cat-box').find('.hpm-cat-content').css('top')) + 47));
     console.log(parseFloat($(this).parent('.hpm-cat-box').find('.hpm-cat-content').css('top')));
       
       var thisElement = $(this);
      if(parseFloat($(this).parent('.hpm-cat-box').find('.hpm-cat-content').css('top')) == 0){
      thisElement.attr('disabled', 'disabled');
      } else if(parseFloat($(this).parent('.hpm-cat-box').find('.hpm-cat-content').css('top')) > - bottomLim){
        $('.next-hpm-item').removeAttr('disabled');
      }
    });
   
     
    $('.next-hpm-item').click(function(){
      $(this).parent('.hpm-cat-box').find('.hpm-cat-content').css('top', (parseFloat($(this).parent('.hpm-cat-box').find('.hpm-cat-content').css('top')) - 47));
      var thisElement = $(this);
      
       
        if(parseFloat($(this).parent('.hpm-cat-box').find('.hpm-cat-content').css('top')) == - bottomLim ){
       
       thisElement.attr('disabled', 'disabled');
     } else if(parseFloat($(this).parent('.hpm-cat-box').find('.hpm-cat-content').css('top')) !== 0){
         $('.prev-hpm-item').removeAttr('disabled');
       }


    })
  })