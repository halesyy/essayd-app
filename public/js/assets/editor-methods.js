/*
| editor related methods; focusing on the data manipulation.
*/

  // $('#essayEditor a').click(function(){ //clicking on clickable link in editor
  //   window.open( $(this).attr('href') );
  // });

  //adding of paragraph
  $(document).on('click', '#addParagraph', function(){
    $('#paragraphs')    .append(window.default_paragraph);
    $('.new-paragraph') .fadeIn(300).removeClass('new-paragraph');
    window.fn.paragraph.restate();
  });

  //setting the selected area
  $(document).on('click', '.title, .introduction, .paragraph, .conclusion', function(){
    selected = $(this).attr('data-selected');
    if ($(this).attr('data-paragraph') !== undefined) {
      window.selectedparagraph = $(this).attr('data-paragraph');
    }
    window.selected = selected;
  });


  //handling unwanted key behaviour
  $('#essayEditor').keydown(function(event){
    keycode        = (event.keyCode ? event.keyCode : event.which);
    eventprevented = false;
    eventpreventedname = 'none';
    if (keycode == 13 && window.selected != 'paragraph') {//enter disabled in conclusion and title
      window.fn.basic.error('You can only have one <strong>'+window.selected+'</strong>');
      eventprevented = true;
      eventpreventedname = "no clicking enter unless in paragraph";
      event.preventDefault();
    }

    if (keycode == 8 && window.fn.basic.caret() == 0 && window.selected != 'paragraph') {
      event.preventDefault();
    }
    console.log(window.fn.basic.caret());
  });


  //re-informate all paragraphs so all have correct data-paragraph and classes,
  //then update the inline paragraph number amount, then update word count on left.
  $('#essayEditor').keyup(function(event){
    window.fn.paragraph.restate().update_editor_paragraph_number();
    window.fn.live.update.words();
    window.fn.editor.package();

    window.fn.editor.contains_all_elements();
  });


  $('.titler').click(function(event){
    console.log('healing '+$(this).attr('data-for'));
  });

  // $(document).on('keydown', '#introduction, #conclusion', function(event){
  //   keycode        = (event.keyCode ? event.keyCode : event.which);
  //   if (keycode == 13) {
  //     event.preventDefault();
  //     $(this).append('<br/>');
  //   }
  // });
  // $('.introduction > .INTERNAL, .conclusion > .INTERNAL').keydown(function(event) {

// });
