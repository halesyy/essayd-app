<?php
  class Router {
      /*
      | Static class built to parse the SLUG-based URL and
      | return segments of it which are dictated.
      */

    // ******************************************************

      static protected $url;
      static protected $segments;

    // ******************************************************

      /*
      | @param None
      | Starts the static App.
      */
      public static function Initialize() {
        self::$url = $_SERVER['REQUEST_URI'];
        self::$segments = explode('/', self::$url);
      }



      /*
      | @param None
      | Reports a test back to the developer.
      */
      public static function Test() {
        echo 'Test recieved from router, here\'s the URI: '.self::$url;
      }



      /*
      | @param Int:SegmentOfUrl
      | Uses integer to reference the internal URL variable
      | and retrieve the part of the URL(URI) that relates to
      | it split by /.
      */
      protected static function URLParser($segment) {
        if (isset(self::$segments[$segment])) {
          return self::$segments[$segment];
        } else return false;
      }



      /*
      | @param None
      | Shorthand methods for getting URL segments and main
      | -taining them.
      */
      public static function First() {
        return (empty(self::URLParser(1)))? '/': self::URLParser(1);
      }
      public static function Second() {
        return self::URLParser(2);
      }
      public static function Third() {
        return self::URLParser(3);
      }
      public static function Fourth() {
        return self::URLParser(4);
      }
      public static function Fifth() {
        return self::URLParser(5);
      }
      public static function Segment($segment) {
        return self::URLParser($segment);
      }



      /*
      | @param String:Capture, Callable:Handshake
      | Used as a reference to the URI supplied in the Router.
      | Supply a first segment of URI as your "capture", if
      | successfully "captured", will run the callabke allowing
      | you to do database requests, managing, etc... You
      | may even call other classes segmented as Controllers.
      | -------------------------------------------------------
      | Handshake (since async) should return a numerative array.
      | Array will contain first the file which is to be rendered
      | (since we never want NO data being served) as well as
      | the data to be given along to the file for rendering.
      */
      public static function Get($capture, callable $handshake) {
        if (self::First() == $capture) {

          require App::Config('database'); #Loads in the $config['database'] variable segment.
          $psm = new PSM("{$config['database']['hostname']} {$config['database']['database']} {$config['database']['username']} {$config['database']['password']}");
          $r   = $handshake(new Sunrise, $psm);

          // if (count($r) != 2) die('Counting of GET callback not 2');
          // $sunrise = new Sunrise; #Page rendering engine.
          // $sunrise->Render( $r[0], $r[1] ); #Supplying callback data to rendering engine.

        } else return false;
      }
  }
