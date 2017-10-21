/*
 &
 &
 */

  $(window).on('load', function(){
    $('.col-2,.col-10').height($(window).height());
    $('.under').height(
      $(window).height() - $('.image').outerHeight()
    );
  });
