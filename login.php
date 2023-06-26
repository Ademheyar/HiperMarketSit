
<?php 

@include 'config.php';
if(isset($_POST['login_btn'])){
	$message[] = 'there is info';
	$username = $_POST['login_name'];
	$userpassword = $_POST['login_password'];
	if(!empty($username) && !empty($userpassword)){
		$select_user = mysqli_query($conn, "SELECT * FROM `users`");
		if(mysqli_num_rows($select_user) > 0){
			$userfound = 0;
			while($u = mysqli_fetch_assoc($select_user)){
				if($u['user_name'] == $username){
					if($u['user_password']  == $userpassword){
						if(session_id() == "") session_start();
						$_SESSION['loged_user_name'] = $u['user_name'];
						$_SESSION['loged_user_password'] = $u['user_password'];
						if($u['user_state'] == 'Main') $_SESSION['loged_user_type'] = 1;
						elseif($u['user_state'] == 'Admin') $_SESSION['loged_user_type'] = 2;
						else $_SESSION['loged_user_type'] = 3;
						echo "loged in sucessfully (". $_SESSION['loged_user_type']. ", ". $_SESSION['loged_user_name']. ")";
						//TODO REFRECH THE PAGE 
					}
					else echo "name or password incorract";
					$userfound = 1;
				}
			}
			if($userfound == 0) echo "there is no user called ". $username;
		}
		else echo "there is no user";
	}
	else {
		echo "name or password most not be empty";
	}	
}
elseif(isset($_POST['register_btn'])){
	$fname = filter_input(INPUT_POST, 'register_fname');
	$lname = filter_input(INPUT_POST, 'register_lname');
	$email = filter_input(INPUT_POST, 'register_Email');
	$password = filter_input(INPUT_POST, 'register_password');
	$cpassword = filter_input(INPUT_POST, 'register_cpassword');

	if (!empty($fname) && !empty($lname) && !empty($email)){
		if (!empty($password) == !empty($cpassword)){
			echo "register sucessfully ". $fname.  " " .$lname. " ". $email. " " .$password. " ". $cpassword;
			$newname = $fname. " ". $lname;
			$sql = "INSERT INTO users (user_name, user_password, user_fname, user_lname, user_state) value ('$newname', '$password', '$fname','$lname', 'User')";
			if ($conn->query($sql)){
				echo "new user is inserted sucessfully";
			}
			else echo "Error: ".$sql ."<br>". $conn->error;
		}
		else echo "password are not same!";
		//", user_state, user_shop_id, user_shop_name"
	}
}
?>
<!-- creating the form-box -->
<div id='login-form' class='form-box'>
	<div class='button-box'>
		<div id='btn'></div>
		<button type='button'onclick='login()'class='toggle-btn'>Log In</button>
		<button type='button'onclick='register()'class='toggle-btn'>Register</button>            
	</div>
	<div>
		<!-- creating the login form -->
		<form id='login' class='input-group-login' method="POST">
			<input type='text'class='input-filed'placeholder='Email Id'name="login_name"required>
			<input type='text'class='input-filed'placeholder='Enter Password'name="login_password"required>
			<input type='checkbox'class='check-box'><span>Remember Password</span>
			<input  href="Home.php" type='submit'class='submit-btn' name="login_btn">Log in</input>
		</form> 
		<!-- creating the registration form -->
		<form id='register' class='input-group-register' method="POST">
				<input type='text'class='input-filed'placeholder='First Name'name="register_fname"required>
				<input type='text'class='input-filed'placeholder='Last Name'name="register_lname"required>
				<input type='email'class='input-filed'placeholder='Email Id'name="register_Email"required>
				<input type='password'class='input-filed'placeholder='Enter Password'name="register_password"required>
				<input type='password'class='input-filed'placeholder='Congirm Password'name="register_cpassword"required>
				<input type='checkbox'class='check-box'><span>I agree to the terms and conditions</span>
				<button type='submit'class='submit-btn' name="register_btn">Register</button>
		</form> 
	</div>
</div>

<!-- the first script code is for login and registration form to move correctly-->
<script>
	var x=document.getElementById('login');
	var y=document.getElementById('register');
	var z=document.getElementById('btn');
	var modal =document.getElementById('login-form');
	
	function register()
	{
		x.style.left='-400px';
		y.style.left='50px';
		z.style.left='210px';
		modal.style.height= '350px';
	}

	function login()
	{
		x.style.left='50px';
		y.style.left='450px';
		z.style.left='41px';
		modal.style.height= '200px';
	}

	// this is for the when you click out the login or registration page the form -box disappears 
	window.onclick = function(event)
	{
		if (event.target == modal)
		{
		   modal.style.display = "none";
		}
	}

	function log_in_out()
	{
		var mainy = 22;
		var sy = scrollY;
        var y = sy + mainy;
        var l = document.querySelector('#login-form');
   		l.style.top = y + 'rem';
        document.getElementById('login-form').style.display='block';
        document.getElementById('shopping-cart-form').style.display='none'; 
        document.getElementById('view-form').style.display='none'; 
	}   

  
	window.onscroll = () => {
        var mainy = 200;
        var sy = scrollY; 
   		var sy = scrollY; 
   		var y = mainy + sy;
   		var a = document.querySelector('body .Main');
		var ya  = y + a.scrollTop + 200
		document.getElementById('view-form').style.top = ya + 'px';
        var l = document.querySelector('#login-form');
   		l.style.top = ya + 'rem';
        document.querySelector('#shopping-cart-form').style.top = y + 'px';
        menu.classList.remove('fa-times');
        navbar.classList.remove('active');
    };
</script>

<style>
.form-box {
    width: 380px;
    height: 200px;
    position: absolute;
    margin: 2% auto;
    background: rgba(0,0,0,.3);
    padding: 12px;
    right: 1%;
    overflow: hidden;
	display: none;
 }
 
 .form-box .toggle-btn {
    padding: 7px 63px;
    cursor: pointer;
    background: transparent;
    border: 0;
    outline: none;
    position: relative;
 }
 
 #btn {
    top: 0; left: 41px;
    position: absolute;
    width: 110px;
    height: 50px;
    background: #f3c693;
    border-radius: 30px;
    transition: .5s;
 }
 
 span {
    color: #f5f5f5;
    font-size: 25px;
    bottom: 69px;
    position: absolute;
 }
 
 
 .input-group-login ,
 .input-group-register{
	top: 65px;
    position: absolute;
    width: 225px;
    transition: .5s;
 }
 
 #login {
    left: 50px;
 }
 
 #login input ,
 #register input{
	color: black;
    padding: 1rem 1rem;
    border-radius: 0.5rem;
    border-radius: 1.5rem;
    margin: 0.5rem 0;
 }
 
 #register {
    left: 480px;
 }
 
 .form-box .submit-btn {
    width: 85%;
    padding: 10px 30px;
    cursor: pointer;
    display: block;
    margin: auto;
    background: #f3c693;
    border: 0;
    outline: none;
    border-radius: 30px;
 }


</style>