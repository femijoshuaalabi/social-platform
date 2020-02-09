<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <title>Ajuwaya Connect</title>
        <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css"> -->
    <link rel="stylesheet" href="<?php echo BASE_URL ?>build/plugins/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>build/dist/mdb/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>build/dist/mdb/css/mdb.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>public/home/newsfeed.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>public/nav_and_footer/nav_footer.css">
  </head>
  <body>
    <!-- <button><a href="<?php echo BASE_URL ?>message">Go to Messages</a></button>
    <div class="container-fluid" id="friendSuggestion" style="margin-top: 30px">  
    </div> -->

    <!-- State html here -->
     <?php 
include_once("public/nav_and_footer/nav.php");
?>

    <div class="container-fluid py-4">
        <div class="row">
            <!-- LEFT NAVIGATION AREA -->
            <div class="leftNav col-md-3 col-lg-3 hide-sm-and-down">
                <ul class="py-3">
                    <span>Personal</span>
                    <hr>
                    <li><span class="mdi mdi-notebook-multiple"></span>Feed</li>
                    <li><span class="mdi mdi-calendar-month-outline"></span>Events</li>
                    <li><span class="mdi mdi-account-group-outline"></span>Groups</li>
                    <li><span class="mdi mdi-close-octagon-outline"></span>Channels</li>
                </ul>
                <ul class="py-3">
                    <span>Job Listings</span>
                    <hr>
                    <li><span class="mdi mdi-star-outline"></span>Graphics Designer</li>
                    <li><span class="mdi mdi-star-outline"></span>Media Specialist</li>
                    <li><span class="mdi mdi-star-outline"></span>Acountant</li>
                    <li><span class="mdi mdi-star-outline"></span>Sales Administrator</li>
                    <hr>
                    <div class="text-center mr-4"><span class="mdi mdi-menu-down">view more</span></div>
                </ul>
                <ul class="py-3">
                    <span>Trending Topics</span>
                    <hr>
                    <li><span class="mdi mdi-star-outline"></span>Lorem Ipsum</li>
                    <li><span class="mdi mdi-star-outline"></span>Lorem Ipsum</li>
                    <li><span class="mdi mdi-star-outline"></span>Lorem Ipsum</li>
                    <li><span class="mdi mdi-star-outline"></span>Lorem Ipsum</li>
                    <hr>
                    <div class="text-center mr-4"><span class="mdi mdi-menu-down">view more</span></div>
                </ul>
                <div class="text-center">
                    <a href="">About</a>
                    <a href="">Privacy-policy</a>
                    <a href="">Advertising</a>
                    <a href="">Terms & Conditions</a>
                </div>
            </div>
            <!-- LEFT NAVIGATION AREA -->


            <!-- MAIN NEWS FEED AREA -->
            <div class="col-sm-8 col-md-6">
                <!-- NEW STATUS UPDATE -->
                <div id="post" class="container-fluid p-2">
                    <div class="d-flex flex-wrap align-items-center">
                        <img src="public/home/assets/img/james-stewart-man-person-actor-53487.jpeg" alt="profile"
                            class="rounded-circle mr-3">
                        <span>What would you like to share?</span>
                        <div name="statusPost" id="statusPost" contenteditable="true"></div>
                    </div>
                    <div class="p-2 d-flex align-items-center justify-content-between">
                        <a><span class="mdi mdi-image"></span> Upload Photo</a>
                        <a class="post"><span class="mdi mdi-upload"></span>Post</a>
                    </div>
                </div>
                <!-- SOME CATEGORIES(I DON'T KNOW THE IMPORTANCE OF THIS YET) -->
                <div id="cat" class="container-fluid p-3">
                    <div class="">
                        <span>Topics for you</span><span class="mdi mdi-close float-right"></span>
                    </div>
                    <hr class="mb-0" />
                    <div class="slots p-2 d-flex">

                    </div>
                    <div class="text-center">
                        <a><span class="mdi mdi-menu-down"></span>Discover more</a>
                    </div>
                </div>

                <!-- FRIENDS POSTS IN NEWS FEED -->
                <div id="friendsPosts" class="container-fluid py-3">
                    <div class="row no-gutters flex-nowrap align-items-center p-1">
                        <div>
                            <img src="public/home/assets/img/pexels-photo-3.jpeg" alt="image" class="friendsImage rounded mr-1">
                        </div>
                        <div class="py-1 pl-2 flex-grow-1" style="max-width:85%;">
                            <div>
                                <h6 class="mb-1 font-weight-bolder text-truncate">Rachael Mark
                                </h6>
                            </div>
                            <p id="friendsStatus" class="small my-0 text-muted text-truncate pr-2">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis quisquam molestias quod
                                voluptas minus aperiam fuga modi est ea adipisci. Vitae aliquam voluptatem nesciunt
                                ipsum maxime sunt ullam ad nam?
                            </p>
                            <p class="small my-0 text-truncate" style="color: rgb(99, 127, 143);">
                                <span class="float-right pt-1">April
                                    17, 2018 at 4:20AM</span>
                            </p>
                        </div>
                    </div>
                    <!-- POST CONTENT -->
                    <div id="friendsPostContent">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae unde laborum magnam ipsam,
                            illum
                            debitis, alias laudantium mollitia quas amet ipsum excepturi consectetur tempore est,
                            sapiente
                            placeat? Minus, optio possimus? Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Officia
                            similique ullam aut, fugiat nemo natus ea quas exercitationem dolorum sequi tempora quia
                            molestiae incidunt. Possimus error nostrum corporis rem deleniti.</p>
                        <img src="public/home/assets/14a.jpg" alt="post image">
                    </div>
                    <!-- ALL RESPONSES TO EACH POST -->
                    <div id="responses">
                        <p class="p-2 mb-0"><span class="likes mdi mdi-thumb-up" style="cursor: pointer;"> 100+</span>
                        </p>
                        <div class="container-fluid p-2">
                            <div class="d-flex flex-nowrap align-items-center justify-content-between">
                                <img src="public/home/assets/img/james-stewart-man-person-actor-53487.jpeg" alt="profile"
                                    class="rounded-circle mr-3">
                                <div id="postComment" class="" name="statusPost" contenteditable="true">Post a comment
                                </div>
                                <a class="send ml-2"><span class="mdi mdi-send"></span></a>
                            </div>
                            <!-- COMMENTS -->
                            <div id="comments">
                                <div id="comment" class="ml-4 p-1 mt-2">
                                    <div class="row no-gutters flex-nowrap align-items-center">
                                        <div>
                                            <img src="public/home/assets/img/pexels-photo-3.jpeg" alt="image" class="rounded mr-1">
                                        </div>
                                        <div class="py-1 pl-2 flex-grow-1" style="max-width:85%;">
                                            <h6 class="mb-1 font-weight-bolder">Rachael Mark
                                            </h6>
                                        </div>
                                    </div>
                                    <div id="commentContent">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi eligendi
                                        tenetur, nihil vitae sapiente odio quae voluptatem repudiandae minima eveniet?
                                        Praesentium nostrum, quibusdam numquam magni ipsam tenetur esse consectetur hic.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- MAIN NEWS FEED AREA -->


            <!-- RIGHT NAVIGATION AREA -->
            <div class="col-sm-4 col-md-3 rightNav0 hide-xs">
                <div class="rightNav container-fluid p-0 mb-3">
                    <div class="text-center mr-4 py-1"><span>People you may know</span></div>
                    <hr class="my-1" />
                    <div id="addNewFriends" class="pt-2">

                    </div>
                    <hr class="my-1" />
                    <div class="more text-center mr-4 pb-2"><span class="mdi mdi-menu-down">view more</span></div>
                </div>
                <div class="rightNav container-fluid p-0">
                    <div class="text-center mr-4 py-1"><span>Vendors</span></div>
                    <hr class="my-1" />
                    <div id="vendors" class="pt-2" style="height: 300px;overflow-y: auto;">

                    </div>
                    <hr class="my-1" />
                    <div class="more text-center mr-4 pb-2"><span class="mdi mdi-menu-down">view more</span></div>
                </div>

            </div>
            <!-- RIGHT NAVIGATION AREA -->

        </div>
    </div>


    <!-- Footer begins here -->
         <?php 
include_once("public/nav_and_footer/footer.php");
?>
    <div ajuwaya-target="limit">
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
    </div>
    
    <script src="<?php echo BASE_URL ?>build/app.bundle.js"></script>
    <script src="<?php echo BASE_URL ?>build/dist/mdb/js/jquery-3.4.1.min.js"></script>
    <script src="<?php echo BASE_URL ?>build/dist/mdb/js/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL ?>build/dist/mdb/js/mdb.min.js"></script>
    <script src="<?php echo BASE_URL ?>public/home/dummyNewsfeed.js"></script>
  </body>
</html>
