<?php
  class App {
      /*
      | First loaded OOP Component, handles session
      | over the entire app and is used as a static
      | accessor & reporter.
      | @NOTE not specific param inputs, etc since
      | this is a small class for the app, not important.
      */

    //*******************************************************

      protected static $consoleMessages = [];
      protected static $configDirectory = 'application/config/';

    //*******************************************************


      /*initializes the app and returns app status, bool.
      any "app failed" requirements go in this function*/
      public static function Initialize() {
        self::Console('Loaded app');

          /*INITIALIZING OTHER STATIC CLASSES*/
          Router::Initialize();

        return true;
      }

      public static function Config($configName) {
        $dir = self::$configDirectory;
        $dir .= $configName.'.php';
        return $dir;
      }

      /*add a string message to console to report later on.
      also shorthand for printing if no param 0 given.*/
      public static function Console($message = false) {
        if (!$message) self::PrintConsole();
        else array_push(self::$consoleMessages, $message);
      }

      /*prints entirety of console array to optstream.*/
      public static function PrintConsole() {
        self::Display(self::$consoleMessages);
      }

      /*displays an array using preformmatted tags.*/
      public static function Display($array) {
        echo "<pre>", print_r($array) ,"</pre>";
      }

      /*return array of module locations.*/
      public static function Modules($moduleArray) {
        foreach ($moduleArray as &$module)
        $module = "application/modules/$module";
        print_r($moduleArray);
      }

  }
