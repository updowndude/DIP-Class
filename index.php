<?php
	session_start();
	//reset session id to help prevent session hijacking

	include 'php/includes/functions.php';
	include 'php/includes/session_hijacking.php';

	after_successful_login();

	request_is_same_domain();
	ini_set('display_errors',0);

	//if login form submitted
	if(isset($_POST['login'])){
		//create variables and sanitise input
		$formUsername=validateFormData($_POST['username']);
		$formPass=validateFormData($_POST['password']);
		
		//connect to database
		require 'php/includes/connection.php';
		
		//create query
		$query="
		SELECT Username, Password FROM Users WHERE Username='$formUsername'";
		
		//store result
		$result=mysqli_query($conn, $query);
		
		//verify that result is returned (does user exist?)
		if(mysqli_num_rows($result)>0){
			
			//store basic user data in variables
			while($row=mysqli_fetch_assoc($result)){
				$name=$row['Username'];
				$hashedPass=$row['Password'];
			}
		
			//verified hashed password against submitted password
			if(password_verify($formPass,$hashedPass)){
				//login credentials are valid
				//data stored in session variables
				$_SESSION['loggedInUser']=$name;

				if($name == 'maingateadmin') {
                    //redirect user to contacts page
                    header('Location: admin');
                } else {
                    //redirect user to contacts page
                    header('Location: lookup');
                }

			//hashed password not verified
			}else{
				//error message
				$loginError="<div class='alert alert-danger' id='myAlert'>Incorrect username/password combination. Check your username and password.</div>";
			}//data return verification
	
		//user does not exist
		}else{
		//error message
		    $loginError="<div class='alert alert-danger' id='myAlert'>Incorrect username. Are you registered?</div>";
		}//
	}//if login form submitted

	//mysqli_close($conn);
?>
    <!DOCTYPE html>

    <html>

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="theme-color" content="#ff8080">
        <link rel="manifest" href="manifest.json">
        <meta charset="utf-8">

        <title>Main Gate</title>

        <link rel="icon" href="">

        <link rel="icon", type="image/x-icon", href="images/favicon.ico">
        <!--customer styles-->
        <link rel="stylesheet" type="text/css" href="dist/myStyle.css" />


    </head>

<body id="IndexPage" class="body-style-light">

<div class="container"><!--begin container-->


<div class="text-center">
	<img src="images/Fire.png" alt="Logo" width="250px" height="250px">
</div><br><br>


<form class="form-inline text-center" action="home" method="post">
	<div class="form-group">
		<label for="login-username" class="sr-only">Username</label>
		<input type="text" class="form-control input-lg" id="login-username" placeholder="username" name="username" value="<?php echo $formUsername; ?>">
	</div>
	<div class="form-group">
		<label for="login-password" class="sr-only">Password</label>
		<input type="password" class="form-control input-lg" id="login-password" placeholder="password" name="password" value="<?php echo $formPass; ?>">
	</div><br><br>
	<button type="submit" class="btn btn-info btn-lg" name="login">Login</button>
</form>
    <?php
        // check to see there a login error
        if (isset($loginError) == true) {
            // display the login erro
            echo $loginError;
        }
    ?>
<!--echo password_hash("maingate", PASSWORD_DEFAULT);-->
	
<?php
	//footer
	require 'php/includes/footer.php';
?>