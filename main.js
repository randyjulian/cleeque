$(document).load(function(){
	$(".loaderGIF").fadeOut(fast);
})



$(document).ready(function(){
	console.log("I'm ready!");
	var width= 100;
	var animationSpeed=500;
	var pausePeriod= 3000;
	var currentSlide=1;
	var $slideContainer = $('.main').find('.slider');
	var $slides = $('.slider').find('.slide');
	var $sliderController = $('.slider').find('.sliderController');
	var $sliderSymbols = $sliderController.find('.p'); 
	var $dotContainer = $('.navdot ul').find('li');
	var interval;
	var sliding = function() {
		interval = setInterval(function(){
			console.log("I'm changing now!");
			$slideContainer.animate({'margin-left':'-='+width+'%'},animationSpeed,function(){
				$dotContainer.removeClass("active");
				console.log(currentSlide);
				currentSlide++;
				if(currentSlide==$slides.length){
					currentSlide=1;
					$slideContainer.css('margin-left',0);
					$('#dot1').addClass("active");
				} else {
					$('#dot'+currentSlide).addClass("active");
				}
			});
				
		},pausePeriod);
	};

	sliding();
	//when mouse enters, sliding stops. When mouse leaves, sliding continues.
	$('.slider').mouseenter(function(){
		console.log("enter!");
		$sliderController.css('opacity','0.2');
		clearInterval(interval);
	});
	$('.slider').mouseleave(function(){
		console.log("leave!");
		$sliderController.css('opacity','0');
		sliding();
	})
	//Functions for the left/right arrow to change the slide;
	$('#slideBack').click(function(){
		currentSlide--;
		if(currentSlide==0){
			$slideContainer.css('margin-left','-200%');
			currentSlide=2;
		}
		$slideContainer.animate({'margin-left':'+='+width+'%'},animationSpeed);
		$dotContainer.removeClass("active");
		$("#dot"+currentSlide).addClass("active");
	});

	$('#slideNext').click(function(){
		$slideContainer.animate({'margin-left':'-='+width+'%'},animationSpeed,function(){
			currentSlide++;
			$dotContainer.removeClass("active");
			if(currentSlide==$slides.length){
				currentSlide=1;
				$slideContainer.css('margin-left',0);
				$('#dot1').addClass("active");
			} else {
				$('#dot'+currentSlide).addClass("active");
			}
		});
	});

	$dotContainer.click(function(){
		$dotContainer.removeClass("active");
		$(this).addClass("active");
		currentSlide= $dotContainer.index(this);
		console.log(currentSlide);
		$slideContainer.animate({'margin-left': (-((currentSlide+1)*100)+100)+'%'},animationSpeed);
		if(currentSlide==0){
			currentSlide=1;
		} else {
			currentSlide=2;
		}
	})

	//For modal
	var btn = document.getElementById('login');
	var modal=document.getElementsByClassName('modal');
	var close=document.getElementsByClassName('close');

	$('#login').click(function(){
		console.log('in');
		$('.modal').css('display','block');
	});
	
	$('.close').click(function(){
		//$('.modal').css('display','none');
		$('.modal').fadeOut(200);
	});

	//For Login Ajax Request
	$('#loginButton').click(function(event){
		event.preventDefault();
		$('#errorMessage').text("");
		var dataObject= {};
		var error=false;
		dataObject['username']= $('#username').val();
		dataObject['password']= $('#password').val();
		console.log(dataObject);
		if(dataObject['username']==""){
			$('#errorMessage').html("Please fill in username <br>");
			error=true;
			$('#password').val("");
			$('#username').addClass("inputEmpty");
			$('#loginButton').css("margin-top","0");
		}
		if(dataObject['password']==""){
			$('#errorMessage').append("Please fill in password");
			error=true;
			$('#password').addClass("inputEmpty");
			$('#loginButton').css("margin-top","0");
		}

		//If there are no errors, ajax request will be executed.
		if( error==false){
			$.ajax({
			url: 'loginProcessing.php',
			type: 'POST',
			data: dataObject,
			dataType: 'text',
			beforeSend: function(){$("#errorMessage").text("Connecting...");},
			success: function(response){
				var obj = JSON.parse(response);
				console.log(obj.message);
				if(obj.message=='ok'){
					window.location.href="loginPage.php";
					$_SESSION['username']=dataObject['username'];
				} else {
					$("#errorMessage").text(obj.message);
					//$('#username').val("");
					$('#password').val("");
				}
			},
			error: function(response, status,thrown){
				$("#errorMessage").text("Error! Please try again later. If the problem persists, please contact us!");
				
			}
		});
		}

		$('#username').focus(function(){
			$(this).removeClass("inputEmpty");
		})

		$('#password').focus(function(){
			$(this).removeClass("inputEmpty");
		})
	});

	//For responsive Nav Bar (Three line menu drop down when resizing window)
	$('#responsiveNavButton').click(function(){
		$('.mainMenu').toggleClass("responsive",200);
	});

	$('body').not('#responsiveNavButton').click(function(){
		console.log(this);
	})


	//drag-and-drop
	$('#uploadBox').on('change', function(e){
		console.log(e);
		$('form').trigger('submit');
	});
	
	$('.groupName').on('click',function(e){
		var groupNameForm = document.getElementById('choosingMember');
		$(this).prev().attr('checked','checked');
		$('#submitChosenGroup').trigger('click');
	});

	//clicking logo to go home
	$('#logo, #cleeque').click(function(){
		window.location="index.php";
	});

	$('.groupPeopleDep').click(function(){
		$(this).toggleClass('selected');
	});


});
