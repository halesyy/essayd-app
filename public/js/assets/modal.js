/*
 * | Handles all events for the modals, from form submission
 * | all the way to open and closing.
 * | ----------------------------------------------------------
 * | In the end for the login / register areas, the functions will
 * | call the window.fn.user.begin() function to instanciate the
 * | areas of the app that need to be changed cause of a register or
 * | login.
 */

  // Window "modal" functions for controlling functionality
  // between the modals for the #dynamicModal.

      window.modal = function(filename) {
        // window.modal_close();
        $.get('/api/get/modal/'+filename, function(response){
            console.log(response);

            let json    = JSON.parse(response);
            let $placer = $('#modalBody');
            let $modal  = $('#dynamicModal');

            $placer.html(json.body);
            $modal.modal('show');
        });
      }

      window.logout = function() {
        $.get('/api/get/logout', function(response){
            window.fn.user.begin();
            window.location.href = "/editor";
            window.location.reload();
        });
      }

      window.modal_close = function() {
        $('#dynamicModal').modal("hide");
        // return window;
      }

      window.modal_close_callable = function(callable) {
        $('#dynamicModal').modal("hide");
        $('#dynamicModal').on('hidden.bs.modal', function (e) {
          callable();
          $('#dynamicModal').off('hidden.bs.modal');
        });
      }





  // Modal register / login functionality form submissions.

      $(document).on('submit', '#register-form, #login-form', function(event){
          event.preventDefault();
          let type = $(this).attr('data-type');
          if (type == 'login') {
            $.post('/api/post/', {
                type: 'login',
                form: $(this).serializeArray()
            }, function(response){
                // console.log(response);
                let json = JSON.parse(response);

                if (json.success == true) {
                  window.fn.basic.error_alert({
                    appendto: '#login-form',
                    message:  'Successfully logged in',
                    type:     'success'
                  });
                  window.modal_close();
                  window.fn.user.begin(false);
                }
                else {
                  window.fn.basic.error_alert({
                    appendto: '#login-form',
                    message:  json.message
                  });
                }
            });
          }
          if (type == 'register') {
              $.post('/api/post/', {
                type: 'register',
                form: $(this).serializeArray()
              }, function(response){
                console.log(response);
                let json = JSON.parse(response);

                if (json.success == true) {
                  window.fn.basic.error_alert({
                    appendto: '#register-form',
                    message:  'Successfully registered',
                    type:     'success'
                  });
                  window.modal_close();
                  window.fn.user.begin(false);
                }
                else {
                  window.fn.basic.error_alert({
                    appendto: '#register-form',
                    message:  json.message
                  });
                }

              });
          }
      });
      /* for google sign in handling */
      function Google_Login_Controller(googleUser) {
        var profile  = googleUser.getBasicProfile();
        var id_token = googleUser.getAuthResponse().id_token;

        console.log('Attempting Google login...');
        $.post('/api/post/', {
            type: 'google-login',
            id_token: id_token
        }, function(response){
            let json = JSON.parse(response);
            if (json.success == false) {
              window.fn.basic.error_alert({
                appendto: '.ggl-signin',
                message:  json.message
              });
            } else {
              window.modal_close();
              window.fn.user.begin(false);
            }
        });
      }


  // Initializing if an essay is to be saved.

      $(document).on('submit', '#save-essay-form', function(event){

          event.preventDefault();
          if ($('#essay_identifier').val() == 'Your essay identifier here') {
            window.fn.basic.error_alert({
              appendto: $(this).find('.col-8'),
              message:  'Please change your essay identifier from default :)'
            });
          } else {
            $.post('/api/post', {
                type: 'save-init',
                identifier: $('#essay_identifier').val(),
                options: {
                    anoncomments: $('#c1').is(':checked')
                },
                package: window.fn.editor.package()
            }, function(response){
              console.log(response);
                let json = JSON.parse(response);

                if (json.success == true) {
                  window.modal_close();
                  window.location.hash = json.id;
                  window.fn.user.begin(); // to remodel the page for a user
                }
            });
          }

      });
