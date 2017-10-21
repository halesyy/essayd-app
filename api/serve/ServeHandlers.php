<?php
  $Serve = [

      'modal'  =>  function($Sunrise)  {
          # /api/get/modal/{filename}
          $filename = Router::Fourth();
          $filedata = $Sunrise->Render("editor/modal_components/{$filename}", [
            'VERSION' => VERSION
          ], '..', false, [], true);
          echo json_encode(['success' => true, 'body' => $filedata]);
      },



      'users-essays' => function($Sunrise, $API) {
        $API->signed_in();
        $psm = $API->psm();
        $id  = $_SESSION['id'];
        $collection = [];
        foreach ($psm->cquery("SELECT essay_id,identifier,_introduction,last_edited FROM essays WHERE owner_id = :uid ORDER BY last_edited DESC", [':uid' => $id])->fetchAll(PDO::FETCH_ASSOC) as $row) {
          array_push($collection, [
            'id' => $row['essay_id'],
            'identifier' => $row['identifier'],
            'introduction' => $row['_introduction'],
            'last_edited' => $API->TimeReference($row['last_edited'], time())
          ]);
        }
        // echo "<pre>", print_r($collection) ,"<pre>";

        $API->JSON([
          'ids' => $collection
        ]);
      },



      'essay-init' => function($Sunrise, $API) {
          $API->signed_in();
          # /api/get/essay-init/{id}
          $id = Router::Fourth();

          $psm  = $API->psm();
          $data = $psm->data("SELECT * FROM essays WHERE essay_id = :id", [':id' => $id]);

          if ($data->rows != 1) $API->Error('Sorry, that Essay doesn\'t exist!', 'ESSAY_NOT_EXIST');
          if (!$API->user_can_edit_essay($_SESSION['id'], $id)) $API->Error('Sorry, this is not your essay.', 'NOT_YOUR_ESSAY');

          $API->JSON([
            'id' => $data->set->essay_id,
            'identifier' => $data->set->identifier,
            'title' => $data->set->_title,
            'introduction' => $data->set->_introduction,
            'paragraphs' => unserialize($data->set->_body),
            'conclusion' => $data->set->_conclusion
          ]);
      },


      'user-data'  =>  function($Sunrise, $API)  {
          if (!isset($_SESSION['id'])) {
            $no_session = $Sunrise->Mini('user_dynamic/Settings_NoSession', '..', []);

            $API->JSON([
              'signed_in' => false,
              'no_session' => $no_session
            ]);
          }
          $psm = $API->psm();
          if ( $psm->hasdata_specific('users', 'user_id', $_SESSION['id']) ) {
            $users      = (Object) $psm->set("SELECT email,name FROM users WHERE user_id = :uid", [':uid' => $_SESSION['id']]);
            $users_meta = (Object) $psm->set("SELECT * FROM users_meta WHERE user_id = :uid", [':uid' => $_SESSION['id']]);

            $body = $Sunrise->Mini('user_dynamic/Settings_Profile', '..', [
              'users' => $users,
              'users_meta' => $users_meta
            ]);
            $API->JSON([
              'signed_in' => true,
              'settings_profile' => $body
            ]);
          }
          else {
            $API->Error('Auth was incorrect, userid doesnt exist? Was the user deleted?', 'NO_USER_ID');
          }
      },


      'logout'  =>  function($Sunrise)  {
          session_unset();
      }

  ];
