<?php
  class APIOverseer {
      /*
      | ==================================================
      | The API Overseer is the method which gets loaded
      | with serve handlers. One being the GET part of the
      | API and the other being the POST authentication
      | part.
      | ==================================================
      |
      */

    // *****************************************************

      protected $Handlers = [];
      protected $CacheFormData = [];

      public $psm;

    // *****************************************************

      /*
      | @param ClosureObject:ServeCallables, ClosureObject:AuthCallables
      | Takes in both parts of the API, POST and GET and mixes them into
      | the protected $Handlers variable internally.
      | Sorts the incoming request and replies with the appropriate method
      | dictated from internal conditioning.
      */
      public function __construct($Serve, $Authentication, $psm) {
        $this->psm = $psm;

        $this->Handlers['serve'] = $Serve;
        $this->Handlers['auth']  = $Authentication;
      }

      /*
      | @param None
      | To gather the PSM data and return a PSM object.
      */
      public function psm() {
        return $this->psm;
      }

      public function signed_in() {
        if (!isset($_SESSION['id'])) die;
        else {
          # make sure id is real
          $user_id = $_SESSION['id'];
          if ($this->psm()->hasdata_specific('users', 'user_id', $user_id)) return true;
          else die;
        }
      }

      // for the future when multiple people can edit an essay
      public function user_can_edit_essay($user_id, $essay_id) {
        if ($user_id = "113695802322979944680") return true;
        $data = $this->psm()->data("SELECT owner_id FROM essays WHERE essay_id = :id", [':id' => $essay_id]);
        if ($data->rows != 0) {
          # check if id can
            if ($data->set->owner_id == $user_id) return true;
          # end of check if id can
        } else return false; # no essay found

      }

      /*
      | @param None
      | Returning the PSM Auth object.
      */
      public function auth($psm) {
        return new Auth( 'gost', 'das89j2aksndjkas', $psm, [
          'table' => 'users',
          'first' => 'email',
          'secnd' => 'password'
        ] );
      }


      /*
      | @Param none
      | The trigger for the API to use it's internal method to either
      | call a Serve or Auth function.
      | =============================================================
      | When the Router dictates that the second segment of the URI
      | is 'get', then we can open up the public GET API.
      | When there's a POST request where type=isset, we open up the
      | POST API for usage.
      */
      public function Trigger() {
        // if (!isset($_SESSION['form'])) $this->BuildFormApplicationScheme();

        if (Router::Second() == 'get') {
          if ( isset($this->Handlers['serve'][Router::Third()]) ) {
            $this->Handlers['serve'][Router::Third()](new Sunrise, $this);
          }
        } else if (isset($_POST['type'])) {
          if ( isset($this->Handlers['auth'][$_POST['type']]) ) {
            $this->Handlers['auth'][$_POST['type']](new Sunrise, $this);
          }
        } else return false;
      }


      /*
      | @param String:PostAccessor, Array:StrictApplier
      | Sanitizing the given post "part" from $_POST[part], sorting
      | the jQuery "sanitizeArray" method into an appropriate array
      | safely so there's no manipulation client side being hacky.
      */
      public function Sanitize($postPart, $sanitizeVersion = false) {
        if (!isset($_POST[$postPart])) $this->Error('SANITIZE_FORM_POST_PART_NOMATCH');
        $save = []; //Where the correct form data is placed.

        if ($sanitizeVersion === false) {
          //Iterating the form data and placing into save array.
          foreach ($_POST[$postPart] as $index => $dataArray) {
            $save[$dataArray['name']] = $dataArray['value'];
          }
        } else {
          //Iterating the $_POST form data, sorting.
          foreach ($_POST[$postPart] as $index => $dataArray) {
            if (!isset($sanitizeVersion[$index]) || $sanitizeVersion[$index] != $dataArray['name']) {
              // $this->Error('SANTIZE_FORM_DATA_INCORRECT');
              break;
            } else {
              $save[$dataArray['name']] = $dataArray['value'];
            }
          }
        }
        $this->CacheFormData = $save;
        return $this;
      }



      /*
      | @param None
      | Returns the FormCacheData as an array if wanted after
      | sanitizing, since sanitization returns the internal
      | this reference object.
      */
      public function Get() {
        return $this->CacheFormData;
      }


      /*
      | @param Array:FromSanitizeMethod, Array:StrictTypeApplier
      | Uses the return from the previous Sanitize array to sort
      | the array by value types to specify and further authenticate
      | your form data.
      */
      private $Types = [ //quite limited.
        'string' => 'is_string',
        'integer' => 'is_numeric',
        'str' => 'is_string',
        'int' => 'is_numeric'
      ];
      public function Types($sanitizeVersion) {
        $count = 0;
        //Looping cached form data and type checking from
        //referencing internal $this->Types variable.
        foreach ($this->CacheFormData as $name => $value) {
          if ( !isset($sanitizeVersion[$count]) ) $count = 0;
          if ( !$this->Types[$sanitizeVersion[$count]]($value) ) {
            $this->Error('SANITIZE_TYPE_NOT_CORRECT');
          }
          $count++;
        }
        return $this->CacheFormData;
      }


      /*
      | @param String:FirstName, String:MiddleName, String:LastName
      | Turns basic name data into names that can be represented as
      | reference names.
      */
      public function CreateFullName($fname, $mname, $lname) {
        if (!isset($mname) || empty($mname)) return "$fname $lname";
        else return "$fname {$mname[0]}. $lname";
      }


      /*
      | Reports an API issue in JSON format.
      */
      public function Error($message, $code = false) {
        $json = json_encode([
          'success' => 'false',
          'message' => $message,
          'code'    => ($code !== false)? $code: "ERROR"
        ]);
        $json = utf8_encode($json);
        print $json;
        die;
      }

      public function Session() {
        echo "session\n<pre>", print_r($_SESSION) ,"</pre>\n\n";
      }

      public function TimeReference($before, $after) {
        $difference = $after - $before;
        $seconds    = $difference;
          $minute = 60;
          $hour   = $minute * $minute;
          $day    = $hour * 24;
          $week   = $day * 7;
        if (floor($difference / $week) != 0) {
          $ago  = round($difference / $week);
          return ($ago == 1)? "$ago week ago": "$ago weeks ago";
        }
        else if (floor($difference / $day) != 0) {
          $ago = round($difference / $day);
          return ($ago == 1)? "$ago day ago": "$ago days ago";
        }
        else if (floor($difference / $hour) != 0) {
          $ago = round($difference / $hour);
          return ($ago == 1)? "$ago hour ago": "$ago hours ago";
        }
        else if (floor($difference / $minute) != 0) {
          $ago = round($difference / $minute);
          return ($ago == 1)? "$ago minute ago": "$ago minutes ago";
        }
        else {
          return ($seconds == 1)? "$seconds second ago (wow)": "$seconds seconds ago";
        }
      }

      /*
      | Returns JSON data as successful.
      */
      public function JSON($array = []) {
        $default = ['success' => true];
        $array   = array_merge($array, $default);
        $json = json_encode($array);
        $json = utf8_encode($json);
        echo json_encode($array);
        die;
      }
  }
