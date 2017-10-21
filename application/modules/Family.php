<?php
  class Family {
      /*
      | Class containing all
      */

    // ********************************************************************

      /**/
      public $Mother = [
        'fname' => '',
        'lname' => '',
        'occupation' => '',
        'nationality' => '',
        'firstLanguage' => '',
        'employer' => '',
        'religion' => '',
        'placeOfWorship' => '',
        'homePhone' => '',
        'businessPhone' => '',
        'mobilePhone' => '',
        'address' => '',
        'town' => '',
        'state' => '',
        'postcode' => '',
        'email' => ''
      ];
      public $Father = [
        'fname' => '',
        'lname' => '',
        'occupation' => '',
        'nationality' => '',
        'firstLanguage' => '',
        'employer' => '',
        'religion' => '',
        'placeOfWorship' => '',
        'homePhone' => '',
        'businessPhone' => '',
        'mobilePhone' => '',
        'address' => '',
        'town' => '',
        'state' => '',
        'postcode' => '',
        'email' => ''
      ];
      public $Guardian = [
        'fname' => '',
        'lname' => '',
        'occupation' => '',
        'nationality' => '',
        'firstLanguage' => '',
        'employer' => '',
        'religion' => '',
        'placeOfWorship' => '',
        'homePhone' => '',
        'businessPhone' => '',
        'mobilePhone' => '',
        'address' => '',
        'town' => '',
        'state' => '',
        'postcode' => '',
        'email' => ''
      ];
      public $Conditions = [
        'motherDeceased' => '',
        'fatherDeceased' => '',
        'motherRemarried' => '',
        'fatherRemarried' => '',
        'married' => '',
        'defacto' => '',
        'parentsSeperated' => '',
        'parentsDivorced' => '',
        'single' => '',
        'guardian' => '',
        'stepParent' => '',
        'grandparent' => '',
        'courtOrder' => ''
      ];

      // Housed students in the family.
      public $Students = [];


      // *************************************************************

      public $RepeatTillCancelled = [

      ];
      public $AutomaticPaymentIncreases = [

      ];

      public $PaymentResponsibilities = [

      ];
      public $OtherInformation = [

      ];




      // The variables used for the current term it is.
      public $TermsLeft;
      public $QuarterOfYear;
      public $QuarterOfYearDecimal;

      // The payment vars, information about how the client
      // will pay for student.
      private $dd;
      private $cc;
      private $cl;

      public $MethodOfPaymentDetails = [
        //remember, interval is in $this/$Family->Interval... :)
        //mother => ['through' => centrelink, 'fields' => [all centrelink data]]
        //MAKE SURE!!!!!!!!!!!!!
        //when you go to pay or submit application, you check if the field exists of:
        //toBeDeducted - that is manually overidable by ctrl+k..
        //if overided and not changed, very awkward.
        'test' => [
          'through' => 'centrelink',
          'fields'  => [
            'name' => 'Elon Musk',
            'happiness' => 'Eternal'
          ]
        ]
      ];

      // Static price that goes over the family no matter what.
      public $BuildingLevy = 180;

      // All of the combined student: building levy, tuition, compulsory and subject prices.
      //** Full of unlabelled data.
      public $TotalAnnualPrices = [];
      public $TotalAnnualPrice = 0;
      public $TotalAnnualPriceAfterDiscounts = 0;
      public $TotalDiscountAmount = 0;

      public $DiscountTotals = [
        'family' => [],
        'employee' => [],
        'scholership' => [],
        'promtpayment' => []
      ];
      public $DiscountNameConversions = [
        'family' => 'Family Discount',
        'employee' => 'Employee Discount',
        'scholership' => 'Scholership Discount',
        'promtpayment' => 'Promt Payment Discount'
      ];

      // Combination of the students base tuitions.
      public $StudentTuitions = [];

      // Based fee costs and storing of fee-related information.
      public $Fees = [
        -2 => [
          'tuition' => 1025,
          'compulsory' => 700,
          'subject' => 0
        ],
        -1 => [
          'tuition' => 1025,
          'compulsory' => 700,
          'subject' => 0
        ],
        0 => [
          'tuition' => 1025,
          'compulsory' => 700,
          'subject' => 0
        ],
        1 => [
          'tuition' => 1025,
          'compulsory' => 700,
          'subject' => 0
        ],
        2 => [
          'tuition' => 1025,
          'compulsory' => 700,
          'subject' => 0
        ],
        3 => [
          'tuition' => 1025,
          'compulsory' => 700,
          'subject' => 0
        ],
        4 => [
          'tuition' => 1025,
          'compulsory' => 700,
          'subject' => 0
        ],
        5 => [
          'tuition' => 1025,
          'compulsory' => 700,
          'subject' => 0
        ],
        6 => [
          'tuition' => 1025,
          'compulsory' => 700,
          'subject' => 0
        ],
        7 => [
          'tuition' => 1025,
          'compulsory' => 715,
          'subject' => 305
        ],
        8 => [
          'tuition' => 1025,
          'compulsory' => 715,
          'subject' => 305
        ],
        9 => [
          'tuition' => 1225,
          'compulsory' => 715,
          'subject' => 475
        ],
        11 => [
          'tuition' => 1330,
          'compulsory' => 740,
          'subject' => 680
        ],
        12 => [
          'tuition' => 1330,
          'compulsory' => 740,
          'subject' => 680
        ]
      ];

      // Pre-Kindy information.

      // A big collection of calculated money points/totals to be displayed.
      public $Totals = [];

      // The intervals of payment and the data/conversions behind that.
      public $Interval = '';
      public $IntervalDiscount = false;
      public $IntervalConverter = [
        'annually' => 0.10,
        'termly'   => 0.05,
        'weekly'   => 0.00,
        'fortnightly' => 0.00,
        'fortnightCL' => 0.00,
        'fortnightDD' => 0.00,
        'fortnightCC' => 0.00
      ];

      // The payment method array for family members.
      public $PaymentMethod = [];

      // The percentages of the paying parents.
      public $FamilySplitPercentages = [];

      // Information on students - mainly used
      // for fees.
      public $MetaStudents = [];



    // ********************************************************************


      /*
      | @param String:ObjectReference, Array:RecurrArray
      | Recursively iterates the given array of accesses till
      | arrives at wanted data.
      */
      public function RetrieveFrom($Access, $AccessArray) {
        $Reference = $this->$Access;
          foreach ($AccessArray as $index => $Access)
          $Reference = $Reference[$Access];
        if ($Access == 'Guardian' && empty($Reference)) return '...';
        else return ucwords($Reference);
      } /**/ public function Retrieve($Access, $AccessArray) { return $this->RetrieveFrom($Access, $AccessArray); }
        /**/ public function Get($Access, $AccessArray) { return $this->RetrieveFrom($Access, $AccessArray); }



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
      | @param None
      | Function to sort the students by their year level
      | of schooling - this helps for discounting later on
      | effectively.
      | @NOTE Currently sorts: HIGHEST -> LOWEST.
      */
      public function SortStudentsByYearLevel() {
        $StudentTemp = [];
        foreach ($this->Students as $index => $Student):
          $StudentObject = unserialize($Student);
          $StudentYearLevel = $StudentObject->Get('Personal', ['yearLevel']);
          if (!isset($StudentTemp[$StudentYearLevel])) $StudentTemp[$StudentYearLevel] = [$Student];
          else array_push($StudentTemp[$StudentYearLevel], $Student);
        endforeach;
        krsort($StudentTemp); #/ Function to sort them high->low, if low->high use arsort();

        // Resetting the Students object and re-adding them.
        $this->Students = [];
        foreach ($StudentTemp as $YearLevel => $StudentsArray):
          foreach ($StudentsArray as $StudentString) {
            array_push($this->Students, $StudentString);
          }
        endforeach;
      }



      /*
      | @param None
      | Fees function is the construtor for all financial
      | variables and values. Call when time to re-calculate
      | the families values such as family discounts, etc..
      | @NOTE : If calculations are incorrect, make sure:
      |       = You aren't discounting the building levy.
      |       = Summing correct data together, trace it.
      |       = Formula for displaying total year cost is:
      |       = ($this->TermsLeft * $YearTotal) / 4 + $this->BuildingLevy;
      | @NOTE : Notes for remember dev
      | [o]   : Use the [Discounts] meta array to use to recursively discount the tuition.
      */
      public function Fees() {
        $this->SortStudentsByYearLevel();

        // Constructing-needed variables before loop begins itself.
        $this->QuarterOfYear = (floor(date('z') / (365 / 4)));
        $this->TermsLeft     = (4 - $this->QuarterOfYear);

        $this->QuarterOfYearDecimal = (date('z') / (365 / 4));
        $this->TermsLeftDecimal = (4 - $this->QuarterOfYearDecimal);


        // Iterating students and applying discounts in that format.
        $Count=0; foreach ($this->Students as $index => $StudentString):
          // Initial re-iteration variables.
          $StudentNumberLiteral = $Count + 1; //the literal number of the student. e.g. first iteration means its the first student.
          $StudentObject = unserialize($StudentString);
          $YearLevel = $StudentObject->Get('Personal', ['yearLevel']);


          // Student basic metadata importer.
          $this->MetaStudents[$Count]['student']    = $StudentString;
          $this->MetaStudents[$Count]['base']['tuition']    = $this->Fees[ $this->SanitizeYearLevel($YearLevel) ][ 'tuition' ];
          $this->MetaStudents[$Count]['base']['compulsory'] = $this->Fees[ $this->SanitizeYearLevel($YearLevel) ][ 'compulsory' ];
          $this->MetaStudents[$Count]['base']['subject']    = $this->Fees[ $this->SanitizeYearLevel($YearLevel) ][ 'subject' ];
          $this->MetaStudents[$Count]['tuition']    = $this->Fees[ $this->SanitizeYearLevel($YearLevel) ][ 'tuition' ];
          $this->MetaStudents[$Count]['compulsory'] = $this->Fees[ $this->SanitizeYearLevel($YearLevel) ][ 'compulsory' ];
          $this->MetaStudents[$Count]['subject']    = $this->Fees[ $this->SanitizeYearLevel($YearLevel) ][ 'subject' ];
          $Tuition = &$this->MetaStudents[$Count]['tuition']; #used alot


          // Building the total annual price for all student - before discounts.
          array_push($this->TotalAnnualPrices, $this->MetaStudents[$Count]['base']['tuition']);
          array_push($this->TotalAnnualPrices, $this->MetaStudents[$Count]['base']['compulsory']);
          array_push($this->TotalAnnualPrices, $this->MetaStudents[$Count]['base']['subject']);
          #/ And pushing the tuitions to the StudentTuitions for easy later on calculation of discounts.
          array_push($this->StudentTuitions, $this->MetaStudents[$Count]['base']['tuition']);

          // Family Discount Calculator. - STEP1(build the percentages per person)
          if ($StudentNumberLiteral == 1) { #0%
            $FamilyDiscount = 0.00;
          } else if ($StudentNumberLiteral > 4) { #60%
            $FamilyDiscount = 0.60;
          } else { #=(c-1*20)%(between 2-4)
            $FamilyDiscount = (($StudentNumberLiteral - 1) * 20) / 100;
          }
          $this->MetaStudents[$Count]['discounts']['family'] = $FamilyDiscount;
          // STEP2 of family discount calculator - getting real price of discount.
          // (then removing from actual tuition of child)
          array_push($this->DiscountTotals['family'], ($Tuition * $FamilyDiscount));
          $Tuition -= ($Tuition * $FamilyDiscount);
        $Count++; endforeach;



        // Adding in the prompt payment discount into the discount totals.
        if (isset($this->IntervalConverter[$this->Interval])) $Interval = $this->IntervalConverter[$this->Interval]; else $Interval = 0;
        $this->PromptPaymentDiscount =  $Interval* ((array_sum($this->TotalAnnualPrices)) + $this->BuildingLevy);
        array_push($this->DiscountTotals['promtpayment'], $this->PromptPaymentDiscount);

        // Including discounts for previews of potential prices\.
        $Interval = 0.10;
        $AnnualDiscount = $Interval* ((array_sum($this->TotalAnnualPrices)) + $this->BuildingLevy);
        $Interval = 0.05;
        $TermlyDiscount = $Interval* ((array_sum($this->TotalAnnualPrices)) + $this->BuildingLevy);



        // Calculating discounts total price.
        foreach ($this->DiscountTotals as $DiscountType => $DiscountValues) {
          $this->TotalDiscountAmount += array_sum($DiscountValues);
        }



        // After-loop variables to declare and manipulate.
        $this->TotalAnnualPrice = (array_sum($this->TotalAnnualPrices)) + $this->BuildingLevy;
        $this->TermedAnnualPrice = (($this->TermsLeft* array_sum($this->TotalAnnualPrices)) /4) + $this->BuildingLevy;
        $this->TotalAnnualPriceAfterDiscounts = $this->TermedAnnualPrice - $this->TotalDiscountAmount;
        $this->TermedDiscountAmount = $this->TermsLeft* ($this->TotalDiscountAmount) /4;

        $this->Totals = [
          'TotalDiscountAmount' => ($this->TotalDiscountAmount),
          'TotalAnnualPrice' => ($this->TotalAnnualPrice),
          'FullAnnualPriceLessDiscounts' => ($this->TotalAnnualPrice - $this->TotalDiscountAmount),
          'BuildingLevy' => ($this->BuildingLevy),

          'TotalAnnualFees' => ($this->TermedAnnualPrice), // Total fees accounting for which term we are in.
          'TotalAnnualFeesLessDiscounts' => ($this->TermedAnnualPrice - $this->TermedDiscountAmount), // Total annual fees removing the discounts

          'AnnualPromtPayDiscount' => (($this->TermsLeft* (array_sum($this->StudentTuitions) /4)) * 0.10), // The discount for promt payment annually (10%)
          'DiscountedAnnualFeesLessPromtPay' => ($this->TermedAnnualPrice - $this->TermedDiscountAmount) - (($this->TermsLeft* (array_sum($this->StudentTuitions) /4)) * 0.10), // Total after discount of prompt payment

          'FeesPerTermLessDiscounts' => (($this->TotalAnnualPrice - $this->TotalDiscountAmount) /4),
          'TermlyPromtPayDiscount' =>  ((array_sum($this->StudentTuitions) /4) * 0.05),
          'DiscountedTermlyFeesLessPromtPay' => (($this->TotalAnnualPrice - $this->TotalDiscountAmount) /4) - ((array_sum($this->StudentTuitions) /4) * 0.05),

          'WholeWeeklyPaymentAfterDiscounts' => ($this->TermedAnnualPrice - $this->TermedDiscountAmount),
          'WeeklyPayments' => ($this->TermedAnnualPrice - $this->TermedDiscountAmount) / (51 - date('W') - 2),
          'FortnightlyPayments' => 2* (($this->TermedAnnualPrice - $this->TermedDiscountAmount) / (51 - date('W') - 2)),

          'LessDaysNotAttendedThisYear' => $this->QuarterOfYearDecimal* ($this->TotalAnnualPrice - $this->TotalDiscountAmount) /4,
                                  //terms left in decimal form
                                  //*
                                  //annual price for doing a year of school for all students
                                  //-
                                  //total discount amount
                                  //div4
          'TotalAfterLessDays' => $this->TermsLeftDecimal* ($this->TotalAnnualPrice - $this->TotalDiscountAmount) /4,

          // fuck me this is getting hard and its getting super fucking hard.

          // for the year of payment, you want:
          // the payment amount for your students given to the people RIGHT NOW
          //
          'TotalCostAfterAnnualPromptPayment' => $this->TermsLeftDecimal* ($this->TotalAnnualPrice - $AnnualDiscount) /4,
          'TotalCostAfterTermlyPromptPayment' => (($this->TotalAnnualPrice - $TermlyDiscount) /4) - ((array_sum($this->StudentTuitions) /4) * 0.05),
        ];

        $this->ImportantTotals = [
          'TotalAfterLessDays' => $this->Totals['TotalAfterLessDays'],
          'DiscountedTermlyFeesLessPromtPay' => $this->Totals['DiscountedTermlyFeesLessPromtPay'],
          'FortnightlyPayments' => $this->Totals['FortnightlyPayments']
        ];

        // echo "<pre>", print_r($this->Totals) ,"</pre>";
      }




      //** Prints out the FamilyFees information for the client
      //** before moving forward in their transaction.
      public function FinancialStatement() {
        $Sunrise = new Sunrise;
        $FeeDisplay = $Sunrise->Mini('form-areas/custom/FamilyFees', '..', []);
        echo ($FeeDisplay);
      }



      /*Returns an array of the students prices on head.*/
      public function ArrayStudentPrices() {
        $Prices = [];
        foreach ($this->Students as $index => $Student) { $Student = unserialize($Student);
          array_push($Prices, $Student->PersonalPrice(false));
        }
        return $Prices;
      }



      /*Setting function to change the internal interval of payment.*/
      public function SetInterval($Interval) {
        $this->Interval = $Interval;
        // $this->IntervalDiscount = $this->IntervalConverter[$Interval];
      }
      public function SetMethod($Method) {
        $this->PaymentMethod = $Method;
      }














      /*FUNCTIONS I NEED TO GET AROUND TO RE-WRITING!*/
      /*FUNCTIONS I NEED TO GET AROUND TO RE-WRITING!*/
      /*FUNCTIONS I NEED TO GET AROUND TO RE-WRITING!*/
      /*FUNCTIONS I NEED TO GET AROUND TO RE-WRITING!*/
      /*FUNCTIONS I NEED TO GET AROUND TO RE-WRITING!*/
      /*FUNCTIONS I NEED TO GET AROUND TO RE-WRITING!*/
      /*FUNCTIONS I NEED TO GET AROUND TO RE-WRITING!*/
      /*FUNCTIONS I NEED TO GET AROUND TO RE-WRITING!*/
      /*FUNCTIONS I NEED TO GET AROUND TO RE-WRITING!*/
      /*FUNCTIONS I NEED TO GET AROUND TO RE-WRITING!*/
      /*RE-WRITING ENTITLES MOVING ALL HTML CODE INTO
        SEPERATE SUNRISE MINI SNIPPETS OF CODE.*/



      /*
      | @param None
      | "Re-boards" the Family object with students
      | scraped from SESSION.
      | This entitles removing all Students currently
      | stored and re-introducing them.
      */
      public function ReboardStudents() {
        $this->Students = [];
        foreach ($_SESSION['form']['students'] as $index => $Student) {
          array_push( $this->Students, $Student );
        }
      }

      //...
      public function PreviewBaseFeeCosts() {
        $StudentTemp = new Student;
        $StudentTemp->PreviewBetaFeeDisplayCols();
        foreach ($this->Students as $index => $Student): $Student = unserialize($Student);
          $Student->PreviewBetaFeePrice();
        endforeach;
      }



      // My beta function for Rum to experiment and hopefully
      // like before I push out it as the function to use.
      //*USES INVERSE PHP SCRIPT EXECUTION
      public function PreviewBeta() {
        ?>
          <div class="row family-preview">

            <?php if (!empty($this->Get('Mother', ['fname'])) && !empty($this->Get('Mother', ['lname']))): ?>
              <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 no-col-padding">
                <strong>Mother</strong>
              </div>
              <div class="col-lg-9 col-md-9 col-sm-6 col-xs-6">
                <?=($this->Get('Mother', ['fname']))?> <?=($this->Get('Mother', ['lname']))?>
              </div>
            <?php endif; ?>

            <?php if (!empty($this->Get('Father', ['fname'])) && !empty($this->Get('Father', ['lname']))): ?>
              <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 no-col-padding">
                <strong>Father</strong>
              </div>
              <div class="col-lg-9 col-md-9 col-sm-6 col-xs-6">
                <?=($this->Get('Father', ['fname']))?> <?=($this->Get('Father', ['lname']))?>
              </div>
            <?php endif; ?>

            <?php if (!empty($this->Get('Guardian', ['fname'])) && !empty($this->Get('Guardian', ['lname']))): ?>
              <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 no-col-padding">
                <strong>Guardian</strong>
              </div>
              <div class="col-lg-9 col-md-9 col-sm-6 col-xs-6">
                <?=($this->Get('Guardian', ['fname']))?> <?=($this->Get('Guardian', ['lname']))?>
              </div>
            <?php endif; ?>

          </div>
        <?php
      }



      public function SanitizeYearLevel($YearLevel) {
        if ($YearLevel == 'Pre-Kindy') return -2;
        if ($YearLevel == 'Kindergarten') return -1;

        return $YearLevel;
      }



      public function TotalFamilyPayPercentage() {
        $ResponsibleFamilyMembersPercentages = [];
        foreach ($this->PaymentResponsibilities as $FamilyMember => $IsResponsible):
          if ($IsResponsible == "true" && isset($this->FamilySplitPercentages[$FamilyMember])) array_push($ResponsibleFamilyMembersPercentages, $this->FamilySplitPercentages[$FamilyMember]);
        endforeach;
        // echo "<pre>", print_r($ResponsibleFamilyMembersPercentages) ,"</pre>";
        // $Total = round($Total, 0);
        $Total = array_sum($ResponsibleFamilyMembersPercentages);
        return $Total;
      }





  }
