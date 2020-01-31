import $ from "jquery";
import { AJYPost,AJYGet } from '../../scripts/AjuwayaRequests'

export class MessageBlock {

    constructor(){
        this.initiator()
    }


    initiator = () => {
        this.ConversationLists()
        this.ConversationReplies()
        this.ReplyConversation()
    }


    ConversationLists = () => {
            //last_time will be the last createdtime of the conversationLists and it's will
            //be use to fetch and 15 records on user scroll from the database.
            //Hint: Use state or Global Variable so that last_time will be changing on every
            //15 called records
            //Note: last_time should return empty string by default and change per return records from database
            // and last_time will be equal to result.time after the first call

            //Conversation_uid shoud return empty string, this is used to exclude user from the
            //conversation list
            //Hint: conversation_id = ''

            let uid = $('#uid').val();
            let username = $('#username').val();
            let public_username = $('#public_username').val();
            let token =  $('#token').val();

            let last_time = ''
            let conversation_uid = ''

            let encodedata = {
                uid: uid,
                token: token,
                last_time: last_time,
                conversation_uid: conversation_uid 
            }
            $.baseUrl = $('#BASE_URL').val();
            let apiBaseUrl = $.baseUrl + 'Aapi/conversationLists';

            AJYPost(apiBaseUrl,encodedata).then((result) => {
                console.log(result)
            });


    }

    ConversationReplies = () => {

        let uid = $('#uid').val();
        let username = $('#username').val();
        let public_username = $('#public_username').val();
        let token =  $('#token').val();
        let last = ''
        let message_user = "ajuwaya2"
    
        let encodedata = {
            uid: uid,
            token: token,
            message_user: message_user,
            last: last
        }

        $.baseUrl = $('#BASE_URL').val();
        let apiBaseUrl = $.baseUrl + 'Aapi/conversationReplies';
    
        AJYPost(apiBaseUrl,encodedata).then((result) => {
            console.log(result)
        });
    
    
    }

    ReplyConversation = () => {
        let uid = $('#uid').val();
        let username = $('#username').val();
        let public_username = $('#public_username').val();
        let token =  $('#token').val();
        let reply = $("#conversationReply").val();
        let up = $("#uploadvalues").val();
        let uploadvalues = 0;
        if (up) {
          uploadvalues = $("#uploadvalues").val();
        } else {
          uploadvalues = $(".preview:last").attr('id');
        }
    
        //Variable declare in this block are just for testing
        let c_id = "143" // c_id is the conversation id, this can be get using onclick function
        reply = 'Hello'; //This is the message the user typed. it will be get from message form field
    
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
                console.log(result)
            });
        }
    
        
    }


}

export default MessageBlock

