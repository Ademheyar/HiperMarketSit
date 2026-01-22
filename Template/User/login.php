<?php

  if(file_exists("config.php")) include("config.php");
  if(file_exists("../../config.php")) include("../../config.php");
if (isset($_POST['login_btn'])) {
    $message[] = 'there is info';
    $username = $_POST['login_name'];
    $userpassword = $_POST['login_password'];
    if (!empty($username) && !empty($userpassword)) {
        $select_user = mysqli_query($conn, "SELECT * FROM `users`");
        if (mysqli_num_rows($select_user) > 0) {
            $userfound = 0;
            while ($u = mysqli_fetch_assoc($select_user)) {
                if ($u['user_name'] == $username or $u['user_email'] == $username) {
                    if ($u['user_password'] == $userpassword) {
                        if (session_id() == "") session_start();
                        $_SESSION['loged_user_info'] = $u;
                        $_SESSION['User_Shops_info'] = json_decode($u['User_work_shop']);
                        $Shops = [];
                        for($usi = 0; $usi < count($_SESSION['User_Shops_info']); $usi++){
                          $shop_info = $_SESSION['User_Shops_info'][$usi];
                          $result = $conn->query("SELECT * FROM shops WHERE Shop_Id='$shop_info[0]' AND Shop_name='$shop_info[1]' AND Shop_brand_name='$shop_info[2]'");
                          if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
								$Shops[] = $row;
                            }
                          }
                        }
                        $_SESSION['User_Shops'] = $Shops;
                        
                        if ($u['user_type'] == 'Main') $_SESSION['loged_user_type'] = 1;
                        elseif ($u['user_type'] == 'Admin') $_SESSION['loged_user_type'] = 2;
                        else $_SESSION['loged_user_type'] = 3;
                        
                        echo "loged in sucessfully (". $_SESSION['loged_user_type']. ", ". $_SESSION['loged_user_name']. ")";
                        //TODO REFRECH THE PAGE
                    } else $_SESSION['msg'][] = "name or password incorract";
                    $userfound = 1;
                }
            }
            if ($userfound == 0) $_SESSION['msg'][] = "there is no user called ". $username;
        } else $_SESSION['msg'][] = "there is no user";
    } else {
        $_SESSION['msg'][] = "name or password most not be empty";
    }
    unset($_POST['login_btn']);
} elseif (isset($_POST['register_btn'])) {
    $user_fname = filter_input(INPUT_POST, 'register_fname');
    $user_lname = filter_input(INPUT_POST, 'register_lname');
    $user_name = filter_input(INPUT_POST, 'register_name');
    $user_gender = filter_input(INPUT_POST, 'register_gender');
    $user_country = filter_input(INPUT_POST, 'register_country');
    $user_phone_No = filter_input(INPUT_POST, 'register_phone_No');
    $user_email = filter_input(INPUT_POST, 'register_email');
    $user_address = filter_input(INPUT_POST, 'register_address');
    $user_home_No = filter_input(INPUT_POST, 'register_home_No');
    $user_ID_Pp_ID = filter_input(INPUT_POST, 'register_ID_Pp_ID');
    $user_postacode = filter_input(INPUT_POST, 'register_postacode');
    $user_password = filter_input(INPUT_POST, 'register_password');

    if (!empty($user_fname) && !empty($user_lname) && !empty($user_email)) {
        if (!empty($user_password)) {
            // use $user_address to fill user addres phone number and other contacts
            # User_work_shop will be empty list
            $newusershop = json_encode([]);
            $sql = "INSERT INTO users (`user_fname`, `user_lname`, `user_name`, `user_gender`, `user_country`, `user_phone_No`, `user_email`, `user_contact`, `user_home_No`, `user_ID_Pp_ID`, `user_postacode`, `user_password`, `User_work_shop`, `user_type`) VALUES ('$user_fname', '$user_lname', '$user_name', '$user_gender', '$user_country', '$user_phone_No', '$user_email', '$user_address', '$user_home_No', '$user_ID_Pp_ID', '$user_postacode', '$user_password', '$newusershop', 'User')";
            echo "register sucessfully ". $user_fname. " " .$user_lname. " ". $user_email. " " .$user_name. " ". $user_password. " ". $sql;
            $newname = $user_fname. " ". $user_password;
            if ($conn->query($sql)) {
                $_SESSION['msg'][] = "new user is inserted sucessfully";
            } else $_SESSION['msg'][] = "Error: ".$sql ."<br>". $conn->error;
        } else $_SESSION['msg'][] = "password are not same!";
    }
    unset($_POST['register_btn']);
}
?>
<!-- creating the form-box -->
<div id='login-form' class='form-box'>
    <div class='button-box'>
        <div id='toggle-btn-on' class="toggle-btn-on"></div>
        <button type='button'onclick='login()'class='toggle-btn'>Log In</button>
        <button type='button'onclick='register()'class='toggle-btn'>Register</button>
    </div>
    <div>
        <!-- creating the login form -->
        <form id='login' class='input-group-login' method="POST">
            <input type='text'class='input-filed'placeholder='Enter Email, Name or Id'name="login_name"required>
            <input type='text'class='input-filed'placeholder='Enter Password'name="login_password"required>
            <input type='checkbox'class='check-box'><span>Remember This Password</span></input>
        <input href="Home.php" type='submit'class='submit-btn' name="login_btn"></input>
