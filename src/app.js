//import React from 'react';
//import ReactDOM from 'react-dom';

import { Login,conversationLists } from './scripts/Ajuwaya'

class App {
    
    constructor(){
        //Ajuwaya Function Inits
        this.Init();
        console.log("Ajuwaya Module is working now");
    }

    /*****************************************************************************
                            INITIALIZE Ajuwaya FUNCTION
    *****************************************************************************/
    Init(){
        //Login Function
        Login();
        conversationLists();
    }

    /*****************************************************************************
                            INITIALIZE React FUNCTION
                            #Start React function downward
    *****************************************************************************/



}

let app = new App();

//ReactDOM.render(<App />, document.getElementById('root'));

