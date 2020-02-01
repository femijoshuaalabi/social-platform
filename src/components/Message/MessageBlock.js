import $ from "jquery"
import { AJYPost } from '../../scripts/AjuwayaRequests'
import { ConversationReplies } from './ConversationReplies'
let _ = require('underscore')

export class MessageBlock {

    constructor(){
        this.initiator()
    }


    initiator = () => {
        window.addEventListener('load',  this.ConversationLists(), false)
        ConversationReplies()
        const sendButton = document.querySelector('#sendButton')
        sendButton.addEventListener("click", () => {
            this.ReplyConversation()
        }, false)
        this.isTypingCheckUp()        
    }




    ConversationLists = () => {
        const uid = $('#uid').val();
        const token =  $('#token').val();

        const last_time = ''
        const conversation_uid = ''

        const encodedata = {
            uid: uid,
            token: token,
            last_time: last_time,
            conversation_uid: conversation_uid 
        }
        $.baseUrl = $('#BASE_URL').val();
        let apiBaseUrl = $.baseUrl + 'Aapi/conversationLists';

        AJYPost(apiBaseUrl,encodedata).then((result) => {

            if (result.conversations.length) {

                $.each(result.conversations, (i, data) => {

                    const conversationsList = `<div id="msgList" key="${data.uid }" class="row no-gutters flex-nowrap align-items-center p-1">
                                                <div>
                                                    <img src="${data.profile_pic}" alt="${data.username}" class="rounded mt-4">
                                                </div>
                                                <div class="py-1 pl-3" style="max-width:82%;">
                                                    <p class="text-right my-0 mr-3"><span class="small "><small>Jan 23, 02:25PM</small></span></p>
                                                    <h6 class="my-0 font-weight-bolder">${data.name}</h6>
                                                    <p class="small my-0 text-muted text-truncate pr-2">
                                                    ${data.lastReply.reply}
                                                    </p>
                                                </div>
                                            </div>
                                            <hr>`
                    let msgBox = document.getElementById('msgBox')
                    msgBox.innerHTML += conversationsList
                })


                var msgColumn = document.getElementById("msgColumn")
                var chatColumn = document.getElementById("chatColumn")
                var returnBtn = document.querySelector("#chatColumn #return")
                var msgList = document.querySelectorAll("#msgList")
                var currentChatImage = document.querySelector("#chatHead img")
                var currentChatName = document.querySelector("#chatHead h6")
                var html = document.querySelector("html")
                var chatBox = document.querySelector("#chatBox .conversation-container")

                msgBox.addEventListener("click", getUserMessage, false)
                function getUserMessage(e) {
                    var currentUser = result.conversations.find(function (item) {
                        var neededTarget = e.target.closest('#msgList')
                        if (item.uid === neededTarget.getAttribute('key'))
                        {
                            return item
                        }
                    })

                    /*****************************************************************************
                                            THIS IS THE ONLY CODE I ADDED
                    *****************************************************************************/
                    //This block helps in changing URL for the user message view
                    let page_url = $.baseUrl + 'message/' + currentUser.username;
                    window.history.pushState('', "Personal Message View", page_url);
                    $('#public_username').val(currentUser.username)
                    $('#conversationId').val(currentUser.c_id)
                    ConversationReplies()
                    /*****************************************************************************
                                            THIS IS THE ONLY CODE I ADDED
                    *****************************************************************************/

                    currentChatImage.setAttribute("src",currentUser.uid )
                    currentChatName.textContent = currentUser.name
                    if (window.matchMedia("(max-width: 768px)").matches)
                    {
                        msgColumn.classList.add("hide-sm-and-down")
                        chatColumn.classList.remove("hide-sm-and-down")
                    }
                }
                returnBtn.onclick = function () {
                    msgColumn.classList.remove("hide-sm-and-down")
                    chatColumn.classList.add("hide-sm-and-down")
                    let page_url = $.baseUrl + 'message/'
                    window.history.pushState('', "Back Conversation View", page_url);
                }


            } else {
                //User have no contact List
            }
            
        });
    }

    /*****************************************************************************
                        ALLOW USER TO TYPE AND REPLY MESSAGES
    *****************************************************************************/
    ReplyConversation = () => {
        
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

    /*****************************************************************************
                                ALERT IF USER IS TYPING
    *****************************************************************************/

    isTypingCheckUp = () => {
        var typing, typingStarted, typingStopped;
        typing = false;
        typingStopped = _.debounce((function() {
            if (!typing) {
                return;
            }
            typing = false;
            console.log('typing is done');
            //istypingStatusRemove(username, uid, token, apiBaseUrl, baseUrl, message_user);
        }), 2000);
        typingStarted = function() {
            if (typing) {
                return;
            }
            typing = true;
            console.log('typing has started');
            //istypingStatus(username, uid, token, apiBaseUrl, baseUrl, message_user);
        };
        document.querySelector("#conversationReply").oninput = function(event) {
            typingStarted();
            typingStopped();
            return;
        };
    }



}

export default MessageBlock

