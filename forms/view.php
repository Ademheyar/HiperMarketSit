

<!-- creating the form-box -->
<!-- the first script code is for login and registration form to move correctly-->
<script>
    
        
    window.onscroll = () => {
        var mainy = 150;
        var sy = scrollY; 
   var sy = scrollY; 
   var y = mainy + sy;
   var a = document.querySelector('body .Main');
	var ya  = y+ a.scrollTop
	document.getElementById('view-form').style.top = ya + 'px';
        document.querySelector('#shopping-cart-form').style.top = y + 'px';
        menu.classList.remove('fa-times');
        navbar.classList.remove('active');
    };
</script>

<style>
#view-form {
   width: 100%;
   height: auto;
   position: absolute;
   background: rgba(0,0,0,.3);
   padding: 18px;
   overflow: hidden;
   display: none;
}

#view-form .do_btns {
    display: line;
}

#view-form .do_btns .btns {
    width: 33%;
    text-align: center;
    background-color: var(--blue);
    color: var(--white);
    padding: 1.2rem 3rem;
    border-radius: 0.5rem;
    margin-top: 1rem;
}

#view-form .box {
    width: 100%;
    height: auto;
    background: rgba(0,0,0,.3);
    padding: 3px;
    display: inline-flex;
    position: relative;
    color: aliceblue;
}

#view-form .box .img_box {
    width: 50%;
    height: 330px;
    background: rgba(0,0,0,.3);
    padding: 6px;
    display: list-item;
}

#view-form .sub_box {

}

#view-form .sub_box .size_box {
    width: 100%;
    padding: 6px;
}

#view-form .sub_box .color_box {
    width: 100%;
    padding: 6px;
}

</style>
