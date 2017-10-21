<?php
  session_start();
  /*
  | =====================================================
  | Hi, welcome to the KAS Form Application API.
  | =====================================================
  | TO HAVE FURTHER DOCS.
  | This API is delegated it's own Class, as well as
  | seperate files to help dictate what needs to be ran.
  | For example, if you need to work on Authentication,
  | you need to go to /api/authentication/API.php and
  | other corresponding files.
  | If you need to do serve management, you need to go
  | to /api/serve/API.php
  */

  // *********************************************************

  /*
  | Loading in modules:
  | 1. App
  | 2. PSM
  | 3. Router
  | 4. Sunrise Rendering Engine
  */

    require_once "../application/config/constants.php";
    require_once "../application/config/database.php";

    require_once "../application/modules/_App.php";
    require_once "../application/modules/PSM.php";
    require_once "../application/modules/Sunrise.php";
    require_once "../application/modules/Router.php";
    // require_once "../application/modules/Student.php";
    // require_once "../application/modules/Family.php";

    // Google_Client.
    require_once "../application/modules/Google_Client/vendor/autoload.php";

  /*
  | Loading in API modules:
  | 1. Authentication managers
  | 2. Serve managers
  | 3. Actual API Manager class
  */


    require_once "authentication/AuthenticationHandlers.php"; #//post
    require_once "serve/ServeHandlers.php"; #//get
    require_once "APIOverseer.php"; #//manager

    Router::Initialize();

    $psm = new PSM("{$config['database']['hostname']} {$config['database']['database']} {$config['database']['username']} {$config['database']['password']}");

    $Overseer = new APIOverseer($Serve, $Authentication, $psm);
    $Overseer->Trigger();

  /**/
