<?php
  ob_start();
  session_start();
  /*
     ::::==========:::::::::::::::::::::::::::::::::::::::::::::::::::::::
     :::::::=========::::::.---------------.:::::::::::::::::::::::::::::::
     :::=============::::::| .------------. |:::::::::::::::::::::::::::::
     ::::==========::::::::| | === == ==  | |:::::::::::::::::::::::::::::::::
     ::::==========::::::::| | Kontroller | |:::::::::::::::::::::::::::::::
     :::::::=========='::::| |  Joint!    | |:::::::::::::::::::::::::::::
     :::===========::::::::| |____________| |::::::((;):::::::::::::::::::::
     """"============""""""|___________oo___|"")"""";(""""""""""""""""""""""
       ==========='           ___)___(___,o   (   .---._
          ===========        |___________| 8   \  |COF|_)    .+-------+.
       ===========                     o8o8     ) |___|    .' |_______| `.
         =============      __________8___     (          /  /         \  \
      |\`==========='/|   .'= --------- --`.    `.       |\ /           \ /|
      | "-----------" |  / ooooooooooooo  oo\    _\_     | "-------------" |
      |______I_N______| /  oooooooooooo[] ooo\   |=|     |_______JEK_______|
                       / O O =========  O OO  \  "-"   .-------,
                       `""""""""""""""""""""""'      /~~~~~~~/
     _______________________________________________/_   ~~~/_______________
     ............................................. \/_____/..desk at 17:30..
  */



  //************************************************************************************



  /*
  | @NOTE: Quick run through the application.
  | Our application is  going to be segmented into two "big" sections  instead
  | of 3 minor areas (Model View Controller), we're having the RESTful API and
  | an elegant system for creating initializing code.
  */



  //*V*A*R******************************************************************************


    define('__ROOT__', __DIR__);


  /*
  | ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  */

    // phpinfo();
    // header('Strict-Transport-Security: max-age=63072000');
    require_once "application/Initialize.php";

  /*
  | ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  */

  //***********************************************************************************

  ob_flush();
