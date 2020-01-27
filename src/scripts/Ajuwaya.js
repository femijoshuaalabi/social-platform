import $ from "jquery";
import { AJYPost,AJYGet } from './AjuwayaRequests'

//Variable
$.baseUrl = $('#BASE_URL').val();
let uid = $('#uid').val();
let username = $('#username').val();
let public_username = $('#public_username').val();
let token =  $('#token').val();


/*****************************************************************************
                            LOGIN TO ACCOUNT
*****************************************************************************/
export function Login(){

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
                            MESSEGING METHODS
*****************************************************************************/
export function conversationLists(){

    //last_time will be the last createdtime of the conversationLists and it's will
    //be use to fetch and 15 records on user scroll from the database.
    //Hint: Use state or Global Variable so that last_time will be changing on every
    //15 called records
    //Note: last_time should return empty string by default and change per return records from database

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

