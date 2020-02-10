import $ from "jquery";
import { AJYPost } from '../../../scripts/AjuwayaRequests'
import { TimeConverter } from '../../Functionalities'

export function conversationNewReplies(){
    setInterval(() => {
        NewReplies()
    },3000)
}

function NewReplies() {
    let uid = $('#uid').val();
    let public_username = $('#public_username').val();
    let username = $('#username').val();
    let token =  $('#token').val();
    let last = ''
    let message_user = public_username

    let encodedata = {
        uid: uid,
        token: token,
        message_user: message_user,
        last: last
    }

    $.baseUrl = $('#BASE_URL').val();
    let apiBaseUrl = $.baseUrl + 'Aapi/conversationNewReplies';

    AJYPost(apiBaseUrl,encodedata).then((result) => {
        if (result.conversationReplies.length) {
            $.each(result.conversationReplies, (i, data) => {
                /*****************************************************************************
                                    CHECK IF MEDIA AVAILABLE
                *****************************************************************************/
               let uploadImageHTML = '';
               if (data.uploadPaths) {
                   if (data.uploadPaths.length > 1) {
                       for (var i = 0; i < data.uploadPaths.length; i++) {
                           //uploadImageHTML = HTML tags to display multiple media
                       }
                   } else {
                       //uploadImageHTML = HTML tags to display media
                   }
               }

               let messages = ''
                if (data.username) {
                    if (data.username == username) {
                        //Nothing should be here
                    } else {
                        messages = `
                            <div class="message received">
                            ${data.reply}
                                <span class="metadata">
                                    <span class="time">${TimeConverter(data.time)}</span>
                                </span>
                            </div>
                        `

                    $("#conversation-container").append(messages)
                    $("#conversation-container").animate({
                        "scrollTop": $('#conversation-container')[0].scrollHeight
                    }, "fast")
                    }
                    
                }
            })
        }
    })

}