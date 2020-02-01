import { istypingStatus } from './asptract/istypingStatus'
import { istypingStatusRemove } from './asptract/istypingStatusRemove'
import { istypingStatusUpdate } from './asptract/istypingStatusUpdate'
let _ = require('underscore')

/*****************************************************************************
                            ALERT IF USER IS TYPING
*****************************************************************************/

export function isTypingCheckUp () {

    var typing, typingStarted, typingStopped
    typing = false

    typingStopped = _.debounce((function() {
        if (!typing) {
            return
        }
        typing = false;
        //console.log('typing is done');
        istypingStatusRemove()
    }), 2000);

    typingStarted = function() {
        if (typing) {
            return
        }
        typing = true;
        //console.log('typing has started');
        istypingStatus()
    };

    document.querySelector("#conversationReply").oninput = function(event) {
        typingStarted()
        typingStopped()
        return
    }

    /*****************************************************************************
                                IS TYPING UPDATE INIT: 3secs
    *****************************************************************************/
   setInterval(() => {
    istypingStatusUpdate()
   },3000)

}


