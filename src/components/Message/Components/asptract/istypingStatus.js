import $ from "jquery"
import { AJYPost } from '../../../../scripts/AjuwayaRequests'

export function istypingStatus()  {
    let uid = $('#uid').val();
    let public_username = $('#public_username').val();
    let token =  $('#token').val();

    let encodedata = {
        uid: uid,
        token: token,
        message_user: public_username
    }

    $.baseUrl = $('#BASE_URL').val();
    let apiBaseUrl = $.baseUrl + 'Aapi/istypingStatus'

    AJYPost(apiBaseUrl,encodedata).then((result) => {
        if (result.updates.length) {
            //console.log(result.updates);
        }
    })
}