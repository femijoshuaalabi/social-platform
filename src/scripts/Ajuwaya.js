import $ from "jquery"
import { onlineStatusUpdate } from '../components/onlineStatus'
import { RegistrationForm } from '../components/Registration/RegistrationForm'
import { LoginBlock } from '../components/Login/LoginBlock'
import { MessageBlock } from '../components/Message/MessageBlock'

import { FriendSuggession } from '../components/Networks/FriendSuggession'

//Variable
let PAGE_NAME = $('#PAGE_NAME').val();

/*****************************************************************************
                    AjuwayaSeperator Seperate Components for each Pages
*****************************************************************************/
export function AjuwayaSeperator(){

    switch (PAGE_NAME) {

        case "login":
            Login()
            break;
        case "register":
            Register()
            break;
        case "message":
            Message()
            break;
        case "home":
            FriendSuggestionList()
            break
    }

    if (typeof $('#token').val() !== 'undefined'){
        UserOnlineUpdateStatus()
    }
}

/*****************************************************************************
                            LOGIN TO ACCOUNT
*****************************************************************************/
function Login(){
    let Login = new LoginBlock();
}

/*****************************************************************************
                            REGISTER AN ACCOUNT
*****************************************************************************/
function Register(){
    $('.RegistrationStep').hide();
    let register = new RegistrationForm();
}

/*****************************************************************************
                        USER ONLINE UPDATE STATUS
*****************************************************************************/
function UserOnlineUpdateStatus(){
    setInterval(() => {
        onlineStatusUpdate()
    },4000)
}

/*****************************************************************************
                            MESSEGING METHODS
*****************************************************************************/
function Message(){
    let message = new MessageBlock();
}

/*****************************************************************************
                    HOME, NEWSFEED, FRIEND SUGGESIONS
*****************************************************************************/
function FriendSuggestionList(){
    let suggestions = new FriendSuggession()
}

/*****************************************************************************
                           USER PROFILE
*****************************************************************************/




