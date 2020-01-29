<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <title>Ajuwaya Connect</title>
  </head>
  <body>

    <!-- State html here -->

    <footer ajuwaya-target="limit">
        <!-- Please always remember to update the value of page name to the page name -->
        <input type="hidden" id="PAGE_NAME" value="message" />
        <!-- Page Name tag closed -->

        <input type="hidden" id="BASE_URL" value="<?php echo BASE_URL ?>" />
        <input type="hidden" id="uid" value="<?php echo $this->sessionUid ?>"/>
        <input type="hidden" id="username" value="<?php echo $this->sessionUsername; ?>"/>
        <input type="hidden" id="name" value="<?php echo $this->sessionName; ?>"/>
        <input type="hidden" id="token" value="<?php echo $this->sessionToken; ?>"/>
        <input type="hidden" id="public_username" value="<?php echo $this->public_username; ?>" />
    </footer>
    <script src="<?php echo BASE_URL ?>build/app.bundle.js"></script>
</div>
  </body>
</html>
