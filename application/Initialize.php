<?php
  /*
  | =======================================================
  | Initialization process.
  | =======================================================
  | 1. Get files from /application/modules folder.
  | 2. Filter _*.php and other into seperate assoc array.
  | 3. Load _*.php prefixes. (labelled LoadFirst)
  | 4. Load other .php prefixes.
  | 5. Load router to serve files.
  */

  // Loading in constants before any other fires.
  require_once "config/constants.php";


  $modules = glob('application/modules/*.php');

  $loaders = [
    'first' => array_filter($modules, function($fileName){
      return preg_match('/^_.*.php$/m', basename($fileName));
    }),
    'base' => array_filter($modules, function($fileName){
      return preg_match('/^[a-zA-Z]*.php$/m', basename($fileName));
    })
  ];

  // Loading from the $loaders array.
  foreach ($loaders['first'] as $fileName) // .. First-loads.
    if(is_file($fileName))
    require_once($fileName);
  foreach ($loaders['base'] as $fileName) // ... Base loads.
    if(is_file($fileName))
    require_once($fileName);


  App::Initialize();

  require_once "application/router.php";
