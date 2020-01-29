import $ from "jquery";
import Email from './Registration/Email';

export class RegistrationForm {

  constructor(){
      $.step = 1;
      this.nextStep();
  }

  nextStep = () => {
    console.log($.step);
  };

}

export default RegistrationForm;

