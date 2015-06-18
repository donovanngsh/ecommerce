$(document)
  .foundation({
    abide : {
      patterns: {
        dashes_only: /[a-zA-Z0-9]+/
      }
    }
  });

$(document).ready(function() {
    // mailing list upon submit
    $('#mailinglist').submit(function(event) {

    // Serialize the form data.
    var formData = {
    'name'  : $('input[name=name]').val(),
    'email' : $('input[name=email]').val()
    };
    
    // Submit the form using AJAX.
    $.ajax({
       type: 'POST',
       url: './functions/mailing_list/mailing_list.php',
       data: formData,
       dataType: 'json',
       encode: true
       })
    .done(function(data) {
    console.log(data);
    alert("Thank you for subscribing to Nogollas.");
    })
    .fail(function(data) {
    console.log(data);
    });
    event.preventDefault();
    });
});

function ajaxrequest(id){
	var req = new Request.HTML({
		method: 'get',
		url: 'display.php?id='+id,
		update: $('thumbnail')				
	}).send();		
}