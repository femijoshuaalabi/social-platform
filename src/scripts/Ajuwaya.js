import $ from "jquery";
import { AJYPost,AJYGet } from './AjuwayaRequests'

//Variable
$.baseUrl = $('#BASE_URL').val();
let uid = $('#uid').val();
let username = $('#username').val();
let public_username = $('#public_username').val();
let token =  $('#token').val();


let PAGE_NAME = $('#PAGE_NAME').val();

export function AjuwayaSeperator(){

    switch (PAGE_NAME) {

        case "login":
            Login();
            break;
        case "register":
            Register();
            break;
        case "message":
            ConversationLists()
            ConversationReplies()
            ReplyConversation()
            break;
    }
    
}

/*****************************************************************************
                            LOGIN TO ACCOUNT
*****************************************************************************/
function Login(){

    let apiBaseUrl = $.baseUrl + 'Aapi/login';

    $('#login').on('click', function(){
        let username = $('#username').val();
        let password = $('#password').val();

        let encodedata = {
            username: username,
            password: password
        }

        AJYPost(apiBaseUrl,encodedata).then((result) => {

            let data = result.login[0];
            let cdata = data.configurations[0];
            if( data.uid > 0 ) {
                
                var url = $.baseUrl + 'public/authentication.php?uid=' + data.uid +
		                        '&notification_created=' + data.notification_created + '&token=' +
		                        data.token +
		                        '&name=' + data.name + '&username=' + data.username + '&pic=' + data
		                        .profile_pic +
		                        '&newsfeedPerPage=' + cdata.newsfeedPerPage + '&friendsPerPage=' +
		                        cdata.friendsPerPage +
		                        '&photosPerPage=' + cdata.photosPerPage + '&groupsPerPage=' + cdata
		                        .groupsPerPage +
		                        '&notificationPerPage=' + cdata.notificationPerPage +
		                        '&friendsWidgetPerPage=' + cdata.friendsWidgetPerPage + '&tour=' +
                                data.tour;
		                        window.location.replace(url);
            }
        });

    })
}

/*****************************************************************************
                            REGISTER AN ACCOUNT
*****************************************************************************/
function Register(){
    console.log('helo')
}

/*****************************************************************************
                            MESSEGING METHODS
*****************************************************************************/
function ConversationLists(){

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

function ConversationReplies(){

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

function ReplyConversation(){
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

    
}





