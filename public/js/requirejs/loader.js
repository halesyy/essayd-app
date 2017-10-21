/*
| This is your loader file, you require all JS here and manage everything from here.
| NOTE Require() function is based from the JS folder.
|
| You want to load all your plugins / libs in the "/public/js/requirejs/config.js"
| file, so you can require files in this file (the loader).
*/

require(['jquery'], function($){
  $(document).ready(function(){
    $('body').html( 'Welcome to the JEK Framework!' );
  });
});
