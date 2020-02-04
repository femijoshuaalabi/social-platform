<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <title>Ajuwaya Connect</title>
        <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>build/dist/mdb/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>build/dist/mdb/css/mdb.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>public/message/main.css">
  </head>
  <body>

    <!-- State html here -->
    <button><a href="<?php echo BASE_URL ?>message">Go to Messages</a></button>
    <div class="container-fluid" id="friendSuggestion" style="margin-top: 30px">
        
    </div>

    <!-- Footer begins here -->
    <footer ajuwaya-target="limit">
        <!-- Please always remember to update the value of page name to the page name -->
        <input type="hidden" id="PAGE_NAME" value="home" />
        <!-- Page Name tag closed -->

        <input type="hidden" id="BASE_URL" value="<?php echo BASE_URL ?>" />
        <input type="hidden" id="uid" value="<?php echo $this->sessionUid ?>"/>
        <input type="hidden" id="username" value="<?php echo $this->sessionUsername; ?>"/>
        <input type="hidden" id="name" value="<?php echo $this->sessionName; ?>"/>
        <input type="hidden" id="token" value="<?php echo $this->sessionToken; ?>"/>
        <input type="hidden" id="public_username" value="<?php echo $this->public_username; ?>" />
        <input type="hidden" id="conversationId" value="" />
    </footer>
    
    <script src="<?php echo BASE_URL ?>build/app.bundle.js"></script>
    <script src="<?php echo BASE_URL ?>build/dist/mdb/js/jquery-3.4.1.min.js"></script>
    <script src="<?php echo BASE_URL ?>build/dist/mdb/js/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL ?>build/dist/mdb/js/mdb.min.js"></script>
    <!-- <script src="<?php echo BASE_URL ?>src/scripts/main.js"></script> -->
</div>
  </body>
</html>
