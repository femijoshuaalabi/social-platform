import $ from "jquery"
import { ConversationReplies } from './Components/ConversationReplies'
import { ConversationLists } from './Components/ConversationLists' 
import { NewConversationList } from './Components/NewConversationList'
import { ReplyConversation } from './Components/ReplyConversation'
import { MediaUpload } from './Components/mediaUpload'

export class MessageBlock {

    constructor(){
        this.initiator()
    }


    initiator = () => {

        /*****************************************************************************
                                    USER CONTACT LIST
        *****************************************************************************/
        window.addEventListener('load',  ConversationLists(), false)
        setInterval(()=> {
            NewConversationList()
        },10000)

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


        let public_username = $('#public_username').val()
        let message_user = public_username

        /*****************************************************************************
                                    PAGE MODULE DECLARATION
        *****************************************************************************/

        //Media Upload
        MediaUpload()



               
    }

}

export default MessageBlock

