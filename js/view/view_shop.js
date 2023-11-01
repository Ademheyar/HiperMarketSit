var selectedItems = [];
var selecteditem_info = [];

// Function to add a new item to the cart
function addNewItem(info, selected) {
    
    console.log("add_to_cart info:", info);
    console.log("add_to_cart selected:", selected);
    items = [];
    for(let i = 0; i < selected.length; i++){
        var newItem = {
            id: info[0],
            name: info[1],
            price: info[2],
  
  
            color: selected[i][1],
            size: selected[i][2][0],
            quantity: selected[i][3]
        };

        items.push(newItem);
    }
    console.log("add_to_cart :", items);
    

    var cartData = localStorage.getItem('cartData');
    cartData = cartData ? JSON.parse(cartData) : [];
    cartData.push(items);
    localStorage.setItem('cartData', JSON.stringify(cartData));
 }

function read_item(list, parent){
    var currentForm = 0;
    var selectedShop = "";
    var selectedColor = "";
    var selectedSize = null;
    var selectedQty = 0;
    //var selectedItems = [];
    var isChangeQty;
    var givenQty;
    var itemList;
    var formFrame = null;
    
    function read_code(vs_info, shop_s, color_s, size_s) {
        let a_u_list = [];
        let shops = [];
        let colors = [];
        let sizes = [];
        
        let fbsr = vs_info.replace("\"{", "{");
        let lbsr = fbsr.replace("}\"", "}") + ",";
        alert("reading list : " + list);
        alert("reading list : " + lbsr);
        let main_info = lbsr.split("},");

        for (let m = 0; m < main_info.length - 1; m++) {
            let main_value = main_info[m].split(",(");
            let shop_name = main_value[0].replace("{", "").trim();

            if (shop_s === "" || shop_s === shop_name) {
                shops.push(shop_name);
            }

            let shop = [shop_name];
            let shop_node = [];

            t = main_value[1].replace(")", "") + ",";
            let f_info = t.split(">,");

            for (let c = 0; c < f_info.length - 1; c++) {
                let f_value = f_info[c].split(",[");
                let color_txt = f_value[0].replace("<", "").trim();

                if ((shop_s !== "" && shop_s === shop_name) &&
                    (color_s === "" || color_s === color_txt)) {
                    colors.push(color_txt);
                }

                let color = [color_txt];
                let color_node = [];

                t = f_value[1].replace("]", "") + ",";
                let s_info = t.split("|,");

                for (let s = 0; s < s_info.length - 1; s++) {
                    let s_value = s_info[s].split(", ");

                    if (s_value.length <= 1) {
                        s_value = s_info[s].split(",");
                    }

                    let s_n = [];
                    for (let si = 0; si < s_value.length - 1; si++) {
                        if ((shop_s !== "" && shop_s === shop_name) &&
                            (color_s !== "" && color_s === color_txt) &&
                            (size_s === "" || size_s === s_value[si].replace("|", "").trim())) {
                            if (si === 0) {
                                sizes.push(s_value[si].replace("|", "").trim());
                            }
                        }

                        s_n.push(s_value[si].replace("|", "").trim());
                    }

                    color_node.push(s_n);
                }

                color.push(color_node);
                shop_node.push(color);
            }

            shop.push(shop_node);
            a_u_list.push(shop);
        }

        return [shops, colors, sizes, a_u_list];
    }

    function star() {
        formFrame = null;
        currentForm = 0;
        nextForm();
    }
    function clear(){
        while (parent.firstChild) {
            parent.removeChild(parent.firstChild);
        }
    }

    function createFormFrame() {
        clear();
        formFrame = document.createElement("div");
        parent.appendChild(formFrame);
    }

    function nextForm() {
        if (formFrame !== null) {
            parent.removeChild(formFrame);
        }

        createFormFrame();

        if (currentForm === 0) {
            displayShopButtons();
        } else if (currentForm === 1) {
            displayColorButtons();
        } else if (currentForm === 2) {
            displaySizeButtons();
        } else if (currentForm === 3) {
            displayQuantityEntry();
        } else if (currentForm === 4) {
            showSelectedItems();
        }
    }

    function prevForm() {
        currentForm--;
        nextForm();
    }

    function displayShopButtons() {
        itemList.forEach(function (shop) {
            var button = document.createElement("button");
            button.innerHTML = shop[0];
            button.addEventListener("click", function () {
                selectShop(shop[0]);
            });
            formFrame.appendChild(button);
        });

        var backButton = document.createElement("button");
        backButton.innerHTML = "Back";
        backButton.addEventListener("click", function () {
            prevForm();
        });
        formFrame.appendChild(backButton);
    }

    function displayColorButtons() {
        var colors = getColors();

        colors.forEach(function (color) {
            var button = document.createElement("button");
            button.innerHTML = color;
            button.addEventListener("click", function () {
                selectColor(color);
            });
            formFrame.appendChild(button);
        });

        var backButton = document.createElement("button");
        backButton.innerHTML = "Back";
        backButton.addEventListener("click", function () {
            prevForm();
        });
        formFrame.appendChild(backButton);
    }
    
    function displaySizeButtons() {
        selected_size = null;
        selectedQty = 0;
        let out = null;
        let sizeCount = getSizes().length;
        let sizeLabel = document.createElement("label");
        sizeLabel.textContent = "Size: " + sizeCount;
        formFrame.appendChild(sizeLabel);
        
        let qtyLabel = document.createElement("label");
        qtyLabel.textContent = "Quantity: " + getQtys();
        formFrame.appendChild(qtyLabel);
        
        let selectSizeLabel = document.createElement("label");
        selectSizeLabel.textContent = "Select Size:";
        formFrame.appendChild(selectSizeLabel);
        
        for (let size of getSizes()) {
            let txt = size[0] + "(" + size[3] + ")";
            out = size;
            let sizeButton = document.createElement("button");
            sizeButton.textContent = txt;
            sizeButton.addEventListener("click", () => {
            selectSize(size);
            });
            formFrame.appendChild(sizeButton);
        }
        
        var backButton = document.createElement("button");
        backButton.innerHTML = "Back";
        backButton.addEventListener("click", function () {
            prevForm();
        });
        formFrame.appendChild(backButton);
        
        let buttonCount = Array.from(formFrame.children).filter(child => child.tagName === "BUTTON").length;
        if (buttonCount === 2 && out) {
            selectSize(out);
        }
    }

    function displayQuantityEntry() {
        selectedQty = 0;
        
        var qtyLabel = document.createElement("label");
        qtyLabel.textContent = "Quantity: " + String(getQtys());
        formFrame.appendChild(qtyLabel);
        
        var enterQtyLabel = document.createElement("label");
        enterQtyLabel.textContent = "Enter Quantity:";
        formFrame.appendChild(enterQtyLabel);
        
        qty_entry = document.createElement("input");
        selectedQty = 0;
        qty_entry.value = "1";
        formFrame.appendChild(qty_entry);
        
        var backButton = document.createElement("button");
        backButton.innerHTML = "Back";
        backButton.addEventListener("click", function () {
            prevForm();
        });
        formFrame.appendChild(backButton);
        
        var addToCartButton = document.createElement("button");
        addToCartButton.innerHTML = "Save";
        addToCartButton.addEventListener("click", function () {
            add_to_cart(qty_entry.value);
        });
        formFrame.appendChild(addToCartButton);
        
    }

    function add_to_cart(value) {
        console.log("add_to_cart :" + value);
        
        if (selectedShop && selectedColor && selectedSize) {
            console.log("add_to_cart :");
            
            if (selectedQty === 0) {
                selectedQty = value;
            }
            
            var item = [selectedShop, selectedColor, selectedSize, selectedQty];
            selectedItems.push(item);
            console.log("true :" + String(selectedItems));
            
            show_selected_items();
        } else {
            tk.messagebox.showerror("Error", "Please complete the selection.");
        }
    }



    function selectShop(shop) {
        selectedShop = shop;
        currentForm++;
        nextForm();
    }

    function selectColor(color) {
        selectedColor = color;
        currentForm++;
        nextForm();
    }

    function selectSize(size) {
        selectedSize = size;
        currentForm++;
        nextForm();
    }

    function addCartItem(qty) {
        selectedQty = qty;
        currentForm++;
        selectedItems.push([selectedShop, selectedColor, selectedSize, selectedQty]);
        nextForm();
    }

    function changeQuantity() {
        selectedQty = givenQty;
        currentForm++;
        nextForm();
    }

    function showSelectedItems() {
        var list = document.createElement("ul");

        selectedItems.forEach(function (item) {
            var listItem = document.createElement("li");
            listItem.innerHTML = item[0] + " - " + item[1] + " - " + item[2] + " - " + item[3];
            list.appendChild(listItem);
        });

        formFrame.appendChild(list);
    }

    function getColors() {
        let colors = [];
        for (let shop of itemList) {
            if (shop[0] === selectedShop) {
            return shop[1].map(color => color[0]);
            }
            for (let color of shop[1]) {
            if (!colors.includes(color[0])) {
                colors.push(color[0]);
            }
            }
        }
        return colors;
    }

    function getSizes() {
        var sizes = [];
        for (var shop of itemList) {
            if (shop[0] === selectedShop) {
            for (var color of shop[1]) {
                if (color[0] === selectedColor) {
                return color[1];
                }
            }
            for (var color of shop[1]) {
                for (var size of color[1]) {
                if (!sizes.includes(size[0])) {
                    sizes.push(size[0]);
                }
                }
            }
            break;
            }
        }
        if (sizes.length === 0) {
            for (var shop of itemList) {
            for (var color of shop[1]) {
                for (var size of color[1]) {
                if (!sizes.includes(size[0])) {
                    sizes.push(size[0]);
                }
                }
            }
            }
        }
        return sizes;
    }

    function getQtys() {
        var q = 0;
        for (var shop of itemList) {
            if (shop[0] === selectedShop) {
            for (var color of shop[1]) {
                if (color[0] === selectedColor) {
                for (var size of color[1]) {
                    if (selectedSize === size) {
                    return size[3];
                    }
                }
                for (var size of color[1]) {
                    if (size && parseFloat(size[3]) > 0) {
                    console.log("qty1 : " + size + " | " + size[3] + "+" + q + "=" + (q + parseFloat(size[3])));
                    q += parseFloat(size[3]);
                    }
                }
                break;
                }
            }
            if (q === 0) {
                for (var color of shop[1]) {
                for (var size of color[1]) {
                    if (size && parseFloat(size[3]) > 0) {
                    console.log("qty2 : " + size + " | " + size[3] + "+" + q + "=" + (q + parseFloat(size[3])));
                    q += parseFloat(size[3]);
                    }
                }
                }
            }
            break;
            }
        }
        if (q === 0) {
            for (var shop of itemList) {
            for (var color of shop[1]) {
                for (var size of color[1]) {
                if (size && parseFloat(size[3]) > 0) {
                    console.log("qty3 : " + size + " | " + size[3] + "+" + q + "=" + (q + parseFloat(size[3])));
                    q += parseFloat(size[3]);
                }
                }
            }
            }
        }
        return q;
    }

    function show_selected_items() {
        //clear();
        var result_frame = document.createElement("div");
        result_frame.classList.add('selected_items_box');
        formFrame.appendChild(result_frame);
        var label = document.createElement("label");
        label.textContent = "Selected Items:";
        result_frame.appendChild(label);
        for (var item of selectedItems) {
            var itemLabel = document.createElement("label");
            itemLabel.classList.add('selected_items');
            itemLabel.textContent = item;
            result_frame.appendChild(itemLabel);
        }
        var addButton = document.createElement("button");
        addButton.textContent = "Add";
        addButton.addEventListener("click", () => add());
        formFrame.appendChild(addButton);
    }

    function add(){
        clear();
        currentForm = 0;
        star();
    }
    
    isChangeQty = "";
    givenQty = "";
    
    if(list){
        let [, , , nested_list] = read_code(list, "", "", "");
        itemList = nested_list;
        console.log(itemList);
        selectedShop = "";
        selectedColor = "";
        selectedSize = null;
        selectedQty = 0;
        star();
    }
}

function View_Selected(vs_info, vs_id, vs_n, vs_price, vs_img, vs_path, vs_dic, vs_info1) {
    selectedItems = [];
    selecteditem_info = [];
    document.getElementById('view-form').style.display='block'; 
    var sy = scrollY;
    var y = sy;
    
    //<input type="hidden" name="product_name" class="p_name" value="">
    document.querySelector('#view-form .p_name').value = vs_n;
    document.querySelector('#view-form .p_name').innerText = vs_n;
    selecteditem_info.push(vs_id);
    selecteditem_info.push(vs_n);
    selecteditem_info.push(vs_price); 
    document.querySelector('#view-form .info_Box .sub_info_Box .p_name').innerText = vs_n;
    //<input type="hidden" name="product_code" class="p_code" value="">
    //document.querySelector('#view-form .p_code').value = vs_price;
    //<input type="hidden" name="product_type" class="p_type" value="">
    //document.querySelector('#view-form .p_type').value = vs_price;
    //<input type="hidden" name="product_image" class="p_img" value="">
    var list = document.querySelector('#view-form .info_Box .img_box');
    alert([vs_info1, vs_id, vs_n, vs_price, vs_img, vs_path, vs_dic, vs_info]);
    for(var z = 0; z <= list.children.length-1; z++){
        list.children[z].remove();
    }
    if(vs_img){
            for(var m = 0; vs_img.split("~")[m]; m++){
            var img = document.createElement('img');
            //alert("image "+  vs_path + "/" + vs_img.split("~")[m]);
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
    }

    //<input type="hidden" name="product_price" class="p_price" value="">
    document.querySelector('#view-form .p_price').value = vs_price;
    document.querySelector('#view-form .p_price').innerText = vs_price;
    document.querySelector('#view-form .info_Box .sub_info_Box .p_price').innerText = "R" + vs_price;
    //<input type="hidden" name="product_path" class="p_path" value="">
    document.querySelector('#view-form .p_path').value = vs_price;
    //<input type="hidden" name="product_info" class="p_info" value="">
    document.querySelector('#view-form .p_info').value = vs_info;

    document.querySelector('#view-form .p_disc').innerText = vs_dic;
    document.querySelector('#view-form .info_Box .sub_info_Box .p_disc').innerText = vs_dic;

    //{l,[|black,2|,|green,3|,|white,5|,]},{xl,[|white,5|,|black,2|,|green,6|,]},
    console.log("vs_info>>"+vs_info);

    read_item(vs_info, document.getElementById("selection_box_id"))


    document.querySelector('#view-form').style.top = y + 'px';
    document.getElementById('shopping-cart-form').style.display='none'; 
    document.getElementById('login-form').style.display='none';
}

function disply_item(vs_id, vs_n, vs_At_Shop, vs_type, vs_code, vs_price, vs_img, vs_path, vs_dic, vs_info) {
    var sy = scrollY;
    var y = sy;
    
    
    const view_Box = document.createElement('div');
    view_Box.classList.add('view');
    view_Box.id = 'view-form';
    view_Box.style.display='none'; 
    vs_mainu.appendChild(view_Box);
    const view_Boxclose_btn = document.createElement('input');
    view_Box.appendChild(view_Boxclose_btn);
    view_Boxclose_btn.value = "x";
    view_Boxclose_btn.style.width ="10px";
    view_Boxclose_btn.style.background ="border-box";
    view_Boxclose_btn.style.color ="red";
    view_Boxclose_btn.style.position ="absolute";
    view_Boxclose_btn.style.right ="0%";
    view_Boxclose_btn.addEventListener('click', ()=>{
        selectedItems = [];
        selecteditem_info = [];
        document.querySelector('#view-form').style.display = 'none';
    });
    
    
    var shop_name = (vs_At_Shop + " ").split(' ');
    var na = vs_n.replaceAll(' ', '_');
    
    var path = ("img\\" + shop_name[0] + "\\products\\" + (vs_type).replaceAll(' ', '\\') + "\\"+ na + "\\"+ vs_code).replaceAll('\\\\', '\\');
    var images = (vs_img + "~").split('~');
    console.log(images[0]);
    
    const viewbox_title = document.createElement('h1');
    viewbox_title.classList.add('heading_viewbox_title');
    viewbox_title.value = "View";
    view_Box.appendChild(viewbox_title);
    
    /// other info box that will hold all info about item
    const info_Box = document.createElement('div');
    view_Box.appendChild(info_Box);
    info_Box.classList.add('info_Box');
    
    // image box that will be created image 
    const Images_Box = document.createElement('div');
    info_Box.appendChild(Images_Box);
    Images_Box.classList.add('img_box');
    
    // item info will be desplyed in this box
    const otherinfo_Box = document.createElement('div');
    info_Box.appendChild(otherinfo_Box);
    otherinfo_Box.classList.add('sub_info_Box');
    
    const p_name_title = document.createElement('h1');
    p_name_title.classList.add('p_name');
    p_name_title.value = vs_n;
    p_name_title.innerText = vs_n;
    otherinfo_Box.appendChild(p_name_title);
    
    const p_price_info = document.createElement('h1');
    p_price_info.classList.add('p_price');
    p_price_info.value = "R" + vs_price;
    p_price_info.innerText = "R" + vs_price;
    otherinfo_Box.appendChild(p_price_info);

    const p_disc_info = document.createElement('h1');
    p_disc_info.classList.add('p_disc');
    p_disc_info.value = "color_box_id";
    p_disc_info.innerText = vs_dic;
    otherinfo_Box.appendChild(p_disc_info);

    const size_info_id = document.createElement('div');
    otherinfo_Box.appendChild(size_info_id);
    size_info_id.id = "selection_box_id";
    size_info_id.value = "View";
    size_info_id.classList.add('selection_box');
    
    for(var z = 0; z <= Images_Box.children.length-1; z++){
        Images_Box.children[z].remove();
    }

    for(var m = 0; images[m]; m++){
        var img = document.createElement('img');
        alert("image "+  path + "/" + images[m]);
        img.src =  path + "/" + images[m];
        Images_Box.appendChild(img);
        
        Images_Box.value = "0";
        for(var z = 0; z <= Images_Box.children.length-1; z++){
            var n = 100/Images_Box.children.length;
            if(100/3 >= n) n=n;
            else n = 100/3;
            if(z == 0){
                Images_Box.children[z].style.width =String(100)+"%";
                Images_Box.children[z].style.height =String(100-100/4)+"%";
            }
            else {
                Images_Box.children[z].style.width =String(n)+"%";
                Images_Box.children[z].style.height =String(100/4)+"%";
            }
            img.setAttribute('onclick', 'set_img_pos("'+ z + '")');
        }
    }


    // Add the product item element to the product grid container	
    // this form is for buttons 
    const view_form = document.createElement('div');
    view_Box.appendChild(view_form);
            
        const hidden_info_name = document.createElement('input');
        view_form.appendChild(hidden_info_name);
        hidden_info_name.classList.add('p_name');
        hidden_info_name.name="product_name";
        //<input type="hidden" name="product_name" class="p_name" value="">
        hidden_info_name.value = vs_n;
    hidden_info_name.innerText = vs_n;

    hidden_info_name.hidden = true;
    const hidden_info_code = document.createElement('input');
    view_form.appendChild(hidden_info_code);
    hidden_info_code.classList.add('p_code');
    hidden_info_code.name="product_code";
    hidden_info_code.value = vs_price;
    hidden_info_code.hidden = true;
    
    const hidden_info_type = document.createElement('input');
    view_form.appendChild(hidden_info_type);
    hidden_info_type.classList.add('p_type');
    hidden_info_type.name="product_type";
    hidden_info_type.value = vs_price;
    hidden_info_type.hidden = true;
    
    const hidden_info_imge = document.createElement('input');
    view_form.appendChild(hidden_info_imge);
    hidden_info_imge.classList.add('p_img');
    hidden_info_imge.name="product_image";
    hidden_info_imge.value= "";
    hidden_info_imge.hidden = true;
    
    const hidden_info_price = document.createElement('input');
    view_form.appendChild(hidden_info_price);
    hidden_info_price.classList.add('p_price');
    hidden_info_price.name="product_price";
    hidden_info_price.value = vs_price;
    hidden_info_price.innerText = vs_price;
    hidden_info_price.hidden = true;
    
    const hidden_info_disc = document.createElement('input');
    view_form.appendChild(hidden_info_disc);
    hidden_info_disc.classList.add('p_disc');
    hidden_info_disc.name="product_disc";
    hidden_info_disc.innerText = vs_dic;
    hidden_info_disc.value = vs_dic;
    hidden_info_disc.hidden = true;
    
    const hidden_info_info = document.createElement('input');
    view_form.appendChild(hidden_info_info);
    hidden_info_info.classList.add('p_info');
    hidden_info_info.name="product_info";

    hidden_info_info.value = vs_info;
    hidden_info_info.hidden = true;
    const hidden_info_size = document.createElement('input');
    view_form.appendChild(hidden_info_size);
    hidden_info_size.classList.add('p_size');
    hidden_info_size.name="product_size";
    hidden_info_size.value= "";
    hidden_info_size.hidden = true;
    const hidden_info_color = document.createElement('input');
    view_form.appendChild(hidden_info_color);
    hidden_info_color.classList.add('p_color');
    hidden_info_color.name="product_color";
    hidden_info_color.value= "";
    hidden_info_color.hidden = true;
    const hidden_info_path = document.createElement('input');
    view_form.appendChild(hidden_info_path);
    hidden_info_path.classList.add('p_path');
    hidden_info_path.name="product_path";
    hidden_info_path.value= path;
    hidden_info_path.hidden = true;


    const do_btn = document.createElement('div');
    view_form.appendChild(do_btn);
    do_btn.classList.add('view_btn_form');

    const do_like_btn = document.createElement('button');
    do_btn.appendChild(do_like_btn);
    do_like_btn.classList.add('btns');
    do_like_btn.name="add_to_cart";
    do_like_btn.innerText= "like";
    do_like_btn.value= "like";
    
    const do_buy_btn = document.createElement('button');
    do_btn.appendChild(do_buy_btn);
    do_buy_btn.classList.add('btns');
    do_buy_btn.name="add_to_cart";
    do_buy_btn.innerText= "Buy";
    do_buy_btn.value= "Buy";
    
    const do_cart_btn = document.createElement('button');
    do_btn.appendChild(do_cart_btn);
    do_cart_btn.classList.add('btns');
    do_cart_btn.classList.add('btns_add_to_cart');
    do_cart_btn.name="add_to_cart";
    do_cart_btn.value= "Add to cart";
    do_cart_btn.innerText= "Add to cart";
    do_cart_btn.addEventListener('click', function() {
		addNewItem(selecteditem_info, selectedItems);
	});
    
//{l,[|black,2|,|green,3|,|white,5|,]},{xl,[|white,5|,|black,2|,|green,6|,]},
/*console.log("disply_item vs_info>>"+vs_info);

read_item("{FLAG_SQUARE,(<FRUATE,[|2X10, , 23, -6.0, , |]>)},", document.getElementById("size_box_id"))
var main_info = (vs_info + "}").split("},");
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
    size_info_id.appendChild(item);
}*/
    var ya  = y+ vs_mainu.scrollTop
    view_Box.style.top = ya + 'px';
}

disply_item("", "", "", "", "", "", "", "", "", "");

window.onscroll = () => {
    var mainy = 150;
    var sy = scrollY; 
var sy = scrollY; 
var y = mainy + sy;
var vs_mainu = document.querySelector('body .Main');
var ya  = y+ vs_mainu.scrollTop
document.getElementById('view-form').style.top = ya + 'px';
    document.querySelector('#shopping-cart-form').style.top = y + 'px';
    //menu.classList.remove('fa-times');
    //navbar.classList.remove('active');
};
var selectedItems = [];
var selecteditem_info = [];

// Function to add a new item to the cart
function addNewItem(info, selected) {
    
    console.log("add_to_cart info:", info);
    console.log("add_to_cart selected:", selected);
    items = [];
    for(let i = 0; i < selected.length; i++){
        var newItem = {
            id: info[0],
            name: info[1],
            price: info[2],
  
  
            color: selected[i][1],
            size: selected[i][2][0],
            quantity: selected[i][3]
        };

        items.push(newItem);
    }
    console.log("add_to_cart :", items);
    

    var cartData = localStorage.getItem('cartData');
    cartData = cartData ? JSON.parse(cartData) : [];
    cartData.push(items);
    localStorage.setItem('cartData', JSON.stringify(cartData));
 }

function read_item(list, parent){
    var currentForm = 0;
    var selectedShop = "";
    var selectedColor = "";
    var selectedSize = null;
    var selectedQty = 0;
    //var selectedItems = [];
    var isChangeQty;
    var givenQty;
    var itemList;
    var formFrame = null;
    
    function read_code(vs_info, shop_s, color_s, size_s) {
        let a_u_list = [];
        let shops = [];
        let colors = [];
        let sizes = [];
        
        let fbsr = vs_info.replace("\"{", "{");
        let lbsr = fbsr.replace("}\"", "}") + ",";
        alert("reading list : " + list);
        alert("reading list : " + lbsr);
        let main_info = lbsr.split("},");

        for (let m = 0; m < main_info.length - 1; m++) {
            let main_value = main_info[m].split(",(");
            let shop_name = main_value[0].replace("{", "").trim();

            if (shop_s === "" || shop_s === shop_name) {
                shops.push(shop_name);
            }

            let shop = [shop_name];
            let shop_node = [];

            t = main_value[1].replace(")", "") + ",";
            let f_info = t.split(">,");

            for (let c = 0; c < f_info.length - 1; c++) {
                let f_value = f_info[c].split(",[");
                let color_txt = f_value[0].replace("<", "").trim();

                if ((shop_s !== "" && shop_s === shop_name) &&
                    (color_s === "" || color_s === color_txt)) {
                    colors.push(color_txt);
                }

                let color = [color_txt];
                let color_node = [];

                t = f_value[1].replace("]", "") + ",";
                let s_info = t.split("|,");

                for (let s = 0; s < s_info.length - 1; s++) {
                    let s_value = s_info[s].split(", ");

                    if (s_value.length <= 1) {
                        s_value = s_info[s].split(",");
                    }

                    let s_n = [];
                    for (let si = 0; si < s_value.length - 1; si++) {
                        if ((shop_s !== "" && shop_s === shop_name) &&
                            (color_s !== "" && color_s === color_txt) &&
                            (size_s === "" || size_s === s_value[si].replace("|", "").trim())) {
                            if (si === 0) {
                                sizes.push(s_value[si].replace("|", "").trim());
                            }
                        }

                        s_n.push(s_value[si].replace("|", "").trim());
                    }

                    color_node.push(s_n);
                }

                color.push(color_node);
                shop_node.push(color);
            }

            shop.push(shop_node);
            a_u_list.push(shop);
        }

        return [shops, colors, sizes, a_u_list];
    }

    function star() {
        formFrame = null;
        currentForm = 0;
        nextForm();
    }
    function clear(){
        while (parent.firstChild) {
            parent.removeChild(parent.firstChild);
        }
    }

    function createFormFrame() {
        clear();
        formFrame = document.createElement("div");
        parent.appendChild(formFrame);
    }

    function nextForm() {
        if (formFrame !== null) {
            parent.removeChild(formFrame);
        }

        createFormFrame();

        if (currentForm === 0) {
            displayShopButtons();
        } else if (currentForm === 1) {
            displayColorButtons();
        } else if (currentForm === 2) {
            displaySizeButtons();
        } else if (currentForm === 3) {
            displayQuantityEntry();
        } else if (currentForm === 4) {
            showSelectedItems();
        }
    }

    function prevForm() {
        currentForm--;
        nextForm();
    }

    function displayShopButtons() {
        itemList.forEach(function (shop) {
            var button = document.createElement("button");
            button.innerHTML = shop[0];
            button.addEventListener("click", function () {
                selectShop(shop[0]);
            });
            formFrame.appendChild(button);
        });

        var backButton = document.createElement("button");
        backButton.innerHTML = "Back";
        backButton.addEventListener("click", function () {
            prevForm();
        });
        formFrame.appendChild(backButton);
    }

    function displayColorButtons() {
        var colors = getColors();

        colors.forEach(function (color) {
            var button = document.createElement("button");
            button.innerHTML = color;
            button.addEventListener("click", function () {
                selectColor(color);
            });
            formFrame.appendChild(button);
        });

        var backButton = document.createElement("button");
        backButton.innerHTML = "Back";
        backButton.addEventListener("click", function () {
            prevForm();
        });
        formFrame.appendChild(backButton);
    }
    
    function displaySizeButtons() {
        selected_size = null;
        selectedQty = 0;
        let out = null;
        let sizeCount = getSizes().length;
        let sizeLabel = document.createElement("label");
        sizeLabel.textContent = "Size: " + sizeCount;
        formFrame.appendChild(sizeLabel);
        
        let qtyLabel = document.createElement("label");
        qtyLabel.textContent = "Quantity: " + getQtys();
        formFrame.appendChild(qtyLabel);
        
        let selectSizeLabel = document.createElement("label");
        selectSizeLabel.textContent = "Select Size:";
        formFrame.appendChild(selectSizeLabel);
        
        for (let size of getSizes()) {
            let txt = size[0] + "(" + size[3] + ")";
            out = size;
            let sizeButton = document.createElement("button");
            sizeButton.textContent = txt;
            sizeButton.addEventListener("click", () => {
            selectSize(size);
            });
            formFrame.appendChild(sizeButton);
        }
        
        var backButton = document.createElement("button");
        backButton.innerHTML = "Back";
        backButton.addEventListener("click", function () {
            prevForm();
        });
        formFrame.appendChild(backButton);
        
        let buttonCount = Array.from(formFrame.children).filter(child => child.tagName === "BUTTON").length;
        if (buttonCount === 2 && out) {
            selectSize(out);
        }
    }

    function displayQuantityEntry() {
        selectedQty = 0;
        
        var qtyLabel = document.createElement("label");
        qtyLabel.textContent = "Quantity: " + String(getQtys());
        formFrame.appendChild(qtyLabel);
        
        var enterQtyLabel = document.createElement("label");
        enterQtyLabel.textContent = "Enter Quantity:";
        formFrame.appendChild(enterQtyLabel);
        
        qty_entry = document.createElement("input");
        selectedQty = 0;
        qty_entry.value = "1";
        formFrame.appendChild(qty_entry);
        
        var backButton = document.createElement("button");
        backButton.innerHTML = "Back";
        backButton.addEventListener("click", function () {
            prevForm();
        });
        formFrame.appendChild(backButton);
        
        var addToCartButton = document.createElement("button");
        addToCartButton.innerHTML = "Save";
        addToCartButton.addEventListener("click", function () {
            add_to_cart(qty_entry.value);
        });
        formFrame.appendChild(addToCartButton);
        
    }

    function add_to_cart(value) {
        console.log("add_to_cart :" + value);
        
        if (selectedShop && selectedColor && selectedSize) {
            console.log("add_to_cart :");
            
            if (selectedQty === 0) {
                selectedQty = value;
            }
            
            var item = [selectedShop, selectedColor, selectedSize, selectedQty];
            selectedItems.push(item);
            console.log("true :" + String(selectedItems));
            
            show_selected_items();
        } else {
            tk.messagebox.showerror("Error", "Please complete the selection.");
        }
    }



    function selectShop(shop) {
        selectedShop = shop;
        currentForm++;
        nextForm();
    }

    function selectColor(color) {
        selectedColor = color;
        currentForm++;
        nextForm();
    }

    function selectSize(size) {
        selectedSize = size;
        currentForm++;
        nextForm();
    }

    function addCartItem(qty) {
        selectedQty = qty;
        currentForm++;
        selectedItems.push([selectedShop, selectedColor, selectedSize, selectedQty]);
        nextForm();
    }

    function changeQuantity() {
        selectedQty = givenQty;
        currentForm++;
        nextForm();
    }

    function showSelectedItems() {
        var list = document.createElement("ul");

        selectedItems.forEach(function (item) {
            var listItem = document.createElement("li");
            listItem.innerHTML = item[0] + " - " + item[1] + " - " + item[2] + " - " + item[3];
            list.appendChild(listItem);
        });

        formFrame.appendChild(list);
    }

    function getColors() {
        let colors = [];
        for (let shop of itemList) {
            if (shop[0] === selectedShop) {
            return shop[1].map(color => color[0]);
            }
            for (let color of shop[1]) {
            if (!colors.includes(color[0])) {
                colors.push(color[0]);
            }
            }
        }
        return colors;
    }

    function getSizes() {
        var sizes = [];
        for (var shop of itemList) {
            if (shop[0] === selectedShop) {
            for (var color of shop[1]) {
                if (color[0] === selectedColor) {
                return color[1];
                }
            }
            for (var color of shop[1]) {
                for (var size of color[1]) {
                if (!sizes.includes(size[0])) {
                    sizes.push(size[0]);
                }
                }
            }
            break;
            }
        }
        if (sizes.length === 0) {
            for (var shop of itemList) {
            for (var color of shop[1]) {
                for (var size of color[1]) {
                if (!sizes.includes(size[0])) {
                    sizes.push(size[0]);
                }
                }
            }
            }
        }
        return sizes;
    }

    function getQtys() {
        var q = 0;
        for (var shop of itemList) {
            if (shop[0] === selectedShop) {
            for (var color of shop[1]) {
                if (color[0] === selectedColor) {
                for (var size of color[1]) {
                    if (selectedSize === size) {
                    return size[3];
                    }
                }
                for (var size of color[1]) {
                    if (size && parseFloat(size[3]) > 0) {
                    console.log("qty1 : " + size + " | " + size[3] + "+" + q + "=" + (q + parseFloat(size[3])));
                    q += parseFloat(size[3]);
                    }
                }
                break;
                }
            }
            if (q === 0) {
                for (var color of shop[1]) {
                for (var size of color[1]) {
                    if (size && parseFloat(size[3]) > 0) {
                    console.log("qty2 : " + size + " | " + size[3] + "+" + q + "=" + (q + parseFloat(size[3])));
                    q += parseFloat(size[3]);
                    }
                }
                }
            }
            break;
            }
        }
        if (q === 0) {
            for (var shop of itemList) {
            for (var color of shop[1]) {
                for (var size of color[1]) {
                if (size && parseFloat(size[3]) > 0) {
                    console.log("qty3 : " + size + " | " + size[3] + "+" + q + "=" + (q + parseFloat(size[3])));
                    q += parseFloat(size[3]);
                }
                }
            }
            }
        }
        return q;
    }

    function show_selected_items() {
        //clear();
        var result_frame = document.createElement("div");
        result_frame.classList.add('selected_items_box');
        formFrame.appendChild(result_frame);
        var label = document.createElement("label");
        label.textContent = "Selected Items:";
        result_frame.appendChild(label);
        for (var item of selectedItems) {
            var itemLabel = document.createElement("label");
            itemLabel.classList.add('selected_items');
            itemLabel.textContent = item;
            result_frame.appendChild(itemLabel);
        }
        var addButton = document.createElement("button");
        addButton.textContent = "Add";
        addButton.addEventListener("click", () => add());
        formFrame.appendChild(addButton);
    }

    function add(){
        clear();
        currentForm = 0;
        star();
    }
    
    isChangeQty = "";
    givenQty = "";
    
    if(list){
        let [, , , nested_list] = read_code(list, "", "", "");
        itemList = nested_list;
        console.log(itemList);
        selectedShop = "";
        selectedColor = "";
        selectedSize = null;
        selectedQty = 0;
        star();
    }
}

function View_Selected(vs_info, vs_id, vs_n, vs_price, vs_img, vs_path, vs_dic, vs_info1) {
    selectedItems = [];
    selecteditem_info = [];
    document.getElementById('view-form').style.display='block'; 
    var sy = scrollY;
    var y = sy;
    
    //<input type="hidden" name="product_name" class="p_name" value="">
    document.querySelector('#view-form .p_name').value = vs_n;
    document.querySelector('#view-form .p_name').innerText = vs_n;
    selecteditem_info.push(vs_id);
    selecteditem_info.push(vs_n);
    selecteditem_info.push(vs_price); 
    document.querySelector('#view-form .info_Box .sub_info_Box .p_name').innerText = vs_n;
    //<input type="hidden" name="product_code" class="p_code" value="">
    //document.querySelector('#view-form .p_code').value = vs_price;
    //<input type="hidden" name="product_type" class="p_type" value="">
    //document.querySelector('#view-form .p_type').value = vs_price;
    //<input type="hidden" name="product_image" class="p_img" value="">
    var list = document.querySelector('#view-form .info_Box .img_box');
    alert([vs_info1, vs_id, vs_n, vs_price, vs_img, vs_path, vs_dic, vs_info]);
    for(var z = 0; z <= list.children.length-1; z++){
        list.children[z].remove();
    }
    if(vs_img){
            for(var m = 0; vs_img.split("~")[m]; m++){
            var img = document.createElement('img');
            //alert("image "+  vs_path + "/" + vs_img.split("~")[m]);
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
    }

    //<input type="hidden" name="product_price" class="p_price" value="">
    document.querySelector('#view-form .p_price').value = vs_price;
    document.querySelector('#view-form .p_price').innerText = vs_price;
    document.querySelector('#view-form .info_Box .sub_info_Box .p_price').innerText = "R" + vs_price;
    //<input type="hidden" name="product_path" class="p_path" value="">
    document.querySelector('#view-form .p_path').value = vs_price;
    //<input type="hidden" name="product_info" class="p_info" value="">
    document.querySelector('#view-form .p_info').value = vs_info;

    document.querySelector('#view-form .p_disc').innerText = vs_dic;
    document.querySelector('#view-form .info_Box .sub_info_Box .p_disc').innerText = vs_dic;

    //{l,[|black,2|,|green,3|,|white,5|,]},{xl,[|white,5|,|black,2|,|green,6|,]},
    console.log("vs_info>>"+vs_info);

    read_item(vs_info, document.getElementById("selection_box_id"))


    document.querySelector('#view-form').style.top = y + 'px';
    document.getElementById('shopping-cart-form').style.display='none'; 
    document.getElementById('login-form').style.display='none';
}

function disply_item(vs_id, vs_n, vs_At_Shop, vs_type, vs_code, vs_price, vs_img, vs_path, vs_dic, vs_info) {
    var sy = scrollY;
    var y = sy;
    
    
    const view_Box = document.createElement('div');
    view_Box.classList.add('view');
    view_Box.id = 'view-form';
    view_Box.style.display='none'; 
    vs_mainu.appendChild(view_Box);
    const view_Boxclose_btn = document.createElement('input');
    view_Box.appendChild(view_Boxclose_btn);
    view_Boxclose_btn.value = "x";
    view_Boxclose_btn.style.width ="10px";
    view_Boxclose_btn.style.background ="border-box";
    view_Boxclose_btn.style.color ="red";
    view_Boxclose_btn.style.position ="absolute";
    view_Boxclose_btn.style.right ="0%";
    view_Boxclose_btn.addEventListener('click', ()=>{
        selectedItems = [];
        selecteditem_info = [];
        document.querySelector('#view-form').style.display = 'none';
    });
    
    
    var shop_name = (vs_At_Shop + " ").split(' ');
    var na = vs_n.replaceAll(' ', '_');
    
    var path = ("img\\" + shop_name[0] + "\\products\\" + (vs_type).replaceAll(' ', '\\') + "\\"+ na + "\\"+ vs_code).replaceAll('\\\\', '\\');
    var images = (vs_img + "~").split('~');
    console.log(images[0]);
    
    const viewbox_title = document.createElement('h1');
    viewbox_title.classList.add('heading_viewbox_title');
    viewbox_title.value = "View";
    view_Box.appendChild(viewbox_title);
    
    /// other info box that will hold all info about item
    const info_Box = document.createElement('div');
    view_Box.appendChild(info_Box);
    info_Box.classList.add('info_Box');
    
    // image box that will be created image 
    const Images_Box = document.createElement('div');
    info_Box.appendChild(Images_Box);
    Images_Box.classList.add('img_box');
    
    // item info will be desplyed in this box
    const otherinfo_Box = document.createElement('div');
    info_Box.appendChild(otherinfo_Box);
    otherinfo_Box.classList.add('sub_info_Box');
    
    const p_name_title = document.createElement('h1');
    p_name_title.classList.add('p_name');
    p_name_title.value = vs_n;
    p_name_title.innerText = vs_n;
    otherinfo_Box.appendChild(p_name_title);
    
    const p_price_info = document.createElement('h1');
    p_price_info.classList.add('p_price');
    p_price_info.value = "R" + vs_price;
    p_price_info.innerText = "R" + vs_price;
    otherinfo_Box.appendChild(p_price_info);

    const p_disc_info = document.createElement('h1');
    p_disc_info.classList.add('p_disc');
    p_disc_info.value = "color_box_id";
    p_disc_info.innerText = vs_dic;
    otherinfo_Box.appendChild(p_disc_info);

    const size_info_id = document.createElement('div');
    otherinfo_Box.appendChild(size_info_id);
    size_info_id.id = "selection_box_id";
    size_info_id.value = "View";
    size_info_id.classList.add('selection_box');
    
    for(var z = 0; z <= Images_Box.children.length-1; z++){
        Images_Box.children[z].remove();
    }

    for(var m = 0; images[m]; m++){
        var img = document.createElement('img');
        alert("image "+  path + "/" + images[m]);
        img.src =  path + "/" + images[m];
        Images_Box.appendChild(img);
        
        Images_Box.value = "0";
        for(var z = 0; z <= Images_Box.children.length-1; z++){
            var n = 100/Images_Box.children.length;
            if(100/3 >= n) n=n;
            else n = 100/3;
            if(z == 0){
                Images_Box.children[z].style.width =String(100)+"%";
                Images_Box.children[z].style.height =String(100-100/4)+"%";
            }
            else {
                Images_Box.children[z].style.width =String(n)+"%";
                Images_Box.children[z].style.height =String(100/4)+"%";
            }
            img.setAttribute('onclick', 'set_img_pos("'+ z + '")');
        }
    }


    // Add the product item element to the product grid container	
    // this form is for buttons 
    const view_form = document.createElement('div');
    view_Box.appendChild(view_form);
            
        const hidden_info_name = document.createElement('input');
        view_form.appendChild(hidden_info_name);
        hidden_info_name.classList.add('p_name');
        hidden_info_name.name="product_name";
        //<input type="hidden" name="product_name" class="p_name" value="">
        hidden_info_name.value = vs_n;
    hidden_info_name.innerText = vs_n;

    hidden_info_name.hidden = true;
    const hidden_info_code = document.createElement('input');
    view_form.appendChild(hidden_info_code);
    hidden_info_code.classList.add('p_code');
    hidden_info_code.name="product_code";
    hidden_info_code.value = vs_price;
    hidden_info_code.hidden = true;
    
    const hidden_info_type = document.createElement('input');
    view_form.appendChild(hidden_info_type);
    hidden_info_type.classList.add('p_type');
    hidden_info_type.name="product_type";
    hidden_info_type.value = vs_price;
    hidden_info_type.hidden = true;
    
    const hidden_info_imge = document.createElement('input');
    view_form.appendChild(hidden_info_imge);
    hidden_info_imge.classList.add('p_img');
    hidden_info_imge.name="product_image";
    hidden_info_imge.value= "";
    hidden_info_imge.hidden = true;
    
    const hidden_info_price = document.createElement('input');
    view_form.appendChild(hidden_info_price);
    hidden_info_price.classList.add('p_price');
    hidden_info_price.name="product_price";
    hidden_info_price.value = vs_price;
    hidden_info_price.innerText = vs_price;
    hidden_info_price.hidden = true;
    
    const hidden_info_disc = document.createElement('input');
    view_form.appendChild(hidden_info_disc);
    hidden_info_disc.classList.add('p_disc');
    hidden_info_disc.name="product_disc";
    hidden_info_disc.innerText = vs_dic;
    hidden_info_disc.value = vs_dic;
    hidden_info_disc.hidden = true;
    
    const hidden_info_info = document.createElement('input');
    view_form.appendChild(hidden_info_info);
    hidden_info_info.classList.add('p_info');
    hidden_info_info.name="product_info";

    hidden_info_info.value = vs_info;
    hidden_info_info.hidden = true;
    const hidden_info_size = document.createElement('input');
    view_form.appendChild(hidden_info_size);
    hidden_info_size.classList.add('p_size');
    hidden_info_size.name="product_size";
    hidden_info_size.value= "";
    hidden_info_size.hidden = true;
    const hidden_info_color = document.createElement('input');
    view_form.appendChild(hidden_info_color);
    hidden_info_color.classList.add('p_color');
    hidden_info_color.name="product_color";
    hidden_info_color.value= "";
    hidden_info_color.hidden = true;
    const hidden_info_path = document.createElement('input');
    view_form.appendChild(hidden_info_path);
    hidden_info_path.classList.add('p_path');
    hidden_info_path.name="product_path";
    hidden_info_path.value= path;
    hidden_info_path.hidden = true;


    const do_btn = document.createElement('div');
    view_form.appendChild(do_btn);
    do_btn.classList.add('view_btn_form');

    const do_like_btn = document.createElement('button');
    do_btn.appendChild(do_like_btn);
    do_like_btn.classList.add('btns');
    do_like_btn.name="add_to_cart";
    do_like_btn.innerText= "like";
    do_like_btn.value= "like";
    
    const do_buy_btn = document.createElement('button');
    do_btn.appendChild(do_buy_btn);
    do_buy_btn.classList.add('btns');
    do_buy_btn.name="add_to_cart";
    do_buy_btn.innerText= "Buy";
    do_buy_btn.value= "Buy";
    
    const do_cart_btn = document.createElement('button');
    do_btn.appendChild(do_cart_btn);
    do_cart_btn.classList.add('btns');
    do_cart_btn.classList.add('btns_add_to_cart');
    do_cart_btn.name="add_to_cart";
    do_cart_btn.value= "Add to cart";
    do_cart_btn.innerText= "Add to cart";
    do_cart_btn.addEventListener('click', function() {
		addNewItem(selecteditem_info, selectedItems);
	});
    
//{l,[|black,2|,|green,3|,|white,5|,]},{xl,[|white,5|,|black,2|,|green,6|,]},
/*console.log("disply_item vs_info>>"+vs_info);

read_item("{FLAG_SQUARE,(<FRUATE,[|2X10, , 23, -6.0, , |]>)},", document.getElementById("size_box_id"))
var main_info = (vs_info + "}").split("},");
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
    size_info_id.appendChild(item);
}*/
    var ya  = y+ vs_mainu.scrollTop
    view_Box.style.top = ya + 'px';
}

disply_item("", "", "", "", "", "", "", "", "", "");

window.onscroll = () => {
    var mainy = 150;
    var sy = scrollY; 
var sy = scrollY; 
var y = mainy + sy;
var vs_mainu = document.querySelector('body .Main');
var ya  = y+ vs_mainu.scrollTop
document.getElementById('view-form').style.top = ya + 'px';
    document.querySelector('#shopping-cart-form').style.top = y + 'px';
    //menu.classList.remove('fa-times');
    //navbar.classList.remove('active');
};
