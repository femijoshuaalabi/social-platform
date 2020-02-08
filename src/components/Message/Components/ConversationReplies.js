import $ from "jquery";
import { AJYPost } from '../../../scripts/AjuwayaRequests'
import { TimeConverter } from '../../Functionalities'
import EmojiButton from '@joeattardi/emoji-button';

export function ConversationReplies() {

    let uid = $('#uid').val();
    let public_username = $('#public_username').val();
    let username = $('#username').val();
    let token =  $('#token').val();
    let last = ''
    let message_user = public_username


    /*****************************************************************************
                    OPEN MESSAGE BOX IS PUBLICK USERNAME IS AVAILABLE
    *****************************************************************************/
    if(message_user !== ""){
        let placeOwner = document.querySelector("#chatColumn .placeOwner")
        let placeHolder = document.querySelector("#chatColumn .placeHolder")
        let msgColumn = document.getElementById("msgColumn")
        let chatColumn = document.getElementById("chatColumn")

        if (placeOwner.classList.contains("d-none")) {
            placeOwner.classList.remove("d-none")
            placeHolder.parentNode.removeChild(placeHolder)

            msgColumn.classList.add("hide-sm-and-down")
            chatColumn.classList.remove("hide-sm-and-down")
        }
    }



    /*****************************************************************************
                            PAGE MODULE DECLARATION ENDS
    *****************************************************************************/

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
            /*****************************************************************************
                            THIS BLOCK HERE IS TO UPDATE HTML TAGS
            *****************************************************************************/
            //note: if conversationId html tags is unavailable Javascript will throw an error
            $('#conversationId').val(result.conversationReplies[0].c_id_fk) 
            $('#visited_Name').html(result.conversationReplies[0].otherName)

            /*****************************************************************************
                                            BLOCK CLOSED
            *****************************************************************************/
            
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
                                    <span class="time">${TimeConverter(data.time)}</span>
                                </span>
                            </div>
                        `
                    } else {
                        messages = `
                            <div class="message received">
                            ${data.reply}
                                <span class="metadata">
                                    <span class="time">${TimeConverter(data.time)}</span>
                                </span>
                            </div>
                        `
                    }
                    
                }
                $("#conversation-container").append(messages)
                $("#conversation-container").animate({
                    "scrollTop": $('#conversation-container')[0].scrollHeight
                }, "slow");
            })
        }
    })


    /*****************************************************************************
                            EMOJI CREATION: NB: 
                        DEPRECATED FOR CONTINUTITY
    *****************************************************************************/
    const button = document.querySelector('#emoji-button');
    const picker = new EmojiButton();
  
    picker.on('emoji', emoji => {
      document.querySelector('#conversationReply').value += emoji;
    });
  
    button.addEventListener('click', () => {
      picker.pickerVisible ? picker.hidePicker() : picker.showPicker(button);
    });

}