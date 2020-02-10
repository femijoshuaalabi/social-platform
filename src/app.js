//import React from 'react';
//import ReactDOM from 'react-dom';
import $ from "jquery"
import { AjuwayaSeperator } from './scripts/Ajuwaya'
require('es6-promise').polyfill();
require('isomorphic-fetch');

class App {


    constructor () {
        /*****************************************************************************
                                Ajuwaya Function Inits
        *****************************************************************************/

        this.Init()
        console.log("Ajuwaya working...")
    }

    /*****************************************************************************
                            INITIALIZE Ajuwaya FUNCTION
    *****************************************************************************/

    Init() {

        /*****************************************************************************
                    AjuwayaSeperator Seperate Components for each Pages
        *****************************************************************************/
        AjuwayaSeperator()
    }

    /*****************************************************************************
                            INITIALIZE React FUNCTION
                            #Start React function downward
    *****************************************************************************/



}


let app = new App()
//ReactDOM.render(<App />, document.getElementById('root'));

