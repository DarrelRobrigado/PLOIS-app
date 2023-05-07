<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>

	
	<title>Sign Up and Sign In</title>
    </head>
    <body>
	
	
	@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="col-md-10 col-lg-8 mx-auto">
            <div class="d-flex align-items-center justify-content-between">
                <div>{{ session('success') }}</div>
                <a href="#" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
        </div>
    </div>
@endif


<div class="container" id="container">


	<div class="form-container sign-up-container">
		
		<form method="POST" action="{{ url('/signin')}}">
        @csrf

			<h1>Create Account</h1>
			<div class="social-container">
                <a href="#" class="social" onclick="fbLogin()"><img src="{{ asset('img/facebook.png') }}" alt="Google" class="facebook-img"></a>
				<a href="#" class="social"><img src="{{ asset('img/google.png') }}" alt="Google" class="google-img"></a>

			</div>
			<span>or use your email for registration</span>
			<input type="text" placeholder="name" name="name" id="name" required/>
			<input type="email" placeholder="email" name="email" id="email" required/>
			<input type="password" placeholder="password" name="password" id="password" required />
			<input type="password" placeholder="confirm password" name="password_confirmation" id="password_confirmation" required />
			<button>Sign Up</button>
		</form>
	</div>
	<div class="form-container sign-in-container">
	






	<form method="POST" action="{{ url('/login')}}">
	@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>{{ session('success') }}</div>
                        <a href="#" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif


	@csrf
			<h1>Sign in</h1>


			<div class="social-container">
				<a href="#" class="social" onclick="fbLogin()"><img src="{{ asset('img/facebook.png') }}" alt="Google" class="facebook-img"></a>
				<a href="#" class="social"><img src="{{ asset('img/google.png') }}" alt="Google" class="google-img"></a>

			</div>
			
			<span>or use your account</span>
			<input type="email" placeholder="Email" name="email" id="email"/>
			<input type="password" placeholder="Password"  name="password" id="password"/>
			<a href="#">Forgot your password?</a>
			<button>Sign In</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Have an Account? Login Now!</h1>
				<p>To keep connected with us please login with your personal info</p>
				<button class="ghost" id="signIn">Sign In</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Create Your Account Here!</h1>
				<p>Enter your personal details and start your journey with us</p>
				<button class="ghost" id="signUp">Sign Up</button>
			</div>
		</div>
	</div>
</div>
</body>

<footer>
	
</footer>
<script src="{{ asset('js/script.js') }}"></script>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '214285901332902',
      cookie     : true,
      xfbml      : true,
      version    : 'v11.0'
    });
      
    FB.AppEvents.logPageView();   
      
  };
  
  function fbLogin() {
  FB.login(function(response) {
    if (response.authResponse) {
      console.log('Welcome!  Fetching your information.... ');
      FB.api('/me?fields=name,email', function(response) {
        console.log('Good to see you, ' + response.name + '.');
        console.log('Your email is: ' + response.email);
      });
    } else {
      console.log('User cancelled login or did not fully authorize.');
    }
  }, {scope: 'email'});
}

$(document).ready(function(){
  $(".alert-dismissible .close").click(function(){
    $(".alert-dismissible").alert("close");
  });
});
</script>


</html>