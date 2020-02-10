import $ from "jquery";
import { AJYPost } from '../../../scripts/AjuwayaRequests'
import { TimeConverter } from '../../Functionalities'
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
   let everyUpload = document.querySelectorAll("#MessageUploadPreview div")
   let uploadvalues = ''
   if(everyUpload.length > 0){
    for (var i = 0; i<everyUpload.length; i++){
        let getID = everyUpload[i].id.split("MessageUploadPreview");
        uploadvalues += getID[1] + ','
    }
    uploadvalues = uploadvalues.slice(',', -1)
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
                                            <video width="320" height="240" controls>
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
                                <a href="http://www.example.com/folder/file.zip" class="download_button">
                                    <div class="downloadicon">
                                    <div class="cloud"><div class="arrowdown"></div></div>
                                    </div>
                                    <div class="filename"><span class="value">File.zip</span></div>
                                    <div class="filesize">Size : <span class="value">19 MB</span></div>
                                </a>
                            `
                   }
                        
                   }
               }
                    const messages = `
                                        <div class="message sent">
                                        <div style="width: 100%">${uploadImageHTML}</div>
                                        ${data.reply}
                                        <span class="metadata">
                                            <span class="time">${TimeConverter(data.time)}</span>
                                        </span>
                                    </div>
                                `

                    $("#conversation-container").append(messages)

                    /*****************************************************************************
                                    UPDATE CONVERSATION LIST BLOCK
                    *****************************************************************************/
                        
                        
                    /*****************************************************************************
                                    UPDATE CONVERSATION LIST BLOCK ENDS
                    *****************************************************************************/
                            
                })

                $("#conversation-container").animate({
                    "scrollTop": $('#conversation-container')[0].scrollHeight
                }, "slow")
                $('#conversationReply').val('')
                $('#conversationReply').focus()


                $('#MessageUploadPreviewContainer').fadeOut()
                $('#MessageUploadPreview').html('')
            }
        })
    }

    
}
