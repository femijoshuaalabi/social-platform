import React, { Component } from 'react';

export class Email extends Component {
  continue = e => {
    e.preventDefault();
    this.props.nextStep();
  };

  render() {
    const { values, handleChange } = this.props;
    return (
       <div>
      
       </div>
    );
  }
}

export default Email;
