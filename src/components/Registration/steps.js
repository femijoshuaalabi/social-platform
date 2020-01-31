export function stepOne(){
  $('.RegistrationStep').hide();
  let PageUrl = $('#BASE_URL').val() + 'asptract_pages/registration/stepOne.php';
  let containerBox = $('#RegistrationForm #stepOne');
  containerBox.show();
  containerBox.load(PageUrl, (response, status,xhr) => {
    if (status == 'success') {
      //Success
    }
  });
}

export function stepTwo() {
  $('.RegistrationStep').hide();
  let PageUrl = $('#BASE_URL').val() + 'asptract_pages/registration/stepTwo.php';
  let containerBox = $('#RegistrationForm #stepTwo');
  containerBox.show();
  containerBox.load(PageUrl, (response, status,xhr) => {
    if (status == 'success') {
      $('#displayTheEmail').html($('#remail').val())
      //This Function is used for auto focusing input fields
      var tokenInput = 'input.token-pin';
      $(tokenInput+':first').focus();
      $(tokenInput).keyup(function(e) {
        if ((e.which == 8 || e.which == 46)) {
          $(this).prev(tokenInput).focus().val($(this).prev().val());
        } else {
          if (this.value.length == this.maxLength) {
            $(this).next(tokenInput).focus();
          }
        }
      });
    }
  })
}

export function stepThree(){
  $('.RegistrationStep').hide();
  let PageUrl = $('#BASE_URL').val() + 'asptract_pages/registration/stepThree.php';
  let containerBox = $('#RegistrationForm #stepThree');
  containerBox.show();
  containerBox.load(PageUrl, (response, status,xhr) => {
    if (status == 'success') {
      //success
    }
  })
}

export function stepFour(){
  $('.RegistrationStep').hide();
  let PageUrl = $('#BASE_URL').val() + 'asptract_pages/registration/stepFour.php';
  let containerBox = $('#RegistrationForm #stepFour');
  containerBox.show();
  containerBox.load(PageUrl, (response, status,xhr) => {
    if (status == 'success') {
      $('#displayName').html($('#rname').val())
      $('#displayEmail').html($('#remail').val()) 
      $('#displayUsername').html($('#rusername').val())
      $('#displayWelcomeUsername').html($('#rusername').val())
    }
  })
}