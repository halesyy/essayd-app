<!DOCTYPE html>
<html>
  <head>
    <!-- Global Site Tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-107685134-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-107685134-1');
    </script>
    <!-- meta -->
    <title><?= ($_SESSION['id'] == $users->user_id)? "Your Profile": ""; ?> | Essay'd</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- alpha -->
    <script src="public/jquery/jQueryAndUI.min.js" defer="defer"></script>
    <!-- external libs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" defer="defer" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" defer="defer" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato|Open+Sans|Raleway|Roboto|Slabo+27px|Montserrat|Proxima+Nova|Chelsea+Market" rel="stylesheet" defer="defer">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" defer="defer" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://use.fontawesome.com/2880f76714.js" defer="defer"></script>
    <!-- internal assets, stylesheets -->
    <link rel="stylesheet" href="public/css/profile.min.css" type="text/css" />
    <script src="public/js/assets/functions.js" defer="defer"></script>
    <script src="public/js/essays-container.js" defer="defer"></script>
    <script src="public/js/profile.js" defer="defer"></script>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-3" style="padding-left: 0;">
          <div class="left-container">
            <div class="image" style="background-image: url('<?=(!empty($users_meta->picture))?$users_meta->picture:'public/images/none.png';?>');"></div>
            <div class="under">
              <ul>
                <a href="/dashboard"><li>
                  <!-- <button type="button" class="nice-button" style="margin-top: 0;">DASHBOARD</button> -->
                  DASHBOARD
                </li></a>
                <a href=""><li>two</li></a>
                <a href=""><li>three</li></a>
                <a href=""><li>four</li></a>
              </ul>
              <ul class="bottom">
                <li><button type="button" class="nice-button red" style="margin-left: 10px;"
                  data-toggle="tooltip" data-placement="right" title="Change certain parts of your profile, make it pop!"
                >EDIT</button></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-9" style="padding-right: 0; padding-left: 0;">
          <div class="right-container">
            <div class="box" style="margin-right: 15px;">
              <h1 style="float: left;">Your Essays</h1>
              <div style="float: right;">
                <button type="button" class="nice-button" style="margin-top: 5px;" onclick="window.location.href = '/editor';"

                >NEW</button>
              </div>
              <div style="clear: both;"></div>
            </div>

            <div id="essays-preview" class="essays-preview" style="margin-right: 15px;">
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
