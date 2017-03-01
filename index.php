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
		include 'php/includes/connection.php';
		
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

				//redirect user to contacts page
				header('Location: php/view/lookup');

			//hashed password not verified
			}else{
				//error message
				$loginError="<div class='alert alert-danger'>Incorrect username/password combination. Check your username and password.<a class='close' data-dismiss='alert'>&times;</a></div>";
			}//data return verification
	
		//user does not exist
		}else{
		//error message
		$loginError="<div class='alert alert-danger'>Incorrect username. Are you registered?<a class='close' data-dismiss='alert'>&times;</a></div>";
		}//
	}//if login form submitted

	//mysqli_close($conn);

	//header
	include 'php/includes/no-nav-header.php';
?>

<div class="text-center">
	<img src="images/Fire.png" width="250px" height="250px">
</div><br><br>


<form class="form-inline text-center" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
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

<!--echo password_hash("maingate", PASSWORD_DEFAULT);-->
	
<?php
	//footer
	include 'php/includes/footer.php';
?>