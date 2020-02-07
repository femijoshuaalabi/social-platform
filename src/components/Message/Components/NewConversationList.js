
import $ from "jquery"
import { AJYPost } from '../../../scripts/AjuwayaRequests'

import { TimeConverter } from '../../Functionalities'

/*****************************************************************************
                        DISPLAY USER CONTACT LIST
*****************************************************************************/

export function NewConversationList() {
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
                console.log(data)
                let notificationBudget = ''
                if(data.unreadMessageCount !== 0){
                    notificationBudget = `<span class="notification-count">${data.unreadMessageCount}</span>`
                }
                const conversationsList = `
                        <div id="msgList" key="${ data.uid }" class="row no-gutters flex-nowrap align-items-center p-1" style="position:relative">
                            <div>
                                <img src="${ data.profile_pic }" alt="${ data.username }" class="rounded">
                            </div>
                            <div class="py-1 pl-2 flex-grow-1" style="max-width:85%;">
                                <div class="row no-gutters flex-nowrap justify-content-between align-items-center">
                                    <h6 class="mb-1 font-weight-bolder text-truncate" style="max-width:60%;">${ data.name }</h6>
                                    <p class="mb-1 text-right mr-3 text-nowrap"><span class="small "><small>${TimeConverter(data.time) }</small></span></p>
                                    ${notificationBudget}
                                </div>
                                <p class="small my-0 text-muted text-truncate pr-2" id="MessageLastReply">
                                ${ data.lastReply.reply }
                                </p>
                                <p class="small my-0 text-muted text-truncate pr-2" id="LastReplyIsTyping" style="display:none; color: #196b69 !important"></div>
                            </div> 
                        </div>
                        <hr class="my-3">
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
                    var neededTarget = $(e.target).closest('#msgList')
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

}