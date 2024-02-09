<?php //We need to add a PHP tag as the first thing, even if it's just a blank space. HTML can be place after the PHP close tag on line 3
//This is the first page the user will see when they visit our site.

require(__DIR__ . "/../partials/nav.php");
?>
<h1>Calander</h1>

<div class="container">
  <div class="row">
    <div class="col">January</div>
    <div class="w-100"></div>
  </div>
</div>
<div class="container">
  <div class="row justify-content-start">
    <div class="col-2">
        <div class='row-1/2'>
      Sunday
    </div>
</div>
    <div class="col-2">
      Monday
    </div>
  </div>