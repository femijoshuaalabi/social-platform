<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <title>Ajuwaya Connect</title>
    <?php include "templates/global.css.php"; ?>
  </head>
  <body>
  <div class="container-scroller">
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <?php include "templates/introductionPage/header.php"; ?>

    <div id="RegistrationForm" style="">
      <div class="RegistrationStep" id="stepOne"></div>
      <div class="RegistrationStep" id="stepTwo"></div>
      <div class="RegistrationStep" id="stepThree"></div>
      <div class="RegistrationStep" id="stepFour"></div>
     <input type="hidden" id="stepConfirm" value="0">
    </div>

    <footer ajuwaya-target="limit">
        <!-- Please always remember to update the value of page name to the page name -->
        <input type="hidden" id="PAGE_NAME" value="register" />
        <!-- Page Name tag closed -->
        <input type="hidden" id="BASE_URL" value="<?php echo BASE_URL ?>" />
    </footer>
    
    <?php include "templates/global.js.php"; ?>
    <script src="<?php echo BASE_URL ?>build/app.bundle.js"></script>
</div>
  </body>
</html>
