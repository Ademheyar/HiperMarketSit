<?php
if(session_id() == "") session_start();

?>
<div class="foot_navigation">
    <ul>
        <li class="list active" style="--i:0;">
            <?php if($_SESSION['on'] !=0){?>
            <a href="Main.php">
            <?php }else { ?>
            <a href="Home.php">
            <?php } ?>
                <span class="icon">
                    <img src="img/icons/home.svg" class="Home-outline" alt="">
                </span>
                <span class="text">Home</span>
            </a>
        </li>
        <li class="list" style="--i:1;">
            <?php
            // Check if the user is logged in and has user type 2
            if(isset($_SESSION['loged_user_type']) && $_SESSION['loged_user_type']!=0) { ?>
                <?php if(session_id()=="") session_start(); ?>

                <?php if($_SESSION['on'] !=1){ ?>
            <a href="Template/profile/View_Profile.php"class="text">
                <?php }else { ?>
            <a href="Home.php" class="text">
            <?php } ?>
                <span class="icon">
                    <img src="img/icons/user.svg" class="person-outline" alt="">
                </span>
                <span class="text"><?php echo $_SESSION['loged_user_info']['user_name']; ?></span>
            </a>
            <?php } else { ?>
            <a href="#" onclick="log_in_out();" class="Home_text">
                <span class="icon">
                    <img src="img/icons/user.svg" class="person-outline" alt="">
                </span>
                <span class="text">Log In</span>
            </a>
            <?php } ?>
        </li>
        <li class="list" style="--i:2;">
            <a href="#">
                <span class="icon">
                    <img src="img/icons/message.svg" class="chatbubble-outline" alt="">
                </span>
                <span class="text">Message</span>
            </a>
        </li>
        <li class="list" style="--i:3;">
            <a href="#">
                <span class="icon">
                    <img ="img/icons/camera.svg" class="camera-outline" alt="">
                </span>
                <span class="text">Photos</span>
            </a>
        </li>
        <!--<li class="list" style="--i:4;">
                                                        <a href="#">
                                                            <span class="icon">
                                                                <img src="img/settings-outline.svg" class="settings-outline" alt="">
                                                            </span>
                                                            <span class="text">Settings</span>
                                                        </a>
                                                    </li>-->

        <div class="toggle">
            <img src="img/icons/menu.svg" class="img" alt="">
        </div>
    </ul>
</div>
<script>
    var phpVariable = <?php echo $_SESSION['on']; ?>;
    const manue_list = document.querySelectorAll('.list');
    
    if (phpVariable != 0) {
        manue_list.forEach((item) =>
        item.classList.remove('active'));
        manue_list[1].classList.add('active');
    }
    
    let toggle = document.querySelector('    .foot_navigation .toggle .img');
    let foot_navigation = document.querySelector('.foot_navigation');
    toggle.onclick = function() {
        foot_navigation.classList.toggle('active');
    }
    
    function activeLink() {
        manue_list.forEach((item) =>
        item.classList.remove('active'));
        this.classList.add('active');
    }
    
    manue_list.forEach((item) =>
    item.addEventListener('click', activeLink))
</script>

<?php
$leftValue = $_SESSION['on'] == 0 ? '5' : '25';
?>

<style>
    /* Add any necessary CSS styles for the chart container */
:root {
        --tg_bg: white;
        --fn_bg: #222327;
        --text: gray;
        --clr: #222327;
    }

    .foot_navigation
    {
        position: absolute;
        align-items: center;
        display: grid;
        bottom: 10%;
        left: 5%;
        width: 50%;;
    }
    
    .foot_navigation ul
    {
        display: flex;
        grid-template-columns: repeat(auto-fit, 35rem);
        gap: 5rem;
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
        background: white;
        height: auto;
    }

    .foot_navigation ul li
    {
        list-style: none;
        z-index: 1;
        position: grid;
        transform-origin: 100px;
        left: 0;
        transition: 0.5s;
        transition-delay: calc(0.1s *  var(--i));
        /*transform: rotate(0deg) translateX(100px);*/

        transform: none;
        /*width: 200px;
        height: 100px;*/
        z-index: 1;
        text-align: center;
    }

    .foot_navigation.active ul li
    {
        /*transform: rotate(calc(360deg / 5* var(--i)));*/
        display: none;
    }

    .foot_navigation ul li a
    {
        display: flex;
        justify-content: center;
        align-items: center;
        transition: 0.5s;

        transform: none;
        height: auto;

        position: relative;
        display: flex;
        flex-direction: column;
        width: 100%;
        font-weight: 400;

        grid-template-columns: repeat(auto-fit, 35rem);
        gap: 5rem;
        justify-content: center;
        margin-right: auto;
        text-align: center;
        padding: 2rem;
        /*box-shadow: var(--box-shadow);
        border: var(--border);*/
        border-radius: 1.5rem;
        align-content: space-between;
        flex-wrap: wrap;
        /*background: var(--blue);*/

    }

    .foot_navigation ul li a:hover
    {
        /*color: #ff1252;*/
    }

    .foot_navigation ul li a .icon
    {
        position: relative;

        display: block;
        line-height: 5px;
        font-size: 1.5em;
        transition: 0.5s;
        transform: translateY(0%)
        top: 0px;

        content: '';
        width: 80px;
        height: 40px;
        background: transparent;
        transition: 0.5s;
    }
    .foot_navigation ul li a .text
    {
        position: relative;
        color: var(--text);
        display: block;
        font-weight: 400;
        font-size: 0.75em;
        letter-spacing: 0.05em;
        transition: 0.5s;

        content: '';
        bottom: 0px;
        transition: 0.5s;;

    }

    .foot_navigation .toggle
    {
        position: absolute;
        bottom: -90px;
        left: -5px;
        width: 120px;
        height: 120px;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 0px 4px rgba(0,0,0,0.15);
        font-size: 2em;
        transition: transform 1.25s;
        transform: rotate(0deg) translateX(-50px) translateY(-28px);
    }

    .foot_navigation .toggle img
    {
        z-index: 10000;
        width: 80%;
        height: 80%;
    }
    
    .foot_navigation.active .taggle
    {
        transform: rotate(315deg);
    }

