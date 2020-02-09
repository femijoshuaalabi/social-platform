    <nav class="d-flex flex-nowrap align-items-center justify-content-around">
        <a class="logo hide-xs px-4" href="#">Plurg </a>

        <div class="search d-flex pl-2 align-items-center"><input type="search"
                placeholder="Search people, events, topics..." class="flex-grow-1">
            <span class="mdi mdi-magnify px-2"></span>
        </div>
        <div class="mobileMenu d-flex justify-content-around align-items-center d-md-none mx-2" style="width: 100px;">
            <a class=""><span class="mdi mdi-message-outline"></span></a>
            <a class=""><span class="mdi mdi-bell-alert"></span></a>
        </div>
        <div class="menu d-flex justify-content-around align-items-center hide-sm-and-down mx-2" style="width: 400px;">
            <a><span class="mdi mdi-home"></span><span>Home</span></a>
            <a><span class="mdi mdi-message-outline"></span><span>Messages</span></a>
            <a><span class="mdi mdi-bell-alert"></span><span>Notifications</span></a>
            <a><span class="mdi mdi-hexagon-multiple"></span><span>Talents Pool</span></a>
            <a class="create"><span class="mdi mdi-plus-circle-outline"></span><span>Create</span>
            <?php 
include("public/nav_and_footer/createPopup.php");
?>
            </a>
        </div>
    </nav>