</form>
<!-- creating the registration form -->
<form id='register' class='input-group-register' method="POST">
    <input type='text'class='input-filed input-fn'placeholder='First Name'name="register_fname"required>
    <input type='text'class='input-filed input-ln'placeholder='Last Name'name="register_lname"required>
    <input type='text'class='input-filed'placeholder='User Name'name="register_name"required>
    <input type='text'class='input-filed'placeholder='Gender'name="register_gender"required>
    <input type='email'class='input-filed'placeholder='Email'name="register_email"required>
    <input type='text'class='input-filed'placeholder='Country'name="register_country">
    <input type='number'class='input-filed'placeholder='Phone Number'name="register_phone_No">
    <input type='text'class='input-filed'placeholder='Adresse'name="register_address">
    <input type='text'class='input-filed'placeholder='Post Code'name="register_postacode">
    <input type='text'class='input-filed'placeholder='Home No'name="register_home_No">
    <input type='text'class='input-filed'placeholder='Id or Passport Id'name="register_ID_Pp_ID">
    <input type='password'class='input-filed'placeholder='Enter Password'name="register_password"required>
    <input type='password'class='input-filed'placeholder='Congirm Password'name="register_cpassword"required>
    <input type='checkbox'class='check-box'><span>I agree to the terms and conditions</span></input>
<button type='submit'class='submit-btn' name="register_btn">Register</button>
</form>
</div>
</div>

<!-- the first script code is for login and registration form to move correctly-->
<script>
const lg_body = document.querySelector('body');
var x = document.getElementById('login');
var y = document.getElementById('register');
var z = document.getElementById('toggle-btn-on');
var view_Box = document.getElementById('login-form');

function register() {
x.style.left = '-'+view_Box.clientWidth+'px';
x.style.display = "none";
y.style.left = '5%';
y.style.display = "flex";
z.style.left = '50%';
view_Box.style.height = "80%";
view_Box.style.top = "0";
}

function login() {
x.style.left = '5%';
x.style.display = "block";

view_Box.style.top = "25%";
y.style.left = view_Box.clientWidth+'px';
y.style.display = "none";
z.style.left = '5%';
view_Box.style.height = '250px';
}

// this is for the when you click out the login or registration page the form -box disappears
window.onclick = function(event) {
if (event.target == view_Box) {
view_Box.style.display = "none";
}
}

