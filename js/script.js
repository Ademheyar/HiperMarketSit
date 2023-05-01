function Color_selected(color) {
   document.querySelector('#view-form .p_color').value = color;
}

function View_color(code, size) {
   document.querySelector('#view-form .p_size').value = size;
   for(var c = document.getElementById("color_box_id").children.length-1; c >= 0;c--){
       document.getElementById("color_box_id").children[c].remove();
   }

   var other_info = code.split("|,");
   for(var o = 0; other_info[o]; o++){
       var other_value = other_info[o].split(",");
       if(other_value.length < 2) break;
       var color = other_value[0].replace("|", "");
       var item = document.createElement('button');
       item.title = other_value[1];
       item.setAttribute('onclick', 'Color_selected("'+ color + '")');
       item.innerHTML = '<i class="fa fa-trash-o"></i>';
       //item.class="itemBttnclass";
       item.style.width = '50px';
       item.style.height = '20px';
       item.style.color = 'black';
       item.innerText = "" + color;
       document.getElementById("color_box_id").appendChild(item);
   }
}

function set_img_pos(num) {
   var list = document.querySelector('#view-form .box .img_box');
   for(var z = 0; z <= list.children.length-1; z++){
      var n = 100/list.children.length;
      if(100/3 >= n) n=n;
      else n = 100/3;
      if(z == Number(num)){
         list.children[z].style.width =String(100)+"%";
         list.children[z].style.height =String(100-100/2)+"%";
      }
      else {
         list.children[z].style.width =String(n)+"%";
         list.children[z].style.height =String(100/4)+"%";
      }
   }
   list.value = String(num);
}

function View_Selected(vs_id, vs_n, vs_price, vs_img, vs_path, vs_dic, vs_info) {
   document.getElementById('view-form').style.display='block'; 
   var sy = scrollY;
   var y = sy;
   
   //<input type="hidden" name="product_name" class="p_name" value="">
   document.querySelector('#view-form .p_name').value = vs_n;
   document.querySelector('#view-form .p_name').innerText = vs_n;
   document.querySelector('#view-form .box .sub_box .p_name').innerText = vs_n;
   //<input type="hidden" name="product_code" class="p_code" value="">
   document.querySelector('#view-form .p_code').value = vs_price;
   //<input type="hidden" name="product_type" class="p_type" value="">
   document.querySelector('#view-form .p_type').value = vs_price;
   //<input type="hidden" name="product_image" class="p_img" value="">
   var list = document.querySelector('#view-form .box .img_box');
   for(var z = 0; z <= list.children.length-1; z++){
      list.children[z].remove();
   }

   for(var m = 0; vs_img.split("~")[m]; m++){
      var img = document.createElement('img');
      alert("image "+  vs_path + "/" + vs_img.split("~")[m]);
      img.src =  vs_path + "/" + vs_img.split("~")[m];
      list.appendChild(img);
      
      list.value = "0";
      for(var z = 0; z <= list.children.length-1; z++){
         var n = 100/list.children.length;
         if(100/3 >= n) n=n;
         else n = 100/3;
         if(z == 0){
            list.children[z].style.width =String(100)+"%";
            list.children[z].style.height =String(100-100/4)+"%";
         }
         else {
            list.children[z].style.width =String(n)+"%";
            list.children[z].style.height =String(100/4)+"%";
         }
         img.setAttribute('onclick', 'set_img_pos("'+ z + '")');
      }
   }
   //<input type="hidden" name="product_price" class="p_price" value="">
   document.querySelector('#view-form .p_price').value = vs_price;
   document.querySelector('#view-form .p_price').innerText = vs_price;
   document.querySelector('#view-form .box .sub_box .p_price').innerText = "R" + vs_price;
   //<input type="hidden" name="product_path" class="p_path" value="">
   document.querySelector('#view-form .p_path').value = vs_price;
   //<input type="hidden" name="product_info" class="p_info" value="">
   document.querySelector('#view-form .p_info').value = vs_info;

   document.querySelector('#view-form .p_disc').innerText = vs_dic;
   document.querySelector('#view-form .box .sub_box .p_disc').innerText = vs_dic;

   //{l,[|black,2|,|green,3|,|white,5|,]},{xl,[|white,5|,|black,2|,|green,6|,]},
   var main_info = vs_info.split("},");
   for(var m = 0; main_info[m]; m++){
       var main_value = main_info[m].split(",[");
       var size = main_value[0].replace("{", "");
       var item = document.createElement('button');
       item.setAttribute('onclick', 'View_color("' + main_value[1] + '","' + size + '")');
       item.innerHTML = '<i class="fa fa-trash-o"></i>';
       item.class="itemBttnclass";
       item.style.width = '50px';
       item.style.height = '20px';
       item.style.color = 'black';
       item.innerText = "" + size;
       document.getElementById("size_box_id").appendChild(item);
   }

   document.querySelector('#view-form').style.top = y + 'px';
   document.getElementById('shopping-cart-form').style.display='none'; 
   document.getElementById('login-form').style.display='none';
}
   
let menu = document.querySelector('#menu-btn');
//let navbar = document.querySelector('body .flex .navbar');
var a_u_list = [];

/*menu.onclick = () => {
   menu.classList.toggle('fa-times');
   //navbar.classList.toggle('active');
};*/

var a = document.querySelector('body .Main');
window.onscroll = () => {
   var mainy = 150;
   var sy = scrollY; 
   var y = mainy + sy;
	var ya  = y/2 + a.scrollTop -10;
	document.getElementById('view-form').style.top = ya + 'px';
   if(document.querySelector('#login-form')) document.querySelector('#login-form').style.top = y + 'px';
   document.querySelector('#shopping-cart-form').style.top = y + 'px';
   //menu.classList.remove('fa-times');
   //navbar.classList.remove('active');
};

a.onscroll = () => {
   var mainy = 150;
   var sy = scrollY; 
   var y = mainy + sy;
	var ya  = y/2+ a.scrollTop -10;
	document.getElementById('view-form').style.top = ya + 'px';
   if(document.querySelector('#login-form')) document.querySelector('#login-form').style.top = y + 'px';
   document.querySelector('#shopping-cart-form').style.top = y + 'px';
   //menu.classList.remove('fa-times');
   //navbar.classList.remove('active');
};


/*
document.querySelector('#view-form').on
document.querySelector('#view-form h1').innerText = 'djsfa';
var mainy = 150;
var sy = scrollY; 
var y = mainy + sy;
document.querySelector('#view-form').style.top = y + 'px';
*/

/*

document.querySelector('#close-edit').onclick(){
   document.querySelector('.edit-form-container').style.display = 'none';
   window.location.href = 'admin.php';
};
*/






