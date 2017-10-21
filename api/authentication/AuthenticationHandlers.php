<?php
  $Authentication = [

      'save-init'  =>  function($Sunrise, $API)  {
          $API->signed_in();

          $psm  = $API->psm();
          $auth = $API->auth($psm);

          $post    = (Object) $_POST;
          $options = (Object) $post->options;
          $package = (Object) $post->package;
          $identifier = $post->identifier;

          # generate unique id for the essay
          $unique_user_id_generated = false;
          while ($unique_user_id_generated === false) {
              $id = hash( 'tiger128,4', rand(1000000000, 9999999999) );
              if ( $psm->hasdata_specific('essays', 'id', $id) ) continue;
              else { $unique_user_id_generated = true; break; }
          }

          // echo "<pre>", print_r($package) ,"</pre>";

          # push data
          $psm->Insert('essays', [
            'essay_id' => $id,
            'identifier' => $identifier,
            '_title' => $package->title,
            '_introduction' => $package->introduction,
            '_body' => serialize($package->paragraphs),
            '_conclusion' => $package->conclusion,
            'last_edited' => time(),
            'owner_id' => $_SESSION['id'], #has had auth
            'anonymous_comments' => ($options->anoncomments == "true")? '1': '0'
          ]);

          $API->JSON([
            'id' => $id
          ]);
          // # return {essayId:"generatedID"}
      },


      'save'  =>  function($Sunrise, $API)  {
          $post    = (Object) $_POST;
          $API->signed_in();
          if (!$API->user_can_edit_essay($_SESSION['id'], $post->id)) $API->Error('User can\'t edit this essay.', 'NOT_ALLOWED');

          # user can edit + essay is real + is signed in.
          $psm     = $API->psm();
          $package = (Object) $post->package;
          $id      = $post->id;

          # push data
          $psm->Update('essays', [
            '_title' => $package->title,
            '_introduction' => $package->introduction,
            '_body' => serialize($package->paragraphs),
            '_conclusion' => $package->conclusion,
            'last_edited' => time()
          ], "essay_id = $id");

          $API->JSON([]);
      },


      'login'  =>  function($Sunrise, $API)  {
          # get psm
          $psm  = $API->psm();
          $auth = $API->auth($psm);

          # get form data from post[form]
          $form = (Object) $API->Sanitize('form')->Get();

          # authenticating + returning JSON calls
          if ( $auth->Correct($form->lg_email, $auth->hash($form->lg_password)) !== false ) {
            $row = $auth->Get()->set;
            session_unset();
            $_SESSION['id'] = $row->user_id;
            $API->JSON();
          } else {
            $API->Error('Incorrect username/password.', 'INCORRECT_DATA');
          }
      },








      'register'  =>  function($Sunrise, $API)  {

        # get psm
        $psm  = $API->psm();
        $auth = $API->auth($psm);

        # get form data from post[form]
        $form = (Object) $API->Sanitize('form')->Get();


        # checks on data for safety
        if ( $psm->hasdata_specific('users', 'email', $form->rg_email) ) $API->Error('Email already in use!', 'EMAIL_IN_USE');
        if ( $form->rg_password != $form->rg_password_auth ) $API->Error('Passwords don\'t match!', 'PASSWORD_NO_MATCH');

        # generate user id
        $unique_user_id_generated = false;
        while ($unique_user_id_generated === false) {
            $user_id = "u".rand(100000000000, 999999999999);
            if ( $psm->hasdata_specific('users', 'user_id', $user_id) ) continue;
            else { $unique_user_id_generated = true; break; }
        }

        #insert
        $psm->Insert('users', [
          'email' => $form->rg_email,
          'password' => $auth->hash( $form->rg_password ),
          'user_id' => $user_id,
          'name' => '',
          'email_verified' => '0',
          'using_google' => '0',
          'ip' => $_SERVER['REMOTE_ADDR']
        ]);
        $last = $psm->last();
        $psm->Insert('users_meta', [
          'user_id' => $user_id,
          'last_login' => time(),
          'signup_date' => date('j - n - Y'),
          'picture' => ''
        ]);

        $_SESSION['id'] = $user_id;
        print json_encode(['success' => true]);
      },








      'google-login'  =>  function($Sunrise, $API)  {

        $post    = (Object) $_POST;
        $client  = new Google_Client([
          'client_id'     => '425983720452-i8go5du2japrogjjkgdt1k7pjgkvftcl.apps.googleusercontent.com',
          'client_secret' => 'DwJIKMWNjSw26kG0dJ9gUqXc'
        ]);

        $payload = $client->verifyIdToken($post->id_token);
        $payload = (Object) $payload;

        $psm  = $API->psm();

        if ($payload) {
          if ( $psm->hasdata_specific('users', 'user_id', "{$payload->sub}") ) { # login FOR user_id

            $data = $psm->set("SELECT user_id FROM users WHERE user_id = :sub", [ ':sub' => $payload->sub ]);
            $_SESSION['id'] = $data['user_id'];
            $API->JSON();

          }
          else if ( $psm->hasdata_specific('users', 'email', "{$payload->email}") ) { # login FOR email

            $data = $psm->set("SELECT user_id FROM users WHERE email = :ema", [ ':ema' => $payload->email ]);
            $_SESSION['id'] = $data['user_id'];
            $API->JSON();

          }
          else { # register FOR else, new email
            $psm->Insert('users', [
              'email' => $payload->email,
              'password' => 'GOOGLE',
              'user_id' => $payload->sub,
              'name' => $payload->name,
              'email_verified' => $payload->email_verified,
              'using_google' => '1',
              'ip' => $_SERVER['REMOTE_ADDR']
            ]);
            $last = $psm->last();
            $psm->Insert('users_meta', [
              'user_id' => $payload->sub,
              'last_login' => time(),
              'signup_date' => date('j - n - Y'),
              'picture' => $payload->picture
            ]);
            // Setting up session & returning data.
            $_SESSION['id'] = $payload->sub;
            $API->JSON();
          }


        }

        else $API->Error('Failed to login.', 'NO_LOGIN_USING_GOOGLE_AUTH');

      } // end of google login


  ];
