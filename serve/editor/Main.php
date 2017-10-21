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
    <title>Editor | {{appname}}</title>

    <!-- <meta charset="UTF-8" /> -->
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
    <link rel="stylesheet" href="public/css/editor.min.css" defer="defer" />
    <link rel="stylesheet" href="public/css/animate.css" type="text/css" defer="defer" />
    <link rel="stylesheet" href="public/snackbar/snackbar.min.css" type="text/css" />
    <link rel="stylesheet" href="public/snackbar/theme.css" type="text/css" />
  </head>
  <body>
    {{dynamic_modal}}

    <div class="header">
      <button type="button" data-side="right" class="btn"><i class="fa fa-cogs fa-lg"></i></button>

        <button type="button" onclick="window.modal('Version');" class="nice-button" style="z-index: 105; background: #53b1d0; height: auto; margin: 3px 3px 3px 55px; width: 100px; font-size: 12px; line-height: 1; padding: 6px;">
          <?=VERSION?>
        </button>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-1 custom-col live-editing-container">
          {{live_editing}}
        </div>
        <div class="col-11 custom-col">
          @row
            <div class="col-8 custom-col essay-content-container">
              {{essay_content}}
            </div>
            <div class="col-4 custom-col settings-container">
              {{settings}}
            </div>
          @//
        </div>
      </div>
    </div>
    <!-- asset scripts -->
    <script src="public/js/assets/functions.js" defer="defer"></script>
    <script src="public/js/assets/editor.js" defer="defer"></script>
    <script src="public/js/assets/editor-methods.js" defer="defer"></script>
    <script src="public/js/assets/settings.js" defer="defer"></script>
    <script src="public/js/assets/modal.js" defer="defer"></script>
    <script src="public/snackbar/snackbar.min.js" defer="defer"></script>
  </body>
</html>
