<?php
  class Sunrise {

      /*
      | Sunrise is a simple Rendering engine I'm
      | building to be lightweight and incorporate
      | important rendering features for building
      | dynamic documents from PHP-retrieved data.
      */

    // *******************************************

      public $ServeDirectory = 'serve/';
      public $Content = '';
      public $Cache = [];

    // *******************************************



      /*
      | @param String:ServeFileName, Array:Data, String:PrependToString
      | 1. Will use the internal class method to
      |    safely retrieve data.
      | 2. Using another internal method to implement
      |    user data into document.
      */
      public function Render($fileName, $fileData = [], $prepend = false, $cache = false, $predefined = [], $return = false) {
        $dir = $this->ServeDirectory;
        #//prepend is used if the require for example API isn't in the entry.php
        #//file, and anchor is different.
        if ($cache !== false)   $this->Cache = $cache;
        if ($prepend !== false) $dir = $prepend.'/'.$dir;
        $dir .= $fileName.'.php';
        $this->RetrieveFileContent($dir, $predefined);
        $this->ImportVariables($fileData);
        $this->SortTriggers();
        $this->SessionSifter();


        if (!$return)
          print $this->Content;
        else {
          $this->Cache = [];
          return $this->Content;
        }
        $this->Cache = [];
      }

      /*
      | @param String:MiniFileName
      | Meant for areas in forms that are dynamic and need to be loaded
      | in using PHP and HTML combined. Will use an output buffer to render
      | and return the data.
      */
      public function Mini($fileName, $prepend = false, $VarDefinitions = []) {
        $dir = "serve/{$fileName}.php";
        $dir = ($prepend)? $prepend.'/'.$dir: $dir;
        ob_start();
          foreach ($VarDefinitions as $VarName => $VarValue){ ${$VarName} = $VarValue; }
          include( $dir );
        return ob_get_clean();
      }


      /*
      | @param None:UsesInternalContent
      | Looks for triggers for shorthand development. Usually
      | used to reference cleaner code and build bootstrap grids.
      */
      public $TriggerConversions = [
        'whole'  => 'col-lg-12 col-md-12 col-sm-12 col-xs-12 custom-col',
        'two'  => 'col-lg-2 col-md-2 col-sm-2 col-xs-2 custom-col',
        'ten'   => 'col-lg-10 col-md-10 col-sm-4 col-xs-12 custom-col',
        'half'   => 'col-lg-6 col-md-6 col-sm-6 col-xs-12 custom-col',
        'six'    => 'col-lg-6 col-md-6 col-sm-6 col-xs-12 custom-col',
        'third'  => 'col-lg-4 col-md-4 col-sm-4 col-xs-12 custom-col',
        'three'  => 'col-lg-3 col-md-3 col-sm-3 col-xs-3 custom-col',
        'four'   => 'col-lg-4 col-md-4 col-sm-4 col-xs-12 custom-col',
        'third-expands' => 'col-lg-4 col-md-6 col-sm-12 col-xs-12 custom-col',
        'third-expands-end' => 'col-lg-4 col-md-12 col-sm-12 col-xs-12 custom-col',
        'fourth' => 'col-lg-3 col-md-3 col-sm-6 col-xs-12 custom-col',
        'fourth-stable' => 'col-lg-3 col-md-3 col-sm-3 col-xs-3 custom-col',
        'nine' => 'col-lg-9 col-md-9 col-sm-6 col-xs-12 custom-col',
        'eight' => 'col-lg-8 col-md-8 col-sm-8 col-xs-8 custom-col',
        'seven' => 'col-lg-7 col-md-7 col-sm-7 col-xs-7 custom-col',
        'one' => 'col-lg-1 col-md-1 col-sm-1 col-xs-1 custom-col',
        'eleven' => 'col-lg-11 col-md-11 col-sm-11 col-xs-11 custom-col'
      ];
      public function SortTriggers() {
        $Content  = $this->Content;
        $lines = explode("\n", $Content);
        foreach ($lines as $index => $line) {
          // Managing for "triggers"
            if (isset(trim($line)[0]) && trim($line)[0] == '@') {
              $trigger = ltrim(explode(' ', trim($line))[0], '@'); //@trim => trim.
              // Going to neaten this up when I get some free time for
              // creating a better flow for development.
              if ($trigger == 'countries') {
                $lines[$index] = $this->Mini('form/Countries', '..');#// Generating the line to evaluate to a country selector.
              } else if ($trigger == 'gender') {
                $lines[$index] = $this->Mini('form/Gender', '..');#// Gender selector.
              } else if ($trigger == 'yearlevel') {
                $lines[$index] = $this->Mini('form/YearLevel', '..');#// Year level selector.
              } else if ($trigger == 'yeartoenrol') {
                $lines[$index] = $this->Mini('form/YearToEnrol', '..');#// The year to enrol selector, will be dynamic later.
              } else if ($trigger == '//') {
                $lines[$index] = "</div>";
              } else if ($trigger == 'row') {
                $lines[$index] = "<div class='row'>";
              } else if (isset($this->TriggerConversions[$trigger])) {
                // @fourth -> <div class="col-lg-3" ...>
                $colstr = $this->TriggerConversions[$trigger];
                $lines[$index] = "\n<div class='{$colstr}'>";
              } else if ($trigger == 'six-row') {
                $lines[$index] = "<div class='row'><div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 custom-col'>";
              } else if ($trigger == '////') {
                $lines[$index] = "</div></div>";
              } else {
                //Remove -connection and get the TriggerConversions from the public variable.
                if (isset($this->TriggerConversions[str_replace('-connection', '', $trigger)])) $colstr = $this->TriggerConversions[str_replace('-connection', '', $trigger)];
                $lines[$index] = "\n</div><div class='{$colstr}'>";
              }
            }

          // Managing for "packets".
            if (preg_match('/\[.*\]/', trim($line))) {
              $line    = rtrim(ltrim(trim($line), '['), ']');
              $pieces  = explode(' ', $line);
              $trigger = $pieces[0];
              if ($trigger == 'label') { #//TO REFINE. SEPERATE METHODS IN ANOTHER FILE.
                $line   = preg_replace('/label \"(.*)\" for \"(.*)\"/', '$1::::$2', $line);
                $pieces = explode('::::', $line);
                if (count($pieces) != 2) die('Sunrise engine err: Not two preg replace eval zones');
                $pieces[0] = str_replace('*', "<span class='required'>*</span>", $pieces[0]); #//turns * into class given * for requirement styling
                // Push packet after management.
                $lines[$index] = "\n<label for='{$pieces[1]}'>{$pieces[0]}</label>";
              }
            }
        }

        // Push content after finishing rebuilding &
        // reconstructing everything.
        $this->Content = implode("\n", $lines);
      }



      /*
      | @param String:FileDirectory
      | Will serve the file given to it safely
      | making sure no errors are encountered.
      | If found, returns the file data as well
      | as sets it in the public variable $Content.
      */
      public function RetrieveFileContent($fileName, $predefined = []) {
        if (is_file($fileName)) {
          // print_r($predefined);
          ob_start();
            // foreach ($predefine as $varname => $vardata) ${$varname} = $vardata;
            extract($predefined, EXTR_SKIP);
            // print_r($predefined);
            include($fileName);
          $Content = ob_get_clean();
          $this->Content = $Content;

          return $Content;
        } else {
          echo "<b>File not found</b>: {$fileName} <br/> <b>Current working directory</b>: ".getcwd()."";
          die();
        }
      }



      /*
      | @param Array:FileData
      | Uses the internal buffered $Content string
      | as the anchor for importing using the given
      | FileData Array provided. {{var}} as var is
      | referenced in the Array from keys.
      */
      public function ImportVariables($fileData) {
        $content = $this->Content;
        #//Seperating the array sections for document variables.
        $variableNames   = array_keys($fileData);
        $variableResults = array_values($fileData);
        #//Walking with the name array to prepend {{ and append }}.
        array_walk($variableNames, function(&$item){ $item = '{{'.$item.'}}'; });
        $content = str_replace($variableNames, $variableResults, $content);
        $this->Content = $content;
      }



      /*
      | @param None
      | Sift through the lines and find tripple triggers signalling a
      | call to the session area or student data retireval.
      | Usually used to get data when editing a student.
      | * COME BACK AND CLEAN UP!
      */
      public function SessionSifter() {
        // Removing all display:none's is there's an edit going on.
        // if (isset($this->Cache['StudentID'])) {
        //   $this->Content = str_replace('display: none;', '', $this->Content);
        // }

        // Loading the "Counts" module, a powerful but basic
        // line parsing Class.
        require_once "Counts.php";
        Counts::SetIndicator(['::', '!:', ':', '.', '~~']);
        $Content = $this->Content;
        $Lines   = explode("\n", $Content);
        $Lines   = array_map('trim', $Lines);
        // Looping each line of the "being-rendered" page to
        // see if there's a need for pulls from session to insert
        // data.
        foreach ($Lines as &$Line):
          if ($this->Contains(['{{{', '}}}'],$Line)) { #Line contains {{{...}}}
            // Getting what's in the {{{...}}} in the line.
            $Extract = []; preg_match('/{{{(.*)}}}/', $Line, $Extract);
            $Extract = $Extract[0];
            $Extract = str_replace(['{{{', '}}}'], ['', ''], $Extract);

            #extract=StudentID, going to place in the StudentID.
            if ($Extract == 'StudentID') {
              $Return = (isset($this->Cache['StudentID']))? $this->Cache['StudentID']: 'false';
              $Line = preg_replace('/{{{(.*)}}}/', $Return, $Line);
            }
            #extrat=FamilyID, going to place in the FamilyID.
            else if ($Extract == 'FamilyID') {
              $Return = (isset($this->Cache['FamilyID']))? $this->Cache['FamilyID']: 'false';
              $Line = preg_replace('/{{{(.*)}}}/', $Return, $Line);
            }
            #extract[0] not set, no cached student or family - going to remove {{{...}}}.
            else if ( !isset($Extract[0]) || !isset($this->Cache['Student']) && !isset($this->Cache['Family']) ) {
              $Line = preg_replace('/{{{(.*)}}}/', '', $Line);
            }
            #else, so do manip on inner side of it.
            else {
              if (isset($this->Cache['Student']))     $Handler = $this->Cache['Student'];
              else if (isset($this->Cache['Family'])) $Handler = $this->Cache['Family'];

              ##search for :: has 1
              if (Counts::Count($Extract)['::'] == 1) {
                $Split = explode('::', $Extract);
                $Extract = $Split[0];
                $Eval    = $Split[1];
                  $Evals = explode('--', $Eval);
                // Needs to eval [1] if return of [0] is true.
                $Pieces = explode('.', $Extract);
                $Entry  = $Pieces[0];
                $Data = $Handler->Get($Entry, $this->ArrayFrom(1, $Pieces));
                if ($Data == "{$Evals[0]}") {
                  $Line = preg_replace('/{{{(.*)}}}/', $Evals[1], $Line);
                } else $Line = preg_replace('/{{{(.*)}}}/', '', $Line);
              }
              #search for function call
              else if ($this->Contains(['()'], $Extract)) {
                $MethodName = str_replace('()', '', $Extract);
                $Line = $Handler->$MethodName();
              }
              ##search for !: has 1
              else if (Counts::Count($Extract)['!:'] == 1) {
                $Split = explode('!:', $Extract);
                $Extract = $Split[0];
                $Eval    = $Split[1];
                // Needs to eval [1] if return of [0] is true.
                $Pieces = explode('.', $Extract);
                $Entry  = $Pieces[0];
                $Data = $Handler->Get($Entry, $this->ArrayFrom(1, $Pieces));
                if ($Data == 'false') {
                  $Line = preg_replace('/{{{(.*)}}}/', $Eval, $Line);
                } else $Line = preg_replace('/{{{(.*)}}}/', '', $Line);
              }
              ##search for ~~ has 1, to see if not empty.
              else if (Counts::Count($Extract)['~~'] == 1) {
                $Split = explode('~~', $Extract);
                $Extract = $Split[0];
                $Eval    = $Split[1];
                $Evals   = explode('--', $Eval);
                // Needs to eval [1] if return of [0] is true.
                $Pieces = explode('.', $Extract);
                $Entry  = $Pieces[0];
                $Data = $Handler->Get($Entry, $this->ArrayFrom(1, $Pieces));
                // echo (empty($Data))? 'YES THE AREA IS EMPTY!': 'NO THE AREA ISNT EMPTY!';
                if (empty($Data) || $Data == '') {
                  $Line = preg_replace('/{{{(.*)}}}/', $Eval[1], $Line);
                } else {
                  $Line = preg_replace('/{{{(.*)}}}/', $Eval[0], $Line);
                }
              }
              ##search for : has 1
              else if (Counts::Count($Extract)[':'] == 1) {
                $Split = explode(':', $Extract);
                $Extract = $Split[0];
                $Eval    = $Split[1];
                // Needs to eval [1] if return of [0] is true.
                $Pieces = explode('.', $Extract);
                $Entry  = $Pieces[0];
                $Data = $Handler->Get($Entry, $this->ArrayFrom(1, $Pieces));
                if (strtolower($Data) == 'true') {
                  $Line = preg_replace('/{{{(.*)}}}/', $Eval, $Line);
                } else $Line = preg_replace('/{{{(.*)}}}/', '', $Line);
              }
                // if ($Data == "{$Evals[0]}") {
                //   $Line = preg_replace('/{{{(.*)}}}/', $Evals[1], $Line);
                // } else $Line = preg_replace('/{{{(.*)}}}/', '', $Line);
              ##else, explode by . and serve handler data.
              else {
                $Pieces  = explode('.', $Extract);
                $Entry   = $Pieces[0]; //#
                // We have the Student object and can now use it to gather data.
                $Data = $Handler->Get($Entry, $this->ArrayFrom(1, $Pieces));
                $Line = preg_replace('/{{{(.*)}}}/', $Data, $Line);
              }
            }//end of session serve cause contains {{{}}}
          }//end of {{{}}} contains
        endforeach;
        $this->Content = implode("\n", $Lines);
      }

      /*SM:returns if the array strings are inside string true, else false.*/
      public function Contains($Lookfor, $In) {
        $Contains = true;
        foreach ($Lookfor as $index => $Lookingfor)
          if (strpos($In, $Lookingfor) === false)
          $Contains = false;
        return $Contains;
      }
      /*SM:returns rebuilt array from index given onwards*/
      public function ArrayFrom($index, $Array) {
        $c = [];
        foreach ($Array as $i => $Data):
          if ($i >= $index) array_push($c, $Data);
        endforeach;
        return $c;
      }
  }
