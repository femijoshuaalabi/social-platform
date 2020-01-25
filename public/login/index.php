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
    <div class="background-fixer"></div>
        <div style="position: fixed; left: 0; top: 0; height: 60px; width: 100vw; background: #333; opacity: 0.4;"></div>


        <div class="" style="padding-top: 20px;">
   <section class="">
      <div class="mask">
        <div class="container h-100 d-flex justify-content-center align-items-center">
          <div class="row flex-center pt-5 mt-3">
            <div class="col-md-12" style="padding: 5px;">
              <div class="flex-box">
                  <div class="row">
                      <div class="col-md-6 screen-padding">
                        <div class="welcome-box" style="">
                            <div class="col-md-12">
                              <img src="assets/logo/logo.svg" style="height:100px; width: auto;">
                            </div>
                            <div class="col-md-12 white-text">
                              <h2 class="h2">Welcome</h2>
                              <p>Connect with fellow youths and enterpreneurs to create things that matter.</p>
                            </div>
                            <div class="col-md-12 white-text" style="margin-top: 30%">
                              <h2 class="h2">Not a Member?</h2>
                              <p>You can register to join the fun train</p>
                              <a href="<?php echo BASE_URL ?>register" class="float-right btn btn-white" style="margin-top: 20px;box-shadow: 0 5px 20px -3px rgb(25, 107, 105);color:rgb(25, 107, 105); font-weight: 600; ">Register</a>
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6 screen-padding">
                        <div class="login-box">
                            <div class="col-md-12" style="margin-top: 20%;">
                              <h1 class="h1">Login!</h1>
                              <p>Connect with fellow youths and enterpreneurs to create things that matter.</p>
                            </div>

                            <div class="col-md-12" style="margin-top: 20%;">
                               <div class="md-form md-outline">
                                <input type="text" id="username" class="form-control">
                                <label for="username">E-mail</label>
                              </div>

                              <div class="md-form md-outline">
                                <input type="password" id="password" class="form-control">
                                <label for="password">Password</label>
                              </div>
                               <div class="red-text" id="loginError"></div>
                            </div>

                            <div class="col-md-12" style="margin-top: 10%;">
                              <div class="row">
                                <div class="col-6">
                                  <a>Forget Password?</a>
                                </div>
                                <div class="col-6">
                                  <button class="btn btn-default pull-right" id="login">Login</button>
                                </div>
                              </div>
                            </div>

                        </div>
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
    <div id="root"></div>
    <?php include "templates/global.js.php"; ?>
    <script src="<?php echo BASE_URL ?>build/app.bundle.js"></script>
</div>
  </body>
</html>
