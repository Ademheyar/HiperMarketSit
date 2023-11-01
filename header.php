<div class="header">
    <?php if (session_id() == "") session_start(); ?>
    <a href="#" class="logo">
        <img src="img/logo/logo.jpg" alt="">
    </a>
    <input type='text' class='search_box' placeholder='Search' name="search_box">
    <div class="header_btns">
        <li><a onclick="chart_start();" class="cart_icon">
            <img src="img/icons/cart.svg" class="cart_img" alt="">
            <span><?php echo isset($_SESSION['car_length']) ? $_SESSION['car_length'] : "0"; ?></span>
        </a></li>
    </div>
</div>

<style>
    /* Header Styles */
    /* about header */
    .header {
        /**/
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        

        background: var(--sbg);
        display: flex;
        gap: 0.5rem;
        align-items: center;
        border-bottom: var(--border);

        top: 0;
        left: 0;
        right: 0;
    }

    /* about logo on header*/

    .header .logo {
        margin-right: auto;
        left: 0;
        margin-top: none;
        position: relative;
        font-size: 2.5rem;
        width: 40%;
    }

    /* about logo image */
    .header .logo img {
        width: 100%;
        height: 10rem;
    }


    /*
   this will make search look good
*/

    .search-container {
        display: flex;
    }

    .header .search_box {
        width: 50%;
        height: 30px;
        
        /*position: relative;*/
        border-radius: 20px;
        border: 1px solid #ccc;
        padding: 5px 15px;
        /*font-size: 16px;
        /*outline: none;
        /*margin-right: auto;
        /*font-size: 2.5rem;*/

    }

    .header .search_box::placeholder {
        color: #999;
    }
    /*.header .search-form {
        position: relative;
        top: 0%;
        right: 7%;
        background: #fff;
        width: 40rem;
        height: 5rem;
        display: flex;
        align-items: center;
        transform: scaleY(0);
        transform-origin: top;
    }

    .header .search-form input {
        height: 100%;
        width: 100%;
        font-size: 1.6rem;
        color: var(--black);
        padding: 1rem;
        text-transform: none;
    }

    .header .search-form label {
        cursor: pointer;
        font-size: 2.2rem;
        margin-right: 1.5rem;
        color: var(--black);
    }

    .header .search-form label:hover {
        color: var(--main-color);
    }*/

    .header .header_btns {
        list-style: none;
        /*position: relative;*/
        display: flex;
        width: auto;

        right: 0px;
        grid-template-columns: repeat(auto-fit, 5rem);
        gap: 0.5rem;
        padding: 2rem;
        border-radius: 1.5rem;
        align-items: center;
        align-content: space-between;
        flex-wrap: wrap;
        background: transparent;
    }

    .header .header_btns .cart_icon {
        display: flex;
        align-items: center;
        /* Vertical alignment of cart icon and number *
        margin-left: 10px;/*/
    }
    .header .header_btns .cart_icon img {
        width: 85%;
        height: 5rem;
    }

    .header .header_btns .cart_icon span {
        background-color: red;
        color: white;
        border-radius: 25%;
        padding: 0px 3px;
        font-size: 10px;
        margin-left: 0.1px;
        margin-top: 1px;
        /* Add spacing between cart icon and number */
    }
    /* media queries  */

@media (max-width:1500px) {
        /* Header Styles */
        .
    }

@media (max-width:991px) {
 .
    }

@media (max-width:768px) {
        /* Header Styles */
        .header {
            align-items: baseline;
            align-items: left;
            
            justify-content: space-evenly;
            border-bottom: var(--border);
            height: 15%;
            width: auto;
        }

        /* about logo on header*/

        .header .logo {
            position: fixed;
            top: 1px;
            left: 20%;
            bottom: 25%;
            width: 50%;
            height: 25%;
            font-size: 2.5rem;
        }

        /* about logo image */
        .header .logo img {
            background: red;
            left: 0;
            width: 100%;
            height: 5rem;
        }

        .header .search_box {
            left: 5%;
            top: 30%;
            /*position: relative;*/
            margin-right: auto;
            margin-top: auto;
            width: 80%;
            font-size: 2.5rem;
        }

        .header .header_btns {
            right: 2%;
            top: 3rem;
            /*position: relative;*/
            margin-right: auto;
            height: 7rem;
            font-size: 2.5rem;
        }
    }

@media (max-width: 600px) {
        /* Header Styles */
        .header {}
    }

@media (max-width:450px) {
        /* Header Styles */
        .header {}
    }
</style>