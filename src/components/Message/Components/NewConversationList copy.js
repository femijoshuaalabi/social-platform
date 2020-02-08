
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
                console.log(data)
                /*****************************************************************************
                                CHECK IF THERE'S NEW MESSAGES NOTIFICATION
                *****************************************************************************/
                if(data.unreadMessageCount <= 1 && data.lastReply.user_id_fk !== uid && !$("#updateConversation"+data.uid).hasClass('loaded')) {
                    $("#conversationsList" + data.uid).fadeOut('slow')
                    let elem = document.getElementById("conversationsList" + data.uid)
                    elem.parentNode.removeChild(elem)

                    let notificationBudget = ''
                    if(data.unreadMessageCount !== 0){
                        notificationBudget = `<span class="notification-count loaded" id="updateConversation${ data.uid }">${data.unreadMessageCount}</span>`
                    }

                    const conversationsList = `
                            <div id="conversationsList${ data.uid }" key="${ data.uid }" class="my-3 msgList row no-gutters flex-nowrap align-items-center p-1" style="position:relative">
                                <div>
                                    <img src="${ data.profile_pic }" alt="${ data.username }" class="rounded">
                                </div>
                                <div class="py-1 pl-2 flex-grow-1" style="max-width:85%;">
                                    <div class="row no-gutters flex-nowrap justify-content-between align-items-center">
                                        <h6 class="mb-1 font-weight-bolder text-truncate" style="max-width:60%;">${ data.name }</h6>
                                        <p class="mb-1 text-right mr-3 text-nowrap"><span class="small "><small>${TimeConverter(data.time) }</small></span></p>
                                        ${notificationBudget}
                                    </div>
                                    <p class="small my-0 text-muted text-truncate pr-2 MessageLastReply${ data.uid }" id="MessageLastReply">
                                    ${ data.lastReply.reply }
                                    </p>
                                    <p class="small my-0 text-muted text-truncate pr-2" id="LastReplyIsTyping" style="display:none; color: #196b69 !important"></div>
                                </div> 
                            </div>
                    `
                    $('#conversation_list_box').prepend(conversationsList).fadeIn('slow')
                }else {
                    let parent = $("#conversationsList"+data.uid).parent()
                    $( "#conversationsList"+data.uid ).appendTo( parent );
                    $("#updateConversation" +data.uid).html(data.unreadMessageCount)
                    $(".MessageLastReply" +data.uid).html(data.lastReply.reply)
                }
            })
        }
    })

}