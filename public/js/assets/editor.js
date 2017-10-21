// window globals.
  window.settings_expanded = true;

  window.paragraphs = 1;
  window.selected   = false;

  window.default_paragraph = "<div class='paragraph new-paragraph' tabindex='0' data-selected='paragraph' data-paragraph='0' style='display: none;'>Point, Example, Evidence, Link</div>";

  window.loaded_essay_id = false;

  window.defaults = {
    title: "Welcome to Essay'd!",
    introduction: "This is the lovely introduction to your new Essay. The introduction is about showing your audience what's going to be covered in the coming paragraphs.",
    paragraph1: "These will be your body paragraphs! You will follow the PEEEE framework for each paragraph to use academic-correct formatting and get the best marks possible!",
    paragraph2: "To make a new paragraph, click the \"Add paragraph\" button in the left panel or click enter at the end of a current paragraph.",
    conclusion: "Finally, the conclusion to sum up everything you've written today. It's essentially a re-formatted introduction with a similar but different frame to it."
  }

  
  window.cache = '';






  $(window).ready(function(){//load and resize handling
    $('#essayEditor').css({marginLeft: '20'});
    $('.settings-container').css({right: '0'});

    window.fn.user.begin(true); // checks to see if user logged in, if so, add areas that user needs to see
    window.fn.user.check_essay_needs_loading_in(); // will load in an essay if there's a url hash in bar.


    window.fn.paragraph.restate().update_editor_paragraph_number();
    window.fn.live.update.words();

    // $('#essayEditor').css({marginLeft:$('.live-editing-outer').width()});

    // $('.settings-outer, .live-editing-outer').height(window.fn.basic.tall());
  });


  // first load resize and handling for future resizes
  $(window).on('load resize', function(){
    $('.live-editing-container').css({ maxWidth: $('.live-editing-outer').width() });
    $('.settings-outer, .live-editing-outer').height(window.fn.basic.tall());
    $('.settings-outer .bottom-container').width( $('.settings-outer').width() );
  });


  //right pane slide toggling
  $(document).on('click', '.btn', function(){

      if ($(this).attr('data-side') == "right") {
        if (window.settings_expanded) {
          $('#essayEditor').css({marginLeft: '32.66%'});
          $('.settings-container').css({right: '-40%'});
        } else {
          $('#essayEditor').css({marginLeft: 20});
          $('.settings-container').css({right: 0});
        }
        window.settings_expanded = !window.settings_expanded;
      }

  });
