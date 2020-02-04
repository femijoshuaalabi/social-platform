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
    <div class="container-fluid">

        <div class="row py-2 pack">
            <!-- COL 1, MESSAGES CONTAINER-->
            <div id="msgColumn" class="col-md-4 col-lg-4">
                <div id="msgHead">
                    <div class="row no-gutters flex-nowrap align-items-center p-2">
                        <img src="../assets/img/james-stewart-man-person-actor-53487.jpeg" alt="profile image"
                            class="rounded-circle">
                        <span class="flex-grow-1 ml-3 font-weight-bold">Messages</span>
                        <a id="msgSearch" class="btn-floating btn-sm"><i class="mdi mdi-magnify mr-3"></i></a>
                        <a class="btn-floating btn-sm"><i class="mdi mdi-chevron-down mr-3"></i></a>
                    </div>
                    <div class="input p-2 d-none">
                        <input class="form-control" placeholder="Search Messages..." type="search" autofocus
                            autocomplete="on">
                    </div>
                </div>

                <hr>
                <div class="container-fluid">
                    <div id="msgBox" class=""></div>
                </div>
            </div>

            <!-- COL 2, CHAT CONTAINER -->
            <div id="chatColumn" class="col-md-8 col-lg-5 border-left hide-sm-and-down">

                <div id="chatHead" class="d-flex align-items-center py-2 pl-2 pr-4">
                    <a class="btn-floating btn-sm btn-light pr-4 d-md-none">
                        <i id="return" class="mdi mdi-arrow-left"></i>
                    </a>
                    <img src="../assets/img/pexels-photo-5.jpeg" alt="user image" class="rounded">
                    <div class="py-1 pl-3 flex-grow-1">
                        <h6 class="my-0 font-weight-bolder">Andrew Malik</h6>
                        <p class="small my-0 text-muted">
                            <small>Last seen: 03:28PM</small>
                        </p>
                    </div>
                    <a class="btn-floating btn-sm btn-light mr-0"><i class="mdi mdi-apps"></i></a>
                    <a class="btn-floating btn-sm btn-light mr-0"><i class="mdi mdi-dots-vertical"></i></a>
                </div>
                <hr>

                <!-- CHAT BOX -->
                <div id="chatBox" class="">
                    <div class="conversation-container pack" id="conversation-container">
                        
                    </div>

                    <div class="inputBox pb-2">
                        <div class="emoji">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" id="smiley" x="3147"
                                y="3209">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M9.153 11.603c.795 0 1.44-.88 1.44-1.962s-.645-1.96-1.44-1.96c-.795 0-1.44.88-1.44 1.96s.645 1.965 1.44 1.965zM5.95 12.965c-.027-.307-.132 5.218 6.062 5.55 6.066-.25 6.066-5.55 6.066-5.55-6.078 1.416-12.13 0-12.13 0zm11.362 1.108s-.67 1.96-5.05 1.96c-3.506 0-5.39-1.165-5.608-1.96 0 0 5.912 1.055 10.658 0zM11.804 1.01C5.61 1.01.978 6.034.978 12.23s4.826 10.76 11.02 10.76S23.02 18.424 23.02 12.23c0-6.197-5.02-11.22-11.216-11.22zM12 21.355c-5.273 0-9.38-3.886-9.38-9.16 0-5.272 3.94-9.547 9.214-9.547a9.548 9.548 0 0 1 9.548 9.548c0 5.272-4.11 9.16-9.382 9.16zm3.108-9.75c.795 0 1.44-.88 1.44-1.963s-.645-1.96-1.44-1.96c-.795 0-1.44.878-1.44 1.96s.645 1.963 1.44 1.963z"
                                    fill="#7d8489" />
                            </svg>
                        </div>
                        <input id="conversationReply" type="text" class="input-msg" name="input"
                            placeholder="Type a message" autocomplete="off"></input>
                        <div class="rightIcon">
                            <i class="mdi mdi-paperclip"></i>
                        </div>
                        <div class="rightIcon">
                            <i class="mdi mdi-camera"></i>
                        </div>
                        <a id="sendButton" class="send btn-floating my-0">
                            <div class="circle">
                                <i class="mdi mdi-send"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- COL 3, OTHERS CONTAINER -->
            <div id="othersColumn" class="col-lg-3 border-left hide-md-and-down align-content-center">
                <div class="container-fluid">
                    <ul class="row flex-column no-gutters justify-content-around font-weight-bold mt-5"
                        style="height: 300px;">
                        <li class=""><span class="mdi mdi-bookmark-multiple mr-3"></span>Bookmark Message</li>
                        <li class=""><span class="mdi mdi-speaker-off mr-3"></span>Mute Notifications</li>
                        <li class=""><span class="mdi mdi-archive mr-3"></span>Archive chat</li>
                        <li class="orange-text"><span class="mdi mdi-close-octagon-outline mr-3"></span>Clear Chat</li>
                        <li class="red-text"><span class="mdi mdi-key-remove mr-3"></span>Report Chat</li>
                        <li class=" red-text"><span class="mdi mdi-delete mr-3"></span>Delete chat</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>



    <!-- Footer begins here -->
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
        <input type="hidden" id="conversationId" value="" />
    </footer>
    
    <script src="<?php echo BASE_URL ?>build/app.bundle.js"></script>
    <script src="<?php echo BASE_URL ?>build/dist/mdb/js/jquery-3.4.1.min.js"></script>
    <script src="<?php echo BASE_URL ?>build/dist/mdb/js/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL ?>build/dist/mdb/js/mdb.min.js"></script>
</div>
  </body>
</html>
