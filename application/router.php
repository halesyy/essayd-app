<?php

  # Editor
  Router::Get('editor', function($Sunrise){
      $appname = 'Essay\'d';
      $appname_by = "$appname by Jack";

      $Sunrise->Render('editor/Main', [
          'appname' => $appname,
          'appname_by' => $appname_by,
          'essay_content' => $Sunrise->Mini('editor/components/EssayContent', false, ['appname' => $appname, 'appname_by' => $appname_by]),
          'live_editing'  => $Sunrise->Mini('editor/components/LiveEditing', false, ['appname' => $appname, 'appname_by' => $appname_by]),
          'settings'      => $Sunrise->Mini('editor/components/Settings', false, ['appname' => $appname, 'appname_by' => $appname_by]),

          'dynamic_modal' => $Sunrise->Mini('editor/components/DynamicModal', false, [])
      ]);
  });

  # Dashboard
  Router::Get('dashboard', function($Sunrise, $psm){

      if (!isset($_SESSION['id'])) header('Location: /editor');
      else {
        $id = $_SESSION['id'];
        $users      = (Object) $psm->set("SELECT * FROM users WHERE user_id = :uid", [':uid' => $id]);
        $users_meta = (Object) $psm->set("SELECT * FROM users_meta WHERE user_id = :uid", [':uid' => $id]);
      }

      $appname = 'Essay\'d';
      $appname_by = "$appname by Jack";
      print $Sunrise->Mini('Dashboard', false, [
        'appname' => $appname,
        'appname_by' => $appname_by,
        'users' => $users,
        'users_meta' => $users_meta
      ]);

  });

  Router::Get('my-profile', function($Sunrise, $psm){

      if (!isset($_SESSION['id'])) header('Location: /editor');
      else {
        $id = $_SESSION['id'];
        $users      = (Object) $psm->set("SELECT * FROM users WHERE user_id = :uid", [':uid' => $id]);
        $users_meta = (Object) $psm->set("SELECT * FROM users_meta WHERE user_id = :uid", [':uid' => $id]);
      }

      print $Sunrise->Mini('profile/ProfileView', false, [
        'users' => $users,
        'users_meta' => $users_meta
      ]);

  });


  # Landing page
  Router::get('/', function($Sunrise){
      $appname = 'Essay\'d';
      $Sunrise->Render('Main', [
        'appname' => $appname
      ]);
  });