@media (max-width:450px) {

        .foot_navigation
        {
            position: fixed;
            left: 0px;
            bottom: 0px;
            right: 0px;
            display: flex;

            border-radius: 10px;
            text-align: center;


            width: 100%;
            height: 70px;
            background: var(--tg_bg);
        }

        .foot_navigation ul
        {
            display: flex;
            grid-template-columns: none;
            gap: 0;
            justify-content: center;
            margin-right: none;
            text-align: none;
            padding: 0;
            box-shadow: none;
            border: none;
            border-radius: none;
            align-items: center;
            align-content: none;
            flex-wrap: none;
            background: none;
            height: none;
            width: 350px;
        }

        .foot_navigation ul li
        {
            /*left: 0; bottom: 0;*/
            transform: none;


            position: relative;
            list-style: none;
            width: 80px;
            height: 100px;
            z-index: 1;;
            transform-origin: none;
            left: 0px;
            transition: none;
            transition-delay: none;

            text-align: none;
        }
        .foot_navigation ul li a
        {

            transition: none;
            font-weight: none;

            grid-template-columns: none;
            gap: none;
            margin-right: none;
            text-align: none;
            padding: none;
            box-shadow: none;
            border: none;
            border-radius: none;
            align-content: none;
            flex-wrap: none;

            box-shadow: none;
            transform: none;
            background: none;
            height: auto;

            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width: 100%;
            font-weight: 400;
            
            bottom: auto;
            right: auto;
            justify-content: auto;
            align-items: auto;
            cursor: auto;
            box-shadow: auto;
            font-size: auto;
            transform: auto;
            position: absolute;;
            transition: 0.5s;
        }
        .foot_navigation ul li a .icon
        {
            position: fixed;
            bottom: 0;

            display: block;
            line-height: 5px;
            font-size: 1.5em;
            transition: 0.5s;
            transform: translateY(0%)


            content: '';
            width: 100px;
            height: 65px;
            background: transparent;
            transition: 0.5s;
        }

        .foot_navigation ul li.active a .icon
        {
            transform: translateY(-50%)
        }
        .foot_navigation ul li a .icon img
        {
            width: 45%;
            height: 70%;
        }

        .foot_navigation ul li a .text
        {
            position: fixed;
            color: var(--text);
            display: block;
            font-weight: 400;
            font-size: 0.75em;
            letter-spacing: 0.05em;
            transition: 0.5s;
            opacity: 0;

            content: '';

            bottom: 0%;
            background: transparent;
            transition: 0.5s;

            position: absolute;
            top: 50px;
            width: 70px;
            height: 10px;


            transition: 0.5s;

        }

        .foot_navigation ul li.active a .text
        {
            opacity: 1;
            transform: translateY(0%);

        }
        .foot_navigation .toggle
        {
            left: 5%;
            /*left: <?php echo $leftValue?>%;
            /*
            justify-content: auto;
            align-items: auto;
            cursor: auto;
            box-shadow: auto;
            font-size: auto;
            transform: auto;*/
            position: absolute;
            top: -50%;
            width: 70px;
            height: 70px;
            background:  #3498db;
            border-radius: 50%;
            border: 6px solid var(--tg_bg);
            transition: 0.5s;
        }

        .foot_navigation .toggle::before
        {
            content: '';
            position: absolute;
            top: 60%;
            left: -23px;
            width: 20px;
            height: 20px;
            background: transparent;
            border-top-left-radius: 20px;
            box-shadow: 1px -10px 0 0 var(--tg_bg);
            transition: 0.5s;
            
        }

        .foot_navigation .toggle::after
        {
            content: '';
            position: absolute;
            top: 60%;
            left: 60px;
            width: 20px;
            height: 20px;
            background: transparent;
            border-top-right-radius: 20px;
            box-shadow: 0px -10px 0 0 var(--tg_bg);
            transition: 0.5s;
        }
        .foot_navigation .toggle img
        {
            display: none;
        }

        .foot_navigation ul li:nth-child(1).active ~ .toggle
        {
            transform: translateX(calc(5px))
        }
        .foot_navigation ul li:nth-child(2).active ~ .toggle
        {
            transform: translateX(calc(82px*1))
        }
        .foot_navigation ul li:nth-child(3).active ~ .toggle
        {
            transform: translateX(calc(82px*2))
        }
        .foot_navigation ul li:nth-child(4).active ~ .toggle
        {
            transform: translateX(calc(82px*3))
        }
        /*.foot_navigation ul li:nth-child(5).active ~ .toggle
            {
                transform: translateX(calc(70px*4))
            }*/
    }
</style>