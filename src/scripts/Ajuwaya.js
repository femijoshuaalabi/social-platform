import $ from "jquery";
import { AJYPost,AJYGet } from './AjuwayaRequests'

//Variable
$.baseUrl = $('#BASE_URL').val();

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

