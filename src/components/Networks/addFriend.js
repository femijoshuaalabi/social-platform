import $ from "jquery"
import { AJYPost } from '../../scripts/AjuwayaRequests'

export function addFriend(uid, fid, token)  {

    let encodedata = {
        uid: uid,
        token: token,
        fid: fid
    }

    $.baseUrl = $('#BASE_URL').val();
    let apiBaseUrl = $.baseUrl + 'Aapi/addFriend'

    AJYPost(apiBaseUrl,encodedata).then((result) => {
        if (result.friend.length) {
            if (parseInt(result.friend[0].status)) {
                $("#add" + fid).fadeOut('fast');
                $("#remove" + fid).removeClass('displaynone').fadeIn('fast');
            }
        }
    })
}