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
               /*upload */
               var uploadImageHTML = '';
               var C = '';
               if (data.uploadPaths) {
                   if (data.uploadPaths.length > 1) {
                       for (var i = 0; i < data.uploadPaths.length; i++) {
                           C = '<a href="' + data.uploadPaths[i] + '" data-lightbox="lightbox' + data.msg_id + '" style="display:block;width:100%; max-width:300px; max-height:300px;"><img src="' + data.uploadPaths[i] + '" class="conversationPreview" style="max-width: 200px !important;" id="' + data.msg_id + '" rel="' + data.msg_id + '"/></a>';
                           uploadImageHTML += C;
                       }
                   } else {

                    let uploads = data.uploadPaths[0];
                    let ext = uploads.split('.');

                    let video_array = ['mp4','ogg']
                    let image_array = ['jpg','gif','png']
                    let audio_array = ['mp3','wav']

                    /*****************************************************************************
                                        VIDEO PLAYER: NB... WOKRING ON IT
                    *****************************************************************************/

                    if (video_array.includes(ext[ext.length - 1])) {
                        uploadImageHTML = `
                                            <video width="100%" playsinline controls>
                                                <source src="${uploads}" type="video/mp4">
                                                <source src="${uploads}" type="video/ogg">
                                            </video>
                                            `
                    }else if (audio_array.includes(ext[ext.length - 1])) {

                     /*****************************************************************************
                                        Audio PLAYER: NB... WOKRING ON IT
                    *****************************************************************************/

                        
                        uploadImageHTML =      `
                                        <audio controls>
                                            <source src="${uploads}" type="audio/ogg">
                                            <source src="${uploads}" type="audio/mpeg">
                                        </audio>
                            `
                    }else if (image_array.includes(ext[ext.length - 1])) {

                     /*****************************************************************************
                                        IMAGE: NB... WOKRING ON IT
                    *****************************************************************************/
                   
                        if(ext[ext.length - 1] == 'gif'){
                            // Apply Gif Extention
                        }else {
                            uploadImageHTML = '<img src="' + uploads + '" class="conversationPreview" style="margin-bottom: 10px; max-width: 100% !important;" id="' + data.msg_id + '" rel="' + data.msg_id + '"/>'
                        }
                   } else {
                         /*****************************************************************************
                                            FILES: NB... WOKRING ON IT
                        *****************************************************************************/
                       uploadImageHTML =      `
                                <a href="${uploads}" class="download_button">
                                    <div class="downloadicon">
                                    <div class="cloud"><div class="arrowdown"></div></div>
                                    </div>
                                    <div class="filename"><span class="value">File</span></div>
                                    <div class="filesize">Size : <span class="value">19 MB</span></div>
                                </a>
                            `
                   }
                        
                   }
               }

                let messages = ''
                if (data.username) {
                    if (data.username == username) {
                        messages = `
                               <div class="message sent">
                               <div style="width: 100%">${uploadImageHTML}</div>
                                ${data.reply}
                                <span class="metadata">
                                    <span class="time">${TimeConverter(data.time)}</span>
                                </span>
                            </div>
                        `
                    } else {
                        messages = `
                            <div class="message received">
                            <div style="width: 100%">${uploadImageHTML}</div>
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
                }, "fast");
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