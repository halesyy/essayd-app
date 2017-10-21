/*
 & #essays-preview area gets populated with dividers owned
 & by the ID. Handles clicks on preview as well.
 */

$(window).ready(function(){
    $.get('/api/get/users-essays', function(response){
      var json = JSON.parse(response);

      if (json.success == true) {
        for (var i = 0; i < json.ids.length; i++) {
          let essay = json.ids[i];

          $('#essays-preview').append(
            "<div data-id='"+ essay.id +"' class='essay-container'><div class='introduction'>"+essay.introduction+"</div><div class='identifier'>"+essay.identifier+"<div class='last_edited'>Last edit: "+essay.last_edited+"</div></div></div>"
          );
        }
      }

      $('#essays-preview').append('<div style="clear: both;"></div>');
    });
});

$(document).on('click', '.essay-container', function(event){
  let id = $(this).attr('data-id');
  window.location.href = "/editor#"+id;
});

$(window).on('load resize', function(event){
  $('.essay-container').css({
    height: $('.essay-container').width() * 1.5,
    maxHeight: $('.essay-container').width() * 1.5
  });
  $('.essay-container .identifier').css({
    width: $('.essay-container').width()
  });
});
