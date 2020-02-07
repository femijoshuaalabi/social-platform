
import $ from "jquery"
import { AJYPost } from '../../../scripts/AjuwayaRequests'
import { ConversationReplies } from './ConversationReplies'

import { Networks } from '../../Networks/Networks'
import { isTypingCheckUp } from './isTypingCheckUp'
import { UserLastSeenUpdate } from '../../onlineStatus'
import { conversationNewReplies } from './conversationNewReplies'
import { TimeConverter } from '../../Functionalities'

/*****************************************************************************
                        DISPLAY USER CONTACT LIST
*****************************************************************************/

export function ConversationLists() {
    const uid = $('#uid').val()
    const token = $('#token').val()

    const last_time = ''
    const conversation_uid = ''

    const encodedata = {
        uid: uid,
        token: token,
        last_time: last_time,
        conversation_uid: conversation_uid
    }
    $.baseUrl = $('#BASE_URL').val()
    let apiBaseUrl = $.baseUrl + 'Aapi/conversationLists'

    AJYPost(apiBaseUrl, encodedata).then((result) => {

        if (result.conversations.length) {
            let ContactList = ''
            $.each(result.conversations, (i, data) => {
                let notificationBudget = ''
                if(data.unreadMessageCount !== 0){
                    notificationBudget = `<span class="notification-count" id="updateConversation${ data.uid }">${data.unreadMessageCount}</span>`
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
                ContactList += conversationsList
            })
            let msgBox = document.getElementById('conversation_list_box')
            msgBox.innerHTML = ContactList

            let msgColumn = document.getElementById("msgColumn")
            let chatColumn = document.getElementById("chatColumn")
            let returnBtn = document.querySelector("#chatColumn #return")
            let placeHolder = document.querySelector("#chatColumn .placeHolder")
            let placeOwner = document.querySelector("#chatColumn .placeOwner")
            let currentChatImage = document.querySelector("#chatHead img")
            let currentChatName = document.querySelector("#chatHead h6")

            /*****************************************************************************
                        MAKE FUNCTIONAL METHODS RUNS ONLY WHEN PUBLIC USERNAME IS SET
            *****************************************************************************/
            
            let public_username = $('#public_username').val()
            let MessageUrlOnceChanged = $('#MessageUrlOnceChanged').val()
            if(public_username != '' && MessageUrlOnceChanged == ""){
                // Clear last seen before querying
                $('#message_last_seen').html('')

                //Check if user is typing
                isTypingCheckUp()

                //Check if user is online
                UserLastSeenUpdate()

                //New Reply slow up
                conversationNewReplies()
            }

            /*****************************************************************************
            BLOCKED CLOSED: MAKE FUNCTIONAL METHODS RUNS ONLY WHEN PUBLIC USERNAME IS SET
            *****************************************************************************/

            msgBox.addEventListener("click", getActiveMessage, false)

            function getActiveMessage(e) {

                if (placeOwner.classList.contains("d-none"))
                {
                    placeOwner.classList.remove("d-none")
                    placeHolder.parentNode.removeChild(placeHolder)
                }
                var currentUser = result.conversations.find(function (item) {
                    var neededTarget = $(e.target).closest('.msgList')
                    if (item.uid === neededTarget.attr('key'))
                    {
                        return item
                    }
                })

               if(currentUser){
                    /*****************************************************************************
                                            THIS IS THE ONLY CODE I ADDED
                    *****************************************************************************/
                    //This block helps in changing URL for the user message view
                    let page_url = $.baseUrl + 'message/' + currentUser.username
                    window.history.pushState('', "Personal Message View", page_url)
                    $('#public_username').val(currentUser.username)
                    $('#conversationId').val(currentUser.c_id)
                    $('#MessageUrlOnceChanged').val('true')

                    /*****************************************************************************
                                        FUNCTIONAL METHODS INIT
                    *****************************************************************************/
                    if(currentUser.username !== ''){
                        ConversationReplies()
                        // Clear last seen before querying
                        $('#message_last_seen').html('')

                        //Check if user is typing
                        isTypingCheckUp()

                        //Check if user is online
                        UserLastSeenUpdate()

                        //New Reply slow up
                        conversationNewReplies()

                    }
                    /*****************************************************************************
                                            THIS IS THE ONLY CODE I ADDED
                    *****************************************************************************/

                    currentChatImage.setAttribute("src", currentUser.uid)
                    currentChatName.textContent = currentUser.name.length > 20
                        ? currentUser.name.slice(0, 20) + "..."
                        : currentUser.name
                    if (window.matchMedia("(max-width: 768px)").matches)
                    {
                        msgColumn.classList.add("hide-sm-and-down")
                        chatColumn.classList.remove("hide-sm-and-down")
                    }
                }
            }

            returnBtn.onclick = function () {
                msgColumn.classList.remove("hide-sm-and-down")
                chatColumn.classList.add("hide-sm-and-down")
                let page_url = $.baseUrl + 'message/'
                window.history.pushState('', "Back Conversation View", page_url)
            }

        } else
        {
            //User have no contact List
            return "You currently have no messages. Add some friends to begin!"
        }

    })
   

    //I move this out of if statement block so it can fire both when user have contact list or not


    /*****************************************************************************
                               USER FRIENDS LIST BLOCK
       Note: This block is important because it will help use to choose from 
       their friend list if they don't have contact list
   *****************************************************************************/
    let firSearchBtn = document.querySelector("#friSearch")
    firSearchBtn.onclick = function (e) {
        document.querySelector(".friendSearchBox").classList.toggle("d-none")
        if (!$('.friendSearchBox').hasClass("d-none")){
            //Execute User Friend List
            $('#displayUserFriendsList').html('')
            // Network Class is under Networks/network, Please work on it so it can work same way as contactlist works
            let FriendsList = new Networks()
            FriendsList.UserNetworksForMessages()

            $('#conversation_list_box').hide()
            $('#search_list_box').show()
            $('#search_list_box').addClass('BoxOnceOpened')
        }else {
            $('#conversation_list_box').show()
            $('#search_list_box').hide()
        }
    }

}