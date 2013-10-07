<!doctype html>
<html lang="it">
<head>
	<meta charset="UTF-8">
	<title>Food Republic - Login</title>

    <link rel="stylesheet" href="../../public/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/main.css">
</head>
<body>
	
	<img class="center" src="../../public/img/logo.png" />
	<div class="spacer"></div>
	<div class="container">
		<div class="row no-margin">
			<div class="span4 center well">
	          	<!-- <div class="alert alert-error">
	                <a class="close" data-dismiss="alert" href="#">×</a>Incorrect Username or Password!
	            </div> -->
				<form method="POST" action="" accept-charset="UTF-8">
				<input type="text" id="username" class="input-form" name="username" placeholder="Username">
				<input type="password" id="password" class="input-form" name="password" placeholder="Password">
	            <!-- <label class="checkbox">
	            	<input type="checkbox" name="remember" value="1"> Remember Me
	            </label> -->
				<button type="submit" name="submit" class="btn btn-danger btn-large btn-block">Entra</button>
				</form>    
			</div>
		</div>
	</div>

</body>
</html>