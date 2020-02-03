
import $ from "jquery"
import { AJYPost } from '../../../scripts/AjuwayaRequests'
import { ConversationReplies } from './ConversationReplies'

import { Networks } from '../../Networks/Networks'

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

        if (result.conversations.length)
        {

            $.each(result.conversations, (i, data) => {

                const conversationsList = `
                        <div id="msgList" key="${ data.uid }" class="row no-gutters flex-nowrap align-items-center p-1">
                            <div>
                                <img src="${ data.profile_pic }" alt="${ data.username }" class="rounded">
                            </div>
                            <div class="py-1 pl-2 flex-grow-1" style="max-width:85%;">
                                <div class="row no-gutters flex-nowrap justify-content-between align-items-center">
                                    <h6 class="mb-1 font-weight-bolder text-truncate" style="max-width:60%;">${ data.name }</h6>
                                    <p class="mb-1 text-right mr-3 text-nowrap"><span class="small "><small>Jan 23, 02:25PM</small></span></p>
                                </div>
                                <p class="small my-0 text-muted text-truncate pr-2">
                                ${ data.lastReply.reply }
                                </p>
                            </div> 
                        </div>
                        <hr class="my-3">
                `
                let msgBox = document.getElementById('msgBox')
                msgBox.innerHTML += conversationsList
            })


            let msgColumn = document.getElementById("msgColumn")
            let chatColumn = document.getElementById("chatColumn")
            let returnBtn = document.querySelector("#chatColumn #return")
            let sendBtn = document.querySelector("#chatColumn .send")
            let currentChatImage = document.querySelector("#chatHead img")
            let currentChatName = document.querySelector("#chatHead h6")

            msgBox.addEventListener("click", getActiveMessage, false)
            function getActiveMessage(e) {
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
                let page_url = $.baseUrl + 'message/' + currentUser.username
                window.history.pushState('', "Personal Message View", page_url)
                $('#public_username').val(currentUser.username)
                $('#conversationId').val(currentUser.c_id)
                ConversationReplies()
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
    let searchBtn = document.querySelector("#msgColumn #msgSearch")
    searchBtn.onclick = function () {
        document.querySelector("#msgColumn .input").classList.toggle("d-none")
    }

     /*****************************************************************************
                                USER FRIENDS LIST BLOCK
        Note: This block is important because it will help use to choose from 
        their friend list if they don't have contact list
    *****************************************************************************/
    let firSearchBtn = document.querySelector("#friSearch")
    firSearchBtn.onclick = function (e) {
        document.querySelector(".friendSearchBox").classList.toggle("d-none")
        if(!$('.friendSearchBox').hasClass("d-none")){
            //Excute User Friend List
            $('#displayUserFriendsList').html('')
            // Network Class is under Networks/network, Please work on it so it can work same way as contactlist works
            let FriendsList = new Networks()
            FriendsList.UserNetworksForMessages()
        }
    }

}