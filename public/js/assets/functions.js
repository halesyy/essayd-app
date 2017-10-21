/*
| Recycleable functions sorted in their relevance,
| as if classes.
*/

  window.fn = {
    basic: {
        swap: function(direction) {
            return (direction == "left")? "right": "left";
        },
        tall: function() {
            return ($(window).height());
        },
        talleditor: function() {
            return ($(window).height()-$('.header').height());
        },
        error: function(message) {
            $('.error-area').stop().html(message).fadeIn(250, function(){
              $(this).fadeOut(2500);
            });
        },
        caret: function() {
            if (window.getSelection) {
                sel = window.getSelection();
                if (sel.getRangeAt) return sel.getRangeAt(0).startOffset;
            }
            return null;
        },
        error_alert: function(config) {
            $('.popin-type').remove();
            if (config.type === undefined) config.type = 'danger';
            $(config.appendto).append(
              '<div class="alert alert-' + config.type  + ' popin-type alert-dismissable new-alert" style="margin-top: 10px; display: none;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + config.message + '</div>'
            );
            $('.new-alert').fadeIn(250, function(){
              $('.new-alert').removeClass('.new-alert');
            });
        }
    },














    /*
     & Paragraph bases itself off of the complex ideology of the #paragraphs
     & id div. One of the most complex pieces of code on the entire earth.
     & Meant for keeping the future manipulation of the classes to be fairly
     & matched and always the same.
     */
    paragraph: {
      restate: function() {
        amount = 0;
        $('.paragraph').each(function(index, item){
          // console.log([index, item]);
          $(item).attr('data-paragraph', index+1);
          $(item).attr('data-selected', 'paragraph');

          $(item).removeClass(function (index, className) {
            return (className.match (/p[0-9]+/g) || []).join(' ');
          });
          $(item).addClass('p'+(index+1));
          amount = amount + 1;
        });
        window.paragraphs = amount;
        return window.fn.paragraph;
      },
      total_character_length: function() {
        store = 0;
        $('.paragraph').each(function(index, item){
          store += $(item).html().length;
        });
        // console.log('paragraph total length: '+store);
        return store;
      },
      update_editor_paragraph_number: function() {
        $('#paragraphnumber').html(window.paragraphs);
        return window.fn.paragraph;
      }
    },


    conclusion: {
      total_character_length: function() {
        return $('#conclusion').html().length;
      }
    },


    live: { //live-editing area
      change: function(name_of_container, value) {
        $(name_of_container+" > .value").html(value);
      },
      update: {
        words: function() {
          window.fn.live.change('#wordsInformation',
            window.fn.live.info.words()
          );
        }
      },
      info: {
        words: function() {
            store = window.fn.editor.string();

            store = store.replace(/:|(|)|,|\./g,'');
            store = store.replace(/-/g,' ');


            // console.log("BEFORE COUNT: "+store);
            word_count = store.split(' ').length;
            return word_count;
        }
      }//end infofor
    },//end live











    /*
     & All functions that refer to the user being signed in, all the
     & areas that give the application its dynamic feel to it.
     & Will include lots of id related functions.
     */
    user: {
      /*
       | For initializing anything on the page and doing some checks
       | to make sure app is represented correctly for users that
       | are signed in - NOT JUST FOR NEW SIGN INS - FOR UPDATING ANYTHING
       | THAT ISN'T DONE YET - Usually done after some management is done
       | in the backend that needs to be re-rendered.
       | This function is the only area that will check if user is signed in
       | or not - so base code that needs that in this functions or call
       | other functions from the IF and ELSE area.
       | IF   = LOGGED IN
       | ELSE = NOT LOGGED IN
       */
      begin: function(fast) {

          // Calling the API user-data GET request that returns if the
          // user is signed in for starter. - Useful for frontend checks
          // that don't sabotage the backend.
          $.get('/api/get/user-data', function(response){
              // console.log(response);
              let json = JSON.parse(response);
              var speed            = (fast == true)? 0: 300;
              if (json.signed_in == true) {
                var settings_profile = json.settings_profile;

                $('#bottom').slideUp(speed, function(){
                  $(this).html(settings_profile).slideDown(speed);
                });

                // Each hash change, we check if there's a change in the essay (will not
                // do anything if not an essay) then check if an essay needs to load in,
                // incase the hash changes to another essay.
                $(window).on('hashchange', function(){
                  window.fn.user.watch_essay_for_changes(); // watches for changes in essay then saves
                  window.fn.user.check_essay_needs_loading_in(); // check if a new essay needs loading in
                  // alert('triggered');
                });
                if (window.location.hash.substring(1)) {
                  window.fn.user.watch_essay_for_changes(); // watches for changes in essay then saves

                }


                $.snackbar({
                  content: "Successfully logged in",
                  timeout: 3000,
                });

                $('.logged-in-remove').remove();
            }

            else if (json.signed_in == false) {
              var no_session = json.no_session;
              $('#bottom').slideUp(speed, function(){
                $(this).html(no_session).slideDown(speed);
              });
              $('.logged-in-remove').fadeIn(250);
            }
          });
      },

      check_essay_needs_loading_in: function() {
        // checks the url (hash) to see if it needs to try
        // to load in an essay.

        // handles:
        // -- changing the title of the page to "ESSAY IDENTIFIER | Essay'd".
        // -- placing all the essay parts into the essay from return from the POST request.
        // -- quickly adding all this before the user starts to edit their essay.

        // Check if there's a hash and if the hash isn't the currently loaded hash.
        if (window.location.hash.substring(1) && window.location.hash.substring(1) != window.loaded_essay_id) {

            console.log('doing this :)');
            let id = window.location.hash.substring(1);

            $.get('/api/get/essay-init/'+id, function(response){
                // console.log(response);
                let json = JSON.parse(response);

                if (json.success == true) {
                  $('title').html( json.identifier + ' | Essay\'d' );
                  $("#title > .INTERNAL").html( json.title );
                  $('#introduction > .INTERNAL').html( json.introduction );
                  $('.paragraph').remove();
                  for (var i = 0; i < json.paragraphs.length; i++) {
                    $('#paragraphs').append(
                      '<div class="paragraph">'+json.paragraphs[i]+'</div>'
                    );
                  }
                  $('#conclusion > .INTERNAL').html( json.conclusion );
                  window.fn.live.update.words();
                  window.loaded_essay_id = json.id;
                  window.fn.paragraph.restate();

                }

                else {
                  window.fn.editor.set_default();

                }
            });

        }

        else {
          window.fn.editor.set_default();
        }

      },//end of loading in essay check
      watch_essay_for_changes: function() {
        var old_s = undefined;
        var watcher = setInterval(function(){
          if (old_s === undefined) old_s = window.fn.editor.string();
          var new_s = window.fn.editor.string();

          if (old_s != new_s) {
              console.log('saving!');
              $.post('/api/post', {
                type: 'save',
                id: window.location.hash.substring(1),
                package: window.fn.editor.package()
              }, function(response){
                console.log(response);
              });
              old_s = window.fn.editor.string();
          } else {
              // console.log('nothing happened... will do nothing...');
          }
        }, 2000);
      }
    },//end user












    editor: {
      package: function() {
        window.fn.paragraph.restate();
        var packaged = {
          title: $('#title > .INTERNAL').html(),
          introduction: $('#introduction > .INTERNAL').html(),
          paragraphs: [],
          conclusion: $('#conclusion > .INTERNAL').html()
        }
        $('.paragraph').each(function(index, item){
          packaged.paragraphs.push( $(item).html() );
        });
        // console.log(packaged);
        return packaged;
      },

      unpackage: function(packaged) {
          // needs title, introduction, paragraphs and conclusion
          $('#title > .INTERNAL').html(packaged.title);
          $('#introduction > .INTERNAL').html(packaged.introduction);
          $('#conclusion > .INTERNAL').html(packaged.conclusion);

          $('#paragraphs > .paragraph').remove();
          for (var i = 0; i < packaged.paragraphs.length; i++) {
            $('#paragraphs').append(
              '<div class="paragraph">'+packaged.paragraphs[i]+'</div>'
            );
          }

          return true;
      },

      string: function() {
        store = $('#title > .INTERNAL').html() + ' ';
        store = store + $('#introduction > .INTERNAL').html() +  '';
        $('.paragraph').each(function(index, item){  store = store + $(item).html() + ' ';  });
        store = store + ' ' + $('#conclusion > .INTERNAL').html();

        store = store.replace('  ', ' ').replace(/<(?:.|\n)*?>/gm, '');
        return store;
      },
      set_default: function() {
        // Loading the defaults from the window.defaults object.
        let defaults = window.defaults;
        $('#title > .INTERNAL').html( defaults.title );
        $('#introduction > .INTERNAL').html( defaults.introduction );
        $('.p1').html( defaults.paragraph1 );
        $('.p2').html( defaults.paragraph2 );
        $('#conclusion > .INTERNAL').html( defaults.conclusion );
      },


      // Will remove all content and give a fresh new document
      // to edit in.
      new_document: function() {
          $('.introduction > .INTERNAL').html('');
          $('.p1').html(' ');
          $('.p2').remove();
          $('.conclusion > .INTERNAL').html(' ');

          $('.title > .INTERNAL').html('Your new Essay\'d document!');
      },

      contains_all_elements: function() {
        // console.log('PARAGRAPH: "'+ $('#paragraphs').html() +'"');
        // if ($('#title').html() == "") {
        //   $('#title').append('<div class="titler titler-title" data-for="title" contenteditable="false" readonly>TITLE</div>');
        //   // $('#title').append('<div class="titler titler-title" data-for="title" contenteditable="false" readonly>TITLE</div>');
        //   window.fn.editor.unpackage(window.cache);
        // }
        // if ($('#introduction').html() == "") {
        //   $('#introduction').append('<div class="titler titler-introduction" data-for="introduction" contenteditable="false" readonly>INTRODUCTION</div>');
        //   // $('#introduction').append('<div class="titler titler-introduction" data-for="introduction" contenteditable="false" readonly>INTRODUCTION</div>');
        //   window.fn.editor.unpackage(window.cache);
        // }
        // if ($('#paragraphs').html() == "") {
        //   $('#paragraphs').append('<div class="titler titler-paragraph" data-for="paragraphs" contenteditable="false" readonly>PARAGRAPHS (<span id="paragraphnumber"></span>)</div>');
        //   window.fn.editor.unpackage(window.cache);
        // }
        // if ($('#conclusion').html() == "") {
        //   $('#conclusion').append('<div class="titler titler-conclusion" data-for="conclusion" contenteditable="false" readonly>CONCLUSION</div>');
        //   // $('#conclusion').append('<div class="titler titler-conclusion" data-for="conclusion" contenteditable="false" readonly>CONCLUSION</div>');
        //   window.fn.editor.unpackage(window.cache);
        //
        // }



        window.cache = window.fn.editor.package();
      }
    }
  }


// The "header" for js - only contains one-line pieces of code.
// For initialization of external libraries.

  $('[data-toggle="tooltip"]').tooltip();
