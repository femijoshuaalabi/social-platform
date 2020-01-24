import React from 'react';
import ReactDOM from 'react-dom';

import { WelcomeNote } from './scripts/Ajuwaya'

class App extends React.Component {
    constructor(){
        super()
        console.log(WelcomeNote('You are Welcome to Ajuwaya Connect'));
    }

    render(){
        return (<h1>Welcome to Ajuwaya Connect</h1>)
    }
}

//ReactDOM.render(<App />, document.getElementById('root'));

