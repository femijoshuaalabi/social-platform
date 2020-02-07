import $ from "jquery"
import { AJYPost } from '../../../../scripts/AjuwayaRequests'

export function istypingStatusUpdate() {
    let uid = $('#uid').val()
    let public_username = $('#public_username').val()
    let token = $('#token').val()

    let encodedata = {
        uid: uid,
        token: token,
        message_user: public_username
    }

    $.baseUrl = $('#BASE_URL').val()
    let apiBaseUrl = $.baseUrl + 'Aapi/istypingStatusUpdate'


    AJYPost(apiBaseUrl, encodedata).then((result) => {
        if (result.istyping.length)
        {
            if (result.istyping == 'Yes')
            {
                //Display typing animation here
                $('#message_last_seen').hide()
                $('#MessageLastReply').hide()
                $('#message_is_typing').show().html('typing...')
                $('#LastReplyIsTyping').show().html('typing...')
            } else
            {
                //Remove typing animation here
                $('#message_last_seen').show()
                $('#MessageLastReply').show()
                $('#message_is_typing').html('').hide()
                $('#LastReplyIsTyping').html('').hide()
            }
        }
    })
}