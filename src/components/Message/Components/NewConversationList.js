
import $ from "jquery"
import { AJYPost } from '../../../scripts/AjuwayaRequests'

import { TimeConverter } from '../../Functionalities'

/*****************************************************************************
                        NEW CONVERSATION LIST
                NB: THIS METHOD IS ONLY USED ON AJAX REQUEST
*****************************************************************************/

export function NewConversationList() {
    const uid = $('#uid').val()
    const token = $('#token').val()

    const encodedata = {
        uid: uid,
        token: token
    }
    $.baseUrl = $('#BASE_URL').val()
    let apiBaseUrl = $.baseUrl + 'Aapi/NewConversationLists'

    AJYPost(apiBaseUrl, encodedata).then((result) => {
        if (result.conversations.length) {
            $.each(result.conversations, (i, data) => {
                /*****************************************************************************
                                CHECK IF THERE'S NEW MESSAGES NOTIFICATION
                *****************************************************************************/
                if(data.unreadMessageCount > 0 ) {
                    $("#conversationsList"+data.uid).attr('data-time', data.time)
                    $("#updateConversation" +data.uid).show().html(data.unreadMessageCount)
                    $(".MessageLastReply" +data.uid).html(data.lastReply.reply) 
                    $("#conversationDateTime" +data.uid).html(TimeConverter(data.time))

                    let conversationsList = $(".orderMessages")
                    conversationsList.sort(function(a, b){ return $(b).data("time") - $(a).data("time") })

                    $("#conversation_list_box").html(conversationsList)
                }
            })
        }
    })

}