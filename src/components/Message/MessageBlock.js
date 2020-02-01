import { ConversationReplies } from './Components/ConversationReplies'
import { ConversationLists } from './Components/ConversationLists'
import { ReplyConversation } from './Components/ReplyConversation'
import { isTypingCheckUp } from './Components/isTypingCheckUp'

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
        
        /*****************************************************************************
                                    ALERT IF USER IS TYPING
        *****************************************************************************/
        isTypingCheckUp()        
    }

}

export default MessageBlock

