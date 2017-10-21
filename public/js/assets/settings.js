/*
 * | Settings container JavaScript methods and handlers.
 */

  window.form_activated  = 'register';
  window.assorted_colors = ['#b388ff', '#52e592'];

  $('.snappet').each(function(index, item){//adding individual colors to all snappets
    $item = $(item);
    $item.css({
      borderLeft: 'solid '+ window.assorted_colors[index] +' 6px'
    });
  });

  $('.buttons button').click(function(){//buttons clicking for login/register buttons.
    if (window.form_activated != $(this).attr('data-open')) {
      open = $(this).attr('data-open');
      $('.buttons button').removeClass('selected-login selected-register');
      $(this).addClass('selected-'+open);
      $('.register, .login').slideUp(500, function(){
        $('.'+open).slideDown(500, function(){});
      });
      window.form_activated = open;
    }
  });