function log_in_out() {
view_Box.style.fontSize = "small";
view_Box.style.width = "390px";
view_Box.style.height = '250px';
view_Box.style.background = "rgba(0,0,0,.3)";
view_Box.style.padding = "18px";
view_Box.style.overflow = "hidden";
view_Box.style.position = "fixed";
view_Box.style.top = "25%";
view_Box.style.left = "0";
view_Box.style.display = "block";
view_Box.style.alignItems = "center";
view_Box.style.justifyContent = "center";
view_Box.style.zIndex = "1000";
//lg_body.appendChild(view_Box);
document.getElementById('login-form').style.display = 'block';
}


    
/*window.onscroll = () => {
var mainy = 200;
var sy = scrollY;
var sy = scrollY;
var y = mainy + sy;
var lg_main = document.querySelector('body .Main');
var ya = y + lg_main.scrollTop + 200
//document.getElementById('view-form').style.top = ya + 'px';
var l = document.querySelector('#login-form');
l.style.top = ya + 'rem';
document.querySelector('#shopping-cart-form').style.top = y + 'px';
};*/
</script>

<style>
.form-box {
width: 390px;
position: absolute;
margin: 2% auto;
background: rgba(0,0,0,.3);
padding: 10px;
right: 1%;
overflow: hidden;
display: none;

}

.form-box .button-box {
display: inline;
overflow: auto;
left: 5%;
width: 100%;

align-items: center;
justify-content: center;
margin-bottom: 0px;
margin-bottom: 0px;
display: inline-flex;
box-shadow: var(--box-shadow);
border: var(--border);
border-radius: 1.5rem;
gap: 2px;
}

.form-box .button-box .toggle-btn {
position: relative;
background: transparent;
color: white;
padding: 7px 63px;
border: none;
border-radius: 5px;
text-align: center;
font-size: 16px;
white-space: nowrap;
overflow: hidden;
}
.form-box .button-box .toggle-btn-on {
left: 5%;
position: absolute;

padding: 10px 63px;
background: #f3c693;
border-radius: 30px;
transition: .5s;
}

#login {
left: 5%;
width: 90%;
background: transparent;
box-shadow: var(--box-shadow);
border: var(--border);
border-radius: 1.5rem;
}

#login .input-filed {
color: black;
width: 100%;
padding: 1rem 1rem;
border-radius: 0.5rem;
border-radius: 1.5rem;
margin: 0.5rem 0;
border: 1px solid #ccc;
}

.input-group-login {
top: 65px;
position: absolute;
width: 80%;
transition: .5s;
}

#register {
left: 790px;
width: 90%;
height: 90%;
margin-bottom: 0px;

box-shadow: var(--box-shadow);
border: var(--border);
border-radius: 1.5rem;
display: none;
grid-template-columns: repeat(auto-fit, minmax(auto, 1fr));
/* Adjust the width as needed */
gap: 5px;
max-height: 90%;
/* Set the maximum height for the container */
overflow-y: auto;
/* Enable vertical scrolling when content exceeds height */
grid-template-columns: repeat(auto-fit, 35rem);
gap: 5px;
justify-content: center;
/* overflow: hidden;
line-height: 100%; */
margin-right: auto;
text-align: center;
padding: 2rem;
box-shadow: var(--box-shadow);
border: var(--border);
border-radius: 1.5rem;
align-items: center;
align-content: space-between;
flex-wrap: wrap;
height: auto;

}

#register .input-filed {
color: black;
display: grid;
width: 100%;
padding: 1rem 1rem;
border-radius: 0.5rem;
border-radius: 1.5rem;
margin: 0.5rem 0;
border: 1px solid #ccc;
}

#register .input-fn {
width: 48%;
}

#register .input-ln {
width: 48%;
}
.input-group-register {
top: 65px;
position: absolute;
width: 80%;
transition: .5s;

}

#login .check-box,
#register .check-box {
cursor: pointer;
margin: auto;
border: 0;
left: 0px;
color: #f5f5f5;
font-size: 16px;
display: inline;
}

#login .check-box span,
#register .check-box span {
cursor: pointer;
margin: auto;
border: 0;
left: 0px;
color: red;
font-size: 1.5em;
display: block;
}

.form-box .submit-btn {
width: 75%;
left: 25%;
padding: 10px 30px;
cursor: pointer;
display: block;
margin: 10px;
background: #f3c693;
border: 0;
outline: none;
border-radius: 30px;
}
@media (max-width:768px) {
.form-box {
width: 100%;
}

}

</style>