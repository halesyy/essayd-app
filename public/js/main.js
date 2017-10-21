/*
 & On each load / resize will set height to the window
 & height.
 */

  $(window).on('load resize', function(){
    $('.box, .beam').css({  height:$(this).height()  });

    if ( $(window).width() <= 1000 ) {
      $('.beam').css({marginLeft:0,width:'100%'});
    }
    else {
      $('.beam').css({marginLeft:'15%',width:'70%'});
    }

    $('.contain').css({
      paddingTop: ($(window).height() - $('.contain').outerHeight()) / 2
    });
  });
