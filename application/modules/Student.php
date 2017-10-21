<?php
  class Student {
      /*
      | Class containing all data for a student. Instead of creating
      | large arrays to contain the student's data that can be serialized
      | and deserialized, this is a one-way method of creating objects
      | that are more flexible then arrays and can contain manipulation
      | methods.
      */

    // ********************************************************************

      /*Stuff the user refers to as their name, phone, email*/
      public $Personal = [
        'fname' => '',
        'lname' => '',
        'mname' => '',
        'pname' => '',
        'yearToEnrol' => '',
        'yearLevel' => '',
        'gender' => '',
        'dateOfBirth' => '',
        'nationality' => '',
        'isStudent' => [
          'aboriginal' => '',
          'torresStraitIs' => ''
        ],
        'languageAtHome' => '',
        'address' => '',
        'town' => '',
        'state' => '',
        'postCode' => '',
        'livesWith' => '',
        'religion' => '',
        'prekindy' => [
          'week1' => [
            'monday' => '',
            'tuesday' => '',
            'wednesday' => '',
            'thursday' => '',
            'friday' => ''
          ],
          'week2' => [
            'monday' => '',
            'tuesday' => '',
            'wednesday' => '',
            'thursday' => '',
            'friday' => ''
          ]
        ]
      ];
      public $Education = [
        'hasBeenExpelled' => '',
        'hasBeenSuspended' => '',
        'hasBeenRefused' => '',
        'details' => '',
        'previousSchool' => ''
      ];
      public $Behaviour = [
        'hasDisciplineIssues' => '',
        'hasBeenArrested' => '',
        'usedAlcoholOrTobacco' => '',
        'usedIllegalDrugs' => '',
        'explain' => ''
      ];
      public $Medical = [
        'DoctorHealthFund' => [
          'private' => [
            'ambulance' => '',
            'healthFund' => '',
            'companyAndMemberId' => ''
          ],
          'medicareNumber' => '',
          'medicareExpiryDate' => '',
          'medicarePositionOnCard' => ''
        ],
        'MedicalInformation' => [
          'doctorName' => '',
          'doctorPhone' => '',
          'isImmunised' => '',
          'wears' => [
            'glasses' => '',
            'contacts' => ''
          ]
        ],
        'MedicalConditions' => [
          'has' => [
            'asthma' => '',
            'adhd' => '',
            'diabetes' => '',
            'epilepsey' => '',
            'autism' => '',
            'allergies' => '',
            'explain' => ''
          ],
          'earlyIntervention' => ''
        ]
      ];
      public $Emergency = [
        0 => [
          'name' => '',
          'phone' => '',
          'relationship' => ''
        ],
        1 => [
          'name' => '',
          'phone' => '',
          'relationship' => ''
        ]
      ];

      /*parent data and what their parents are*/
      public $HasFamily = false;
      public $FamilyID  = false;

      /*fee price per year level.*/
      public $Fees = [
        'enrolment-prices' => [
          0 => 1725,
          1 => 1725,
          2 => 1725,
          3 => 1725,
          4 => 1725,
          5 => 1725,
          6 => 1725,
          7 => 2045,
          8 => 2045,
          9 => 2415,
          10 => 2415,
          11 => 2750,
          12 => 2750
        ]
      ];

    // ********************************************************************


      /*
      | @param String:ObjectReference, Array:RecurrArray
      | Recursively iterates the given array of accesses till
      | arrives at wanted data.
      */
      public function RetrieveFrom($Access, $AccessArray, $AlwaysReturn = true) {
        $Reference = $this->$Access;
          foreach ($AccessArray as $index => $Access)
          if (isset($Reference[$Access])) $Reference = $Reference[$Access];
          else { $Reference = false; break; }
        if (empty($Reference) && $AlwaysReturn === true) return '';
        else if (empty($Reference) && $AlwaysReturn === false) return '';
        else {
          if ($AccessArray[0] == 'yearLevel') {
            if ($Reference == -1) return 'Kindergarten';
            else if ($Reference == -2) return 'Pre-Kindy';
            else return $Reference;
          }
          if (in_array($AccessArray[0], ['fname', 'lname', 'mname', 'pname'])) {
            return ucwords($Reference);
          } else return $Reference;
        }
      } /**/ public function Retrieve($Access, $AccessArray, $AlwaysReturn = true) { return $this->RetrieveFrom($Access, $AccessArray, $AlwaysReturn); }
        /**/ public function Get($Access, $AccessArray, $AlwaysReturn = true) { return $this->RetrieveFrom($Access, $AccessArray, $AlwaysReturn); }



      /*
      | @param String:ObjectReference, Array:RecurrObjectLoaderArray
      | Inserts into segment of the Student object specifically.
      */
      public function Insert($Into, $InsertArray) {
        foreach ($InsertArray as $Access => $Data) {
          if (isset($this->$Into)) {
            $Reference = &$this->$Into;
            $Reference[$Access] = $Data;
          } else continue;
        }
      }

      /*
      | @param Multi:Controller
      | Will set the internal variable of HasParent
      | accordingly. This is an internal reference to
      | tell if a Student Object is given a Parent/Family
      | or not.
      */
      public function SetFamily($To = 'inverse') {
        if ($To === 'inverse') {
          $this->HasFamily = !$this->HasFamily;
        } else $this->HasFamily = $To;
      }
      public function HasFamily() {
        return $this->HasFamily;
      }

      /*
      | @param None
      | Returns the basic preview of a student with really
      | basic data representing the class as itself.
      | *USES INVERSE PHP SCRIPT EXECUTION.
      */
      public function Preview() {
        ?>
          <div class="student-preview">
            <div class="name">
              <?=($this->Get('Personal', ['fname']))?>
              <?=($this->Get('Personal', ['mname']) === false || $this->Get('Personal', ['mname']) === '')? '': $this->Get('Personal', ['mname']);?>
              <?=($this->Get('Personal', ['lname']))?>
              <?=("({$this->Get('Personal', ['pname'])})")?>
            </div>
            <hr />
            <div class="row details">
              <div class="col-lg-2">
                <strong>Age</strong> <br/>
              </div>
              <div class="col-lg-2">
                <?=($this->Age())?>
              </div>
              <div class="col-lg-2">
                <strong>Year enrolment</strong> <br/>
              </div>
              <div class="col-lg-2">
                <?=($this->Get('Personal', ['yearToEnrol']))?>
              </div>
              <div class="col-lg-2">
                <strong>Year level</strong> <br/>
              </div>
              <div class="col-lg-2">
                <?=($this->Get('Personal', ['yearLevel']))?>
              </div>
              <div class="clear"></div>
            </div>
          </div>
        <?php
      }



      /*
      | @param None
      | Different spacing to the other Preview function,
      | gives a plainer output for the printer to handle.
      | *USES INVERSE PHP SCRIPT EXECUTION.
      */
      public function PrintPreview() {
        ?>
          <div class="row">

          </div>
        <?php
      }
      //**USES INVERSE PHP SCRIPT EXECUTION.
      public function PreviewBetaFeePrice() {
        ?>
          <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-6">
              <?=($this->Get('Personal', ['fname']))?>
              <?=($this->Get('Personal', ['lname']))?>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs center">
              <?=($this->Age())?>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs center">
              <?=($this->Get('Personal', ['yearLevel']))?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 center">
              <?=($this->PersonalPrice())?>
            </div>
          </div>
        <?php
      }
      //*USES INVERSE PHP SCRIPT EXECUTION.
      public function PreviewBeta() {
        ?>
          <div class="row">
            <div class="col-lg-5">
              <?=($this->Get('Personal', ['fname']))?>
              <?=($this->Get('Personal', ['mname']) === false || $this->Get('Personal', ['mname']) === '')? '': $this->Get('Personal', ['mname']);?>
              <?=($this->Get('Personal', ['lname']))?>
              <?=("({$this->Get('Personal', ['pname'])})")?>
            </div>
            <div class="col-lg-2 center">
              <?=($this->Age())?>
            </div>
            <div class="col-lg-2 center">
              <?=($this->Get('Personal', ['yearToEnrol']))?>
            </div>
            <div class="col-lg-3 center">
              <?=($this->Get('Personal', ['yearLevel']))?>
            </div>
          </div>
        <?php
      }
      //*USES INVERSE PHP SCRIPT EXECUTION.
      public function PreviewBetaDisplayCols() {
        ?>
          <div class="col-lg-5">
            <strong>Name</strong>
          </div>
          <div class="col-lg-2 center">
            <strong>Age</strong>
          </div>
          <div class="col-lg-2 center">
            <strong>Year Enrolment</strong>
          </div>
          <div class="col-lg-3 center">
            <strong>Year Level</strong>
          </div>
        <?php
      }
      public function PreviewBetaFeeDisplayCols() {
        ?>
          <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-6">
              <strong>Name</strong>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs center">
              <strong>Age</strong>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs center">
              <strong>Year Level</strong>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 center">
              <strong>Student Price</strong>
            </div>
          </div>
        <?php
      }

      /*
      | @param None
      | Uses dateOfBirth (stored in Personal[]) to calculate
      | the Students age currently.
      */
      public function Age() {
        $Date = new DateTime($this->Get('Personal', ['dateOfBirth']));
        $Now  = new DateTime();
        $Interval = $Now->diff($Date);
        #returning the Interval's year difference.
        return $Interval->y;
      }

      /*
      | @param String:Reference, Array:AccessParh,
      | Will create one line of output to the
      | screen for printing.
      */
      public function PersonalPrice($DollarSign = true) {
        if ($DollarSign === false) {
          return $this->Fees['enrolment-prices'][
            $this->Get('Personal', ['yearLevel'])
          ];
        } else {
          return '$'.number_format($this->Fees['enrolment-prices'][
            $this->Get('Personal', ['yearLevel'])
          ]);
        }
      } public function Price() { return $this->PersonalPrice(); }


  }
