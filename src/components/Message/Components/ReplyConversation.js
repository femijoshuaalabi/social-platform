import $ from "jquery";
import { AJYPost } from '../../../scripts/AjuwayaRequests'

/*****************************************************************************
                    ALLOW USER TO TYPE AND REPLY MESSAGES
*****************************************************************************/
   export function ReplyConversation () {
        
    /*****************************************************************************
                    DISPLAY SENT MESSAGES BEFORE QUERYING DB
                                Things to work on
    *****************************************************************************/

    let uid = $('#uid').val()
    let token =  $('#token').val()
    let reply = $("#conversationReply").val()
    let c_id = $('#conversationId').val()

    /*****************************************************************************
                        GIVE USER OPPOTUNITY TO UPLOAD
    *****************************************************************************/
    let up = $("#uploadvalues").val()
    let uploadvalues = 0
    if (up) {
      uploadvalues = $("#uploadvalues").val()
    } else {
      uploadvalues = $(".preview:last").attr('id')
    }

    /*****************************************************************************
                        GIVE USER OPPOTUNITY TO UPLOAD
    *****************************************************************************/

    let encodedata = {
        uid: uid,
        token: token,
        c_id: c_id,
        reply: reply,
        uploads: uploadvalues
    }

    $.baseUrl = $('#BASE_URL').val();
    let apiBaseUrl = $.baseUrl + 'Aapi/ReplyConversation'; //call api

    if ($.trim(reply).length > 0) {
        AJYPost(apiBaseUrl,encodedata).then((result) => {
            if (result.conversationReply.length) {
                $.each(result.conversationReply, (i, data) => {
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

                    const messages = `
                                        <div class="message sent">
                                        ${data.reply}
                                        <span class="metadata">
                                            <span class="time">2:45pm</span>
                                        </span>
                                    </div>
                                `

                    $("#conversation-container").append(messages)
                            
                })

                $("#conversation-container").animate({
                    "scrollTop": $('#conversation-container')[0].scrollHeight
                }, "slow");
                $('#conversationReply').val('');
                $('#conversationReply').focus();
            }
        });
    }

    
}
