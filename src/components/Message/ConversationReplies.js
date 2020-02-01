import $ from "jquery";
import { AJYPost } from '../../scripts/AjuwayaRequests'

export function ConversationReplies() {

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
    let apiBaseUrl = $.baseUrl + 'Aapi/conversationReplies';
    $("#conversation-container").html('')

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
                        messages = `
                               <div class="message sent">
                                ${data.reply}
                                <span class="metadata">
                                    <span class="time">2:45pm</span>
                                </span>
                            </div>
                        `
                    } else {
                        messages = `
                            <div class="message received">
                            ${data.reply}
                                <span class="metadata">
                                    <span class="time">2:48pm</span>
                                </span>
                            </div>
                        `
                    }
                    
                }
                $("#conversation-container").append(messages)
            })
        }
    });


}