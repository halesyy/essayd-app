/*
|----------------------------------------------------------------------------------
| REQUIRE JS CONFIGURATION FILE.
| NOTE This is called each time you load a page.
|----------------------------------------------------------------------------------
| This is your Configuration file for Require JS's loading scheme,
| we load this file in your "html_head.php" file located in "/sys/build/html_head.php"
| by running "$head->LoadRequireJSConfig()".
|----------------------------------------------------------------------------------
*/

requirejs.config({
  baseUrl: "/public/js",
  paths: {
    jquery: ['https://code.jquery.com/jquery-3.1.1.min', 'jquery/jquery.min']
  }
});
