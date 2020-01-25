<?php

/* Profile Picuture */

function backgroundPic($backgroundPic) {
    if ($backgroundPic) {
        $backgroundPic = BASE_URL . UPLOAD_PATH . $backgroundPic;
    } else {
        $backgroundPic = BASE_URL . 'wall_icons/defaultBG.png';
    }

    return $backgroundPic;
}

/* Profile Picuture */

function profilePic($profilePic) {
    if ($profilePic) {
        $profile_pic = BASE_URL . UPLOAD_PATH . $profilePic;
    } else {
        $profile_pic = BASE_URL . 'wall_icons/default.png';
    }

    return $profile_pic;
}

/* Group Profile Picuture */

function groupPic($profilePic) {
    if ($profilePic) {
        $profile_pic = BASE_URL . UPLOAD_PATH . $profilePic;
    } else {
        $profile_pic = BASE_URL . 'wall_icons/defaultGroup.png';
    }

    return $profile_pic;
}

?>