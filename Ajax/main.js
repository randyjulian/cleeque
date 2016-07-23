$(function(){
	$('#login').click(function(){
		var dataObject= {};
		dataObject['username']= $('#username').val();
		dataObject['password']= $('#password').val();
		console.log(dataObject);
			$.ajax({
			url: 'test.php',
			type: "POST",
			data: dataObject,
			dataType: 'text',
			beforeSend: function(){$("#message").val("Connecting...");},
			success: function(response){
				console.log(response);
				/*if(response=="ok"){
					window.location.href="dashboard.php";
					alert("in");
				} else {
					$("#message").val("Error!");
					alert("error!");
				}*/
			},
			error: function(){
				console.log("oh man!")
			}
		});


	});


});