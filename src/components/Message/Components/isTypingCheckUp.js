import $ from "jquery";
import { AJYPost } from '../../../scripts/AjuwayaRequests'
let _ = require('underscore')

/*****************************************************************************
                            ALERT IF USER IS TYPING
*****************************************************************************/

export function isTypingCheckUp () {
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
