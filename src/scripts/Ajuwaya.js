import $ from "jquery";
import { AJYPost,AJYGet } from './AjuwayaRequests'
import { RegistrationForm } from '../components/Registration/RegistrationForm'
import { LoginBlock } from '../components/Login/LoginBlock'
import { MessageBlock } from '../components/Message/MessageBlock'

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
                            MESSEGING METHODS
*****************************************************************************/
function Message(){
    let message = new MessageBlock();
}

/*****************************************************************************
                           USER PROFILE
*****************************************************************************/




