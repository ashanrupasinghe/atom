//
//	jQuery Validate example script
//
//	Prepared by David Cochran
//
//	Free for your use -- No warranties, no guarantees!
//
            $.validator.addMethod(
                'nic', function(value) {
                    return /^[0-9]{9}[vVxX]{1}/.test(value);
                }, 'Please enter a valid NIC.');
                
                
$(document).ready(function(){

	// Validate
	// http://bassistance.de/jquery-plugins/jquery-plugin-validation/
	// http://docs.jquery.com/Plugins/Validation/
	// http://docs.jquery.com/Plugins/Validation/validate#toptions

		$('#contact-form').validate({
        onkeyup: function (element, event) {
            if (event.which === 9 && this.elementValue(element) === "") {
                return;
            } else {
                this.element(element);
            }
        },
       
	    rules: {
	      name: {
	        minlength: 2,
	        required: true
	      },
              nameIn:{
                minlength: 2,
	        required: true 
              },
	      email: {
	        required: true,
	        email: true
	      },
	      subject: {
	      	minlength: 2,
	        required: true
	      },
	      message: {
	        minlength: 2,
	        required: true
	      },
              alYear:{
                  required: true
              },
              acadamicYear:{

                  required: true
              },
              series:{

                  required: true
              },
              mobile2:{
                  number:true,
                  minlength:10,
                  maxlength:10,
                  required: true
              },
               noOfBooks:{
                   max:1000,
                   min:1,
                  number:true,
                  required: true
              },
              thome:{
                  number:true,
                  minlength:10,
                  maxlength:10,
                  required: true
              },
              nic1:{
                  
                  minlength:10,
                  maxlength:10,
                  nic:true,
                  //required: true
              },
              university:{
                  required: true
              },
              agentName:{
                  required: true
              }
             
	    },
			highlight: function(element) {
				$(element).closest('.control-group').removeClass('success').addClass('error');
			},
			success: function(element) {
				element
				.text('OK!').addClass('valid')
				.closest('.control-group').removeClass('error').addClass('success');
			}
	  });

}); // end document.ready