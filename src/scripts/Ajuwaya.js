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
<<<<<<< HEAD
export function ConversationLists(){

    //last_time will be the last createdtime of the conversationLists and it's will
    //be use to fetch and 15 records on user scroll from the database.
    //Hint: Use state or Global Variable so that last_time will be changing on every
    //15 called records
    //Note: last_time should return empty string by default and change per return records from database
    // and last_time will be equal to result.time after the first call

    //Conversation_uid shoud return empty string, this is used to exclude user from the
    //conversation list
    //Hint: conversation_id = ''

    let last_time = ''
    let conversation_uid = ''

    let encodedata = {
        uid: uid,
        token: token,
        last_time: last_time,
        conversation_uid: conversation_uid 
    }

    let apiBaseUrl = $.baseUrl + 'Aapi/conversationLists';

    AJYPost(apiBaseUrl,encodedata).then((result) => {
        console.log(result)
    });


}

export function ConversationReplies(){

    let last = ''
    let message_user = "ajuwaya2"

    let encodedata = {
        uid: uid,
        token: token,
        message_user: message_user,
        last: last
    }

    let apiBaseUrl = $.baseUrl + 'Aapi/conversationReplies';

    AJYPost(apiBaseUrl,encodedata).then((result) => {
        console.log(result)
    });


}

export function ReplyConversation(){
    let reply = $("#conversationReply").val();
    let up = $("#uploadvalues").val();
    let uploadvalues = 0;
    if (up) {
      uploadvalues = $("#uploadvalues").val();
    } else {
      uploadvalues = $(".preview:last").attr('id');
    }

    //Variable declare in this block are just for testing
    let c_id = "143" // c_id is the conversation id, this can be get using onclick function
    reply = 'Hello'; //This is the message the user typed. it will be get from message form field

    let encodedata = {
        uid: uid,
        token: token,
        c_id: c_id,
        reply: reply,
        uploads: uploadvalues
    }

    let apiBaseUrl = $.baseUrl + 'Aapi/ReplyConversation'; //call api

    if ($.trim(reply).length > 0) {
        AJYPost(apiBaseUrl,encodedata).then((result) => {
            console.log(result)
        });
    }

    
=======
function Message(){
    let message = new MessageBlock();
>>>>>>> 441ba5a1c3e6e0d6cac3b54b13427a947807917d
}

/*****************************************************************************
                           USER PROFILE
*****************************************************************************/




