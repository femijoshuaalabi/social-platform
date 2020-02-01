import $ from "jquery"
import { ConversationReplies } from './Components/ConversationReplies'
import { ConversationLists } from './Components/ConversationLists'
import { ReplyConversation } from './Components/ReplyConversation'

export class MessageBlock {

    constructor(){
        this.initiator()
    }


    initiator = () => {

        /*****************************************************************************
                                    USER CONTACT LIST
        *****************************************************************************/
        window.addEventListener('load',  ConversationLists(), false)

        /*****************************************************************************
                               DISPLAY CONVERSATION BLOCK
        *****************************************************************************/
        ConversationReplies()

        /*****************************************************************************
                                USER REPLY TO MESSAGES
        *****************************************************************************/
        const sendButton = document.querySelector('#sendButton')
        sendButton.addEventListener("click", () => {
            ReplyConversation()
        }, false)
               
    }

}

export default MessageBlock

