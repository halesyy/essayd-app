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
    <title>Dashboard | Essay'd</title>
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
    <link rel="stylesheet" href="public/css/dashboard.min.css" type="text/css" />
    <script src="public/js/assets/functions.js" defer></script>
    <script src="public/js/essays-container.js" defer="defer"></script>
    <script src="public/js/dashboard.js" defer></script>
  </head>
</head>
  <body>
    <div class="container-fluid dashboard-container">

      <div class="row align-items-start">
        <div class="col-1"></div>
        <div class="col-10 custom-col">
          <div class="header">
            <h1>Your Essay'd Dashboard</h1>
          </div>
        </div>
        <div class="col-1"></div>
      </div>

      <div class="row align-items-start">
        <div class="col-1"></div>
        <div class="col-lg-2 col-sm-3 col-xs-3 custom-col" id="profile-preview">
          <div class="picture" style="background-image: url('<?=(!empty($users_meta->picture))?$users_meta->picture:'public/images/none.png';?>')"></div>

          <div class="box">
            <div class="section">
              <?=$users->email?>
            </div>
            <div class="section last">
              <button type="button" style="margin-top: 0;" onclick="window.location.href='/editor';" class="nice-button">NEW ESSAY</button>
            </div>
          </div>
        </div>
        <div id="essays-preview" class="col-lg-8 col-sm-7 col-xs-7 custom-col essays-preview">
        </div>
        <div class="col-1"></div>
      </div>

    </div>
  </body>
</html>
