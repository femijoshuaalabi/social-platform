import $ from "jquery";
import { AJYPost,AJYGet } from '../../scripts/AjuwayaRequests'
import { stepOne, stepTwo, stepThree, stepFour } from "./steps"

export class RegistrationForm {

  constructor(){
      this.handleSteps()
      this.initiator()
      //this.prevStep()
  }


  /*****************************************************************************
                        PREVIOUS STEP ACTION
                    NB: THIS BLOCK AS BEEN DEPRECIATED
  *****************************************************************************/
  prevStep = () => {
    $('body').on('click','#prev',() => {
      $('.RegistrationStep').hide();
      this.handleSteps()
    })
  };

  initiator = () => {
    /*****************************************************************************
		 					 		        CHECK IF EMAIL EXIST ON TYPING
		*****************************************************************************/
    $('body').on('change', '#remail', function() {
		    let email = $(this).val();
		    if (/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(email)) {

		        var url = $('#BASE_URL').val() + 'Aapi/usernameEmailCheck'; /* User singup API */
            let encodedata = {
                usernameEmail: email,
                type: "1"
            }

            AJYPost(url,encodedata).then((result) => {
              if (result.usernameEmailCheck.length) {
		                $('#remail').addClass('valid');
		                $('#remail').removeClass('is-invalid');
		                $('#remail').attr('aria-invalid','false');
		            } else {
		                $('#remail').addClass('is-invalid');
		                $('#remail').removeClass('valid');
		                $('#remail').attr('aria-invalid','true');
		            }
            })

		    } else {
		    	toastr.error("Opps, That's an invalid email");
		    }
		    return false;
    })

    /*****************************************************************************
		 					 		      CHECK IF USERNAME EXIST ON TYPING
		*****************************************************************************/

		$('body').on('change', '#rusername', function() {
      let username = $(this).val();
      if (/^[a-zA-Z0-9_-]{3,25}$/i.test(username)) {
        
        var url = $('#BASE_URL').val() + 'Aapi/usernameEmailCheck'; /* User singup API */
        let encodedata = {
            usernameEmail: username,
            type: "0"
        }
        AJYPost(url,encodedata).then((result) => {
          if (result.usernameEmailCheck.length) {
              $('#rusername').addClass('valid')
              $('#rusername').removeClass('is-invalid')
              $('#rusername').attr('aria-invalid','false')
          } else {
              $('#rusername').addClass('is-invalid')
              $('#rusername').removeClass('valid')
              $('#rusername').attr('aria-invalid','true')
              toastr.error("Opps, Username Taken")
          }
        })
      } else {
        $('#rusername').addClass('is-invalid')
        toastr.error("Opps, That's an invalid username")
      }
      return false
    })

    /*****************************************************************************
		 					 		              SEND CODE TO EMAIL  
		*****************************************************************************/
    $('body').on('click', '#send_code_to_mail', () => {
      $('#send_code_to_mail').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Please Wait...').addClass('disabled');
			setTimeout(function(){
				let email = $('#remail').val();
			    if (/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(email)) {
			        let encodedata = {
                  usernameEmail: email,
                  type: "1"
              }

			        if(!$('#remail').hasClass('is-invalid')){
			        	var url = $('#BASE_URL').val() + 'Aapi/send_code_to_mail'; /* User singup API */
                 AJYPost(url,encodedata).then((result) => {
                    if (result.usernameEmailCheck.length) {
                        stepTwo()
			                } else {
			                    $('#remail').addClass('invalid');
			                    $('#remail').attr('aria-invalid','true');
			                    $('#send_code_to_mail').html('Confirm').removeClass('disabled');
			                }
                 })
			        }else{
				    	$('#remail').addClass('invalid');
				    	$('#send_code_to_mail').html('Confirm').removeClass('disabled');
			        }

			    } else {
			    	$('#remail').addClass('invalid');
			    	$('#send_code_to_mail').html('Confirm').removeClass('disabled');
          }
          
      },500);
		  return false;
    })

    /*****************************************************************************
		 					 		          VALIDATE CODE SENT TO MAIL  
		*****************************************************************************/

		$('body').on('click', '#ValidateEmailWithPin', function() {
			$('#ValidateEmailWithPin').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Please Wait...').addClass('disabled');

			setTimeout(function(){
				  var email = $('#remail').val();

			    var pin1 = $('#pin_one').val();
			    var pin2 = $('#pin_two').val();
			    var pin3 = $('#pin_three').val();
			    var pin4 = $('#pin_four').val();

			    var pin = pin1+pin2+pin3+pin4;

			    if (/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(email)) {

              let encodedata = {
                usernameEmail: email,
                type: "1",
                pin: pin
              }

              var url = $('#BASE_URL').val() + 'Aapi/ValidateEmailWithPin'; /* User singup API */
              AJYPost(url,encodedata).then((result) => {
                if (result.usernameEmailCheck.length) {
                  stepThree()
                } else {
                    $('#pin1').addClass('invalid');
                    $('#pin1').attr('aria-invalid','true'); 
                    toastr.error('Verification!', 'You have provided invalid Pin');
                    $('#ValidateEmailWithPin').html('Confirm').removeClass('disabled');
                }
              })
			    } else {
			        toastr.error("Something Unknown just occured, please reflesh the page");
			        $('#ValidateEmailWithPin').html('Confirm').removeClass('disabled');
			    }
			}, 500);
		    return false;
    })
    
    /*****************************************************************************
		 					 		            ACCOUNT INFORMATION CHECKUP
		*****************************************************************************/

		$('body').on('click', '#submit-accout-info', function() {
			$('#submit-accout-info').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Please Wait...').addClass('disabled');

			setTimeout(function(){
				let password = $('#reg_password').val();
        let comfirm_password = $('#cpassword').val();
        let name = $('#rname').val();

        if(name != '' && !$('#rusername').hasClass('is-invalid')) {
          if(password != '' || comfirm_password != ''){
            if(password != comfirm_password){
              $('#reg_password').addClass('invalid')
              $('#cpassword').addClass('invalid')
              $('.password_errorInfo').show()
              $('#submit-accout-info').html('Confirm').removeClass('disabled')
            }else {
              $('#displayName').html($('#rname').val())
              $('#displayEmail').html($('#remail').val()) 
              $('#displayUsername').html($('#rusername').val())
              $('#displayWelcomeUsername').html($('#rusername').val())
  
              stepFour()
            }
          }else {
            $('#reg_password').addClass('invalid')
            $('#cpassword').addClass('invalid')
            $('.password_errorInfo').show()
            $('#submit-accout-info').html('Confirm').removeClass('disabled')
          }
        }else {
          toastr.error("All fields are required");
          $('#submit-accout-info').html('Confirm').removeClass('disabled')
        }
			}, 500)	    
		    return false
    })
    
    /*****************************************************************************
		 					 		          SIGN UP / REGISTER BUTTON
		*****************************************************************************/
		$('body').on('click', '#signupButton', function() {
			$('#signupButton').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Please Wait...').addClass('disabled');
			if($('#displayEmail').html() != ''){
          let username = $('#rusername').val();
          let password = $('#reg_password').val();
          let email = $('#remail').val();
          let name = $('#rname').val();

          let encodedata = {
            username: username,
            password: password,
            email: email,
            name: name
          }

          var url = $('#BASE_URL').val() + 'Aapi/signup'; /* User singup API */
          AJYPost(url,encodedata).then((result) => {
            if (result.signup.length) {
              let data=result.signup[0];
              let cdata=data.configurations[0];
              console.log(data);
              let url= $('#BASE_URL').val()+'public/authentication_register.php?uid='+data.uid+
              '&notification_created='+data.notification_created+'&token='+data.token+
              '&name='+data.name+'&username='+data.username+'&pic='+data.profile_pic+
              '&newsfeedPerPage='+cdata.newsfeedPerPage+'&friendsPerPage='+cdata.friendsPerPage+
              '&photosPerPage='+cdata.photosPerPage+'&groupsPerPage='+cdata.groupsPerPage+
              '&notificationPerPage='+cdata.notificationPerPage+'&friendsWidgetPerPage='+cdata.friendsWidgetPerPage+'&tour='+data.tour;
              window.location.replace(url);
            }else {
              $('#sign-up-error').show();
            }
          })
      }else {
        $('#sign-up-error').show().html('Invalid information detected please enter valid information');
      }

      return false;
	  });

  }

  /*****************************************************************************
                            INITIATE THE FIRST STAGE
  *****************************************************************************/
  handleSteps = () => {
      stepOne()
  }


}

export default RegistrationForm

