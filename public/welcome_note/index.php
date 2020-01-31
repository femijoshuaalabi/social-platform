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
    <div class="" style="padding: 20px;">
    <section class="">
        <div class="mask">
            <div class="container h-100 d-flex justify-content-center align-items-center">
            <div class="row flex-center pt-5 mt-3">
                <div class="col-md-12">
                <div class="card flex-box-sm h-100 d-flex justify-content-center align-items-center">
                    <div class="width-justification">
                        <div class="col-md-12" style="margin-top: 50px;">
                        <h2 class="h2">Account Created Successfully</h2>
                        <p><strong><?php echo $_SESSION['name'] ?></strong>, Welcome to Corpersmeet Inc. We are really glad to have you on our platform. kindly update your details to get the most out of your experience on this platform. We hope you have a swell time.</p>
                        <br>
                        <button class="btn btn-default" id="continue-to-homepage" style="margin: 50px 0px;">Continue</button>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </section>
    </div>

    <div class="container-fluid" style="background: rgba(25, 107, 105, 0.05);
    box-shadow: 0px 0px 99px rgba(25, 107, 105, 0.06); text-align: center; height: 50px; padding: 15px;">
    © 2019 Copyright: Corpersmeet Inc. All rights reserved.
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
