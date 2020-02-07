import $ from "jquery"
import { AJYPost } from '../../../scripts/AjuwayaRequests'
//Plugin
require('../../../plugins/Ajuwaya-Plugins')


export function MediaUpload(){
    imageUpload()
}

function imageUpload(){

     /*****************************************************************************
                            MAKE IMAGE UPLOAD ICON CLICKABLE
    *****************************************************************************/
    $('body').on('click','#image-upload', () => {
       $('#photoimg').click()
    })

    $('body').on('change', '#photoimg', function() {
        $('#MessageUploadPreviewContainer').fadeIn('slow')
        $("#imageform").ajaxForm({
            beforeSubmit: function() {
                $("#imageloadstatus").show()
            },
            success: function(e) {
                $("#imageloadstatus").hide()
                $('#MessageUploadPreview').append(e)
            },
            error: function(e) {
                $("#imageloadstatus").hide()
            }
        }).submit()
    })

    $('body').on('click','.MessageUploadDelete', function(e){
        let TargetId = e.currentTarget.id
        var sid = TargetId.split("photo");
        var pid = sid[1];
        var group_id = '';
        var photo_uid = pid;

        const uid = $('#uid').val()
        const token = $('#token').val()

        const encodedata = {
            uid: uid,
            token: token,
            pid: pid,
            group_id: group_id,
            photo_uid: uid
        }
        $.baseUrl = $('#BASE_URL').val()
        let apiBaseUrl = $.baseUrl + 'Aapi/deletePhoto'

        AJYPost(apiBaseUrl, encodedata).then((result) => {
            if (result.deletePhoto.length) {
                $("#MessageUploadPreview" + pid).fadeOut('slow')
                let elem = document.getElementById("MessageUploadPreview" + pid)
                elem.parentNode.removeChild(elem)
                if($('#MessageUploadPreview').html() == ''){
                    $("#MessageUploadPreviewContainer").fadeOut('slow')
                }
            }
        })
    })

}
