import $ from "jquery";
import { AJYPost } from '../scripts/AjuwayaRequests'
import { TimeConverter } from './Functionalities'

/*****************************************************************************
                            ONLINE UPDATES
*****************************************************************************/

export function UserLastSeenUpdate(){
    setInterval(() => {
        onlineStatus()
    }, 6000)
}

function onlineStatus () {

    let uid = $('#uid').val()
    let token =  $('#token').val()
    let public_username = $('#public_username').val()
    let message_user = public_username

    let encodedata = {
        uid: uid,
        token: token,
        message_user: message_user
    }

    $.baseUrl = $('#BASE_URL').val();
    let apiBaseUrl = $.baseUrl + 'Aapi/onlineStatus'; //call api

    AJYPost(apiBaseUrl,encodedata).then((result) => {
        if (result.updates.length) {
            if (result.updates == 'Yes') {
                //User Online indicator here
                $('#message_last_seen').html('online')
            } else {
                var timestamp = result.updates[0].last_seen;
                $('#message_last_seen').html('last seen: ' + TimeConverter(timestamp))
            }
        }
    })



}



/*****************************************************************************
                        THIS FUNCTION IS A GLOBAL FUNCTION AND
                    ITS INITIATION IS DECLERED IN AJUWAYA.JS MODULE
*****************************************************************************/

export function onlineStatusUpdate(){

    let uid = $('#uid').val()
    let token =  $('#token').val()

    let encodedata = {
        uid: uid,
        token: token
    }

    $.baseUrl = $('#BASE_URL').val();
    let apiBaseUrl = $.baseUrl + 'Aapi/onlineStatusUpdate'; //call api

    AJYPost(apiBaseUrl,encodedata).then((result) => {
        if (result.updates.length) {
            //console.log(result.updates);
        }
    })
}