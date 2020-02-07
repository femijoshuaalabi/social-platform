import $ from "jquery"
import { AJYPost } from '../../scripts/AjuwayaRequests'

import { ConversationReplies } from '../Message/Components/ConversationReplies'
import { isTypingCheckUp } from '../Message/Components/isTypingCheckUp'
import { UserLastSeenUpdate } from '../onlineStatus'
import { conversationNewReplies } from '../Message/Components/conversationNewReplies'

export class Networks {

    constructor(){
        //this.initiator()
    }


    /*****************************************************************************
                THIS METHOD IS USED ON  MESSAGE CONTACT LIST SEARCH
    *****************************************************************************/

    UserNetworksForMessages = () => {

        if(!$('#search_list_box').hasClass('BoxOnceOpened')) {
            const uid = $('#uid').val()
            const token = $('#token').val()
            const username = $('#username').val()
            let rowsPerPage = 8;

            const encodedata = {
                uid: uid,
                token: token,
                rowsPerPage: rowsPerPage
            }

            $.baseUrl = $('#BASE_URL').val()
            let apiBaseUrl = $.baseUrl + 'Aapi/friendsList'

            AJYPost(apiBaseUrl, encodedata).then((result) => {
                if (result.friendsList.length) {
                    $.each(result.friendsList, function(i, data) {
                        const friendsList = `
                                <div id="${ data.uid }" key="${ data.uid }" class="msgList row no-gutters flex-nowrap align-items-center p-1">
                                    <div>
                                        <img src="${ data.profile_pic }" alt="${ data.username }" class="rounded">
                                    </div>
                                    <div class="py-1 pl-2 flex-grow-1" style="max-width:85%;">
                                        <div class="row no-gutters flex-nowrap justify-content-between align-items-center">
                                            <h6 class="mb-1 font-weight-bolder text-truncate" style="max-width:60%;">${ data.name }</h6>
                                    </div>
                                        <p class="small my-0 text-muted text-truncate pr-2">
                                        ${ data.status }
                                        </p>
                                    </div> 
                                </div>
                                <hr class="my-3">
                        `
                        let msgBox = document.getElementById('search_list_box')
                        msgBox.innerHTML += friendsList
                    })

                    /*****************************************************************************
                                            SEARCH BUTTON CONVERSATION
                    *****************************************************************************/
                
                    let msgColumn = document.getElementById("msgColumn")
                    let chatColumn = document.getElementById("chatColumn")
                    let returnBtn = document.querySelector("#chatColumn #return")
                    let placeHolder = document.querySelector("#chatColumn .placeHolder")
                    let placeOwner = document.querySelector("#chatColumn .placeOwner")
                    let currentChatImage = document.querySelector("#chatHead img")
                    let currentChatName = document.querySelector("#chatHead h6")

                    msgBox.addEventListener("click", getActiveMessage, false)

                    function getActiveMessage(e) {
        
                        if (placeOwner.classList.contains("d-none"))
                        {
                            placeOwner.classList.remove("d-none")
                            placeHolder.parentNode.removeChild(placeHolder)
                        }
                        var currentUser = result.friendsList.find(function (item) {
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

                    /*****************************************************************************
                                            SEARCH BUTTON CONVERSATION
                    *****************************************************************************/
        

                }
            })

        }

    }

}

export default Networks

