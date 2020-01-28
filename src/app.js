//import React from 'react';
//import ReactDOM from 'react-dom';
import $ from "jquery";

import { Login, conversationLists, conversationReplies, ReplyConversation } from './scripts/Ajuwaya'

class App {
    
    constructor(){
        //Ajuwaya Function Inits
        this.Init();
        console.log("testing");
    }

    /*****************************************************************************
                            INITIALIZE Ajuwaya FUNCTION
    *****************************************************************************/
    Init(){
        // API functions from './scripts/Ajuwaya'
        if($("#PAGE_TYPE").val() == "login"){
            Login();
        }else {
            conversationLists();
            conversationReplies();
            ReplyConversation();
        }
    }

    /*****************************************************************************
                            INITIALIZE React FUNCTION
                            #Start React function downward
    *****************************************************************************/



}

let app = new App();

//ReactDOM.render(<App />, document.getElementById('root'));

