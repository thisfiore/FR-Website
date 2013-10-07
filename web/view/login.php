<!doctype html>
<html lang="it">
<head>
	<meta charset="UTF-8">
	<title>Food Republic - Login</title>

    <link rel="stylesheet" href="../../public/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/main.css">
</head>
<body>
	
	<div class="container">
		<div class="row">
			<div class="span4 offset4 well">
				<legend>Log In</legend>
	          	<div class="alert alert-error">
	                <a class="close" data-dismiss="alert" href="#">×</a>Incorrect Username or Password!
	            </div>
				<form method="POST" action="" accept-charset="UTF-8">
				<input type="text" id="username" class="span4" name="username" placeholder="Username">
				<input type="password" id="password" class="span4" name="password" placeholder="Password">
	            <!-- <label class="checkbox">
	            	<input type="checkbox" name="remember" value="1"> Remember Me
	            </label> -->
				<button type="submit" name="submit" class="btn btn-info btn-block">Sign in</button>
				</form>    
			</div>
		</div>
	</div>

</body>
</html>