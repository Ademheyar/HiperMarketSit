
var selecteditem_info = [];

// Select the table element

// Function to add a new item to the cart
function addNewItem(info, selected) {
    
    console.log("add_to_cart info:", info);
    console.log("add_to_cart selected:", selected);
    var activeChartIndex = localStorage.getItem('activeChartIndex');
    activeChartIndex = !activeChartIndex ? 0 : activeChartIndex;
    
      var activeChartData = localStorage.getItem('ActiveChartData');
      var activeChartData = activeChartData ? JSON.parse(activeChartData) : [];
      
      var iscartData = activeChartData[activeChartIndex];
      var cartData = iscartData ? iscartData : [];
      
    for(let i = 0; i < selected.length; i++){
        var newItem = {
            id: info[0],
            name: info[1],
            price: info[2],
            Images: info[3],
            shop: info[4],
            
            discount: 0,
            Price: info[2],
            Quantity: selected[i][4],
            
            code: selected[i][1],
            color: selected[i][2],
            size: selected[i][3],
            quantity: selected[i][4]
        };

        cartData.push(newItem);
    }
    
    activeChartData[activeChartIndex] = cartData;
    localStorage.setItem('activeChartIndex', activeChartIndex);
      localStorage.setItem('ActiveChartData', JSON.stringify(activeChartData));
    console.log("add_to_cart :", cartData);
    updte_chat_lenght();
 }




function read_item(list, parent, selectedItems, done_func){
    var currentForm = 0;
    var selectedShop = "";
    var selectedCode = "";
    var selectedColor = "";
    var selectedSize = null;
    var selectedQty = 0;
    var selectedbarcode = "";
    
    //var selectedItems = [];
    var isChangeQty;
    var givenQty;
    var itemList;
    var formFrame = null;
    var result_frame;
    let table;

    function star() {

        formFrame = document.createElement("div");
        parent.appendChild(formFrame);

        result_frame = document.createElement("div");
        result_frame.classList.add('selected_items_box');
        parent.appendChild(result_frame);
        
        var label = document.createElement("label");
        label.textContent = "Selected Items:";
        result_frame.appendChild(label);

        table = document.createElement('table');
        result_frame.appendChild(table);
        
        table.setAttribute('border', '1');
        result_frame.style.display = "block";
        result_frame.style.overflowX = 'auto'; // = 'auto-fit';
        //result_frame.style.height = "25%";
 
        table.style.borderCollapse = 'collapse'; // = 'auto-fit';
        table.style.borderSpacing = '0'; // = 'auto-fit';
        table.style.borderRadius = '12px 12px 0 0'; // = 'auto-fit';
        table.style.boxShadow = '0 12px 12px rgba(32, 32, 32, .3)'; // = 'auto-fit';
        table.style.background = '#fafafa'; // = 'auto-fit';
        table.style.textAlign = 'center'; // = 'auto-fit';

        var addButton = document.createElement("button");
        addButton.textContent = "Add";
        addButton.addEventListener("click", () => add());
        formFrame.appendChild(addButton);
        addButton.style.width ="auto";
        addButton.style.gap ="10px";
        addButton.style.padding ="revert";
        addButton.style.border ="outset";
        addButton.style.display ="inline-flex";
        addButton.style.size ="auto";
        currentForm = 0;
        nextForm();
    }

    function clear(){
        while (formFrame.firstChild) {
            formFrame.removeChild(formFrame.firstChild);
        }
    }

    function createFormFrame() {
        
        
    }

    function nextForm() {
        /*if (formFrame !== null) {
            parent.removeChild(formFrame);
        }*/
        clear();
        //createFormFrame();

        if (currentForm === 0) {
            displayShopButtons();
        } else if (currentForm === 1) {
            displayCodeButtons();
        } else if (currentForm === 2) {
            displayColorButtons();
        } else if (currentForm === 3) {
            displaySizeButtons();
        } else if (currentForm === 4) {
            displayQuantityEntry();
        } else if (currentForm === 5) {
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
            button.style.width ="auto";
            button.style.gap ="10px";
            button.style.padding ="revert";
            button.style.border ="outset";
            button.style.display ="inline-flex";
            button.style.size ="auto";
        });

        var backButton = document.createElement("button");
        backButton.innerHTML = "Back";
        backButton.addEventListener("click", function () {
            prevForm();
        });
        formFrame.appendChild(backButton);
        backButton.style.width ="auto";
        backButton.style.gap ="10px";
        backButton.style.padding ="revert";
        backButton.style.border ="outset";
        backButton.style.display ="inline-flex";
        backButton.style.size ="auto";
    }

    function displayCodeButtons() {
        var codes = getCodes();

        codes.forEach(function (Code) {
            var button = document.createElement("button");
            button.innerHTML = Code;
            button.addEventListener("click", function () {
                selectCode(Code);
            });
            formFrame.appendChild(button);
            button.style.width ="auto";
            button.style.gap ="10px";
            button.style.padding ="revert";
            button.style.border ="outset";
            button.style.display ="inline-flex";
            button.style.size ="auto";
        });

        var backButton = document.createElement("button");
        backButton.innerHTML = "Back";
        backButton.addEventListener("click", function () {
            prevForm();
        });
        formFrame.appendChild(backButton);
        backButton.style.width ="auto";
        backButton.style.gap ="10px";
        backButton.style.padding ="revert";
        backButton.style.border ="outset";
        backButton.style.display ="inline-flex";
        backButton.style.size ="auto";
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
            button.style.width ="auto";
            button.style.gap ="10px";
            button.style.padding ="revert";
            button.style.border ="outset";
            button.style.display ="inline-flex";
            button.style.size ="auto";
        });

        var backButton = document.createElement("button");
        backButton.innerHTML = "Back";
        backButton.addEventListener("click", function () {
            prevForm();
        });
        formFrame.appendChild(backButton);
        backButton.style.width ="auto";
        backButton.style.gap ="10px";
        backButton.style.padding ="revert";
        backButton.style.border ="outset";
        backButton.style.display ="inline-flex";
        backButton.style.size ="auto";
    }
    
    function displaySizeButtons() {
        selected_size = null;
        selectedQty = 0;
        let out = null;
        /*let sizeCount = getSizes().length;
        let sizeLabel = document.createElement("label");
        sizeLabel.textContent = "Size: " + sizeCount;
        formFrame.appendChild(sizeLabel);
        
        let qtyLabel = document.createElement("label");
        qtyLabel.textContent = "Quantity: " + getQtys();
        formFrame.appendChild(qtyLabel);
        
        let selectSizeLabel = document.createElement("label");
        selectSizeLabel.textContent = "Select Size:";
        formFrame.appendChild(selectSizeLabel);*/
        
        for (let size of getSizes()) {
            out = size;
            let sizeButton = document.createElement("button");
            sizeButton.textContent = size;
            sizeButton.addEventListener("click", () => {
                selectSize(size);
            });
            formFrame.appendChild(sizeButton);
            sizeButton.style.width ="auto";
            sizeButton.style.gap ="10px";
            sizeButton.style.padding ="revert";
            sizeButton.style.border ="outset";
            sizeButton.style.display ="inline-flex";
            sizeButton.style.size ="auto";
        }
        
        var backButton = document.createElement("button");
        backButton.innerHTML = "Back";
        backButton.addEventListener("click", function () {
            prevForm();
        });
        formFrame.appendChild(backButton);
        backButton.style.width ="auto";
        backButton.style.gap ="10px";
        backButton.style.padding ="revert";
        backButton.style.border ="outset";
        backButton.style.display ="inline-flex";
        backButton.style.size ="auto";
        
        /*let buttonCount = Array.from(formFrame.children).filter(child => child.tagName === "BUTTON").length;
        if (buttonCount === 2 && out) {
            selectSize(out);
        }*/
    }

    function displayQuantityEntry() {
        selectedQty = 0;
        
        //var qtyLabel = document.createElement("label");
        //qtyLabel.textContent = "Quantity: " + String(getQtys());
        //formFrame.appendChild(qtyLabel);
        
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
        backButton.style.width ="auto";
        backButton.style.gap ="10px";
        backButton.style.padding ="revert";
        backButton.style.border ="outset";
        backButton.style.display ="inline-flex";
        backButton.style.size ="auto";
        
        var addToCartButton = document.createElement("button");
        addToCartButton.innerHTML = "Save";
        addToCartButton.addEventListener("click", function () {
            var qty= qty_entry.value;
            selectedbarcode = "";
            add_to_cart(qty);
        });
        formFrame.appendChild(addToCartButton);
        addToCartButton.style.width ="auto";
        addToCartButton.style.gap ="10px";
        addToCartButton.style.padding ="revert";
        addToCartButton.style.border ="outset";
        addToCartButton.style.display ="inline-flex";
        addToCartButton.style.size ="auto";

        var doneButton = document.createElement("button");
        doneButton.innerHTML = "Done";
        doneButton.addEventListener("click", function () {
            parent.selectedItems = selectedItems;
            done_func();
        });
        formFrame.appendChild(doneButton);
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

    function selectShop(shop) {
        selectedShop = shop;
        currentForm++;
        nextForm();
    }
    
    function selectCode(code) {
        selectedCode = code;
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


    function showSelectedItems() {
        var list = document.createElement("ul");

        selectedItems.forEach(function (item) {
            var listItem = document.createElement("li");
            listItem.innerHTML = item[0] + " - " + item[1] + " - " + item[2] + " - " + item[3];
            list.appendChild(listItem);
        });

        formFrame.appendChild(list);
    }
    
    function getCodes() {
        let codes = [];
        for (let shop of itemList) {
            if (shop[0] === selectedShop) {
                return shop[1].map(code => code[0]);
            }

            for (let code of shop[1]) {
                if (!codes.includes(code[0])) {
                    codes.push(code[0]);
                }
            }
        }
        return codes;
    }
    
    function getColors() {
        let colors = [];
        for (let shop of itemList) {
            if (shop[0] === selectedShop) {
                for (let code of shop[1]) {
                    if (code[0] === selectedCode) {
                    return code[1].map(color => color[0]);
                    }
                }
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
                for (let code of shop[1]) {
                    if (code[0] === selectedCode) {
                        for (var color of code[1]) {
                            if (color[0] === selectedColor) {
                                for (var size of color[1]) {
                                    if (!sizes.includes(size[0])) {
                                        sizes.push(size[0]);
                                    }
                                }
                            }
                        }
                    }
                }

                for (var code of shop[1]) {
                    for (var color of code[1]) {
                        for (var size of color[1]) {
                            if (!sizes.includes(size[0])) {
                                sizes.push(size[0]);
                            }
                        }
                    }
                }
                break;
            }
        }

        if (sizes.length === 0) {
            for (var shop of itemList) {
                for (var code of shop[1]) {
                    for (var color of code[1]) {
                        for (var size of color[1]) {
                            if (!sizes.includes(size[0])) {
                                sizes.push(size[0]);
                            }
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

    function add_to_cart(value) {
        console.log("add_to_cart :" + value);
        if (selectedShop && selectedCode && selectedColor && selectedSize) {
            
            let item = [selectedShop, selectedCode, selectedColor, selectedSize, value];
            selectedItems.push(item);
            console.log("true :" , selectedItems);
            
            show_selected_items();
        } else {
            tk.messagebox.showerror("Error", "Please complete the selection.");
        }
    }

    function show_selected_items() {
        //clear();
        while (table.firstChild) table.removeChild(table.firstChild);
        
        // Create table header
        const header = table.createTHead();
        const headerRow = header.insertRow();
        ["Shop Name", "Code", "Color", "Size", "Qty"].forEach(headerText => {
            const th = document.createElement('th');
            th.style.padding = '12px 15px'; // = 'auto-fit';
            th.style.backgroundColor = '#333'; // = 'auto-fit';
            th.style.color = '#fff'; // = 'auto-fit';
            th.style.textAlign = 'center'; // = 'auto-fit';
            const text = document.createTextNode(headerText);
            th.appendChild(text);
            headerRow.appendChild(th);
        });

        selectedItems.forEach(item => {
            console.log("item",item);
            
            const tbody = table.createTBody();
            //tbody.style.display = 'inline-flex';
            const btn_divs = document.createElement('div');
            tbody.appendChild(btn_divs);
            btn_divs.className = 'item_editer_btns';
            btn_divs.style.width = '100%'
            btn_divs.style.height = '100%'
            btn_divs.style.display = 'none';

            const DeleteItem_btn = document.createElement('button');
            btn_divs.appendChild(DeleteItem_btn);
            //DeleteItem_btn.classList.add('lcb_1btns');
            //DeleteItem_btn.name = 'add_to_cart';
            DeleteItem_btn.innerText = 'Delete';
            DeleteItem_btn.style.backgroundColor = 'red';
            DeleteItem_btn.style.width = '100%'
            DeleteItem_btn.style.height = '100%'
            DeleteItem_btn.style.marginTop = '1rem';
            DeleteItem_btn.style.position = 'inherit';
            //DeleteItem_btn.style.display = 'none';
            let tr = tbody.insertRow();
            for (let i = 0; i < ["Shop Name", "Code", "Color", "Size", "Qty"].length; i++) {
                const td = tr.insertCell();
                td.textContent = item[i];
                td.addEventListener('click', function() {
                    let parent_tbody = tbody.parentElement;
                    if (tbody.style.backgroundColor != "lightblue") {
                        for (let index = 0; index < parent_tbody.childNodes.length; index++) {
                            const element = parent_tbody.childNodes[index];
                            if(element.tagName == "TBODY") {
                                element.style.backgroundColor = '';
                                element.querySelector('.item_editer_btns').style.display = 'none';
                            }
                        }
                        tbody.style.backgroundColor = 'lightblue';
                    }
                    else btn_divs.style.display = 'flex';
                });
            }
        });
    }

    function add(){
        currentForm = 0;
        clear();
    }
    
    isChangeQty = "";
    givenQty = "";
    
    if(list){
        itemList = JSON.parse(list);
        console.log(itemList);
        selectedShop = "";
        selectedColor = "";
        selectedSize = null;
        selectedQty = 0;
        star();
    }
}



 
function View_Selected(vs_info, vs_id, vs_n, vs_price, vs_img, vs_dic, vs_At_Shop, vs_type, vs_code, vs_path, vs_info1) {
    console.log("selected item info1 vs_info >>" , vs_info);
    console.log("selected item info1 vs_id >>" , vs_id);
    console.log("selected item info1 vs_n >>" , vs_n);
    console.log("selected item info1 vs_price >>" , vs_price);
    console.log("selected item info1 vs_img >>" , vs_img);
    console.log("selected item info1 vs_dic >>" , vs_dic);
    console.log("selected item info1 vs_At_Shop >>" , vs_At_Shop);
    console.log("selected item info1 vs_type >>" , vs_type);
    console.log("selected item info1 vs_code >>" , vs_code);
    console.log("selected item info1 vs_path >>" , vs_path);
    console.log("selected item info1 vs_info1 >>" , vs_info1);
    
    var selectedItems = [];
    selecteditem_info = [];
    var sy = scrollY;
    var y = sy;
  
    var vi_mainu = document.querySelector('body');
    const view_Box = document.createElement('div');
    view_Box.style.fontSize = "small";
    view_Box.style.width = "100%";
    view_Box.style.height = "100vh";
    view_Box.style.background = "rgba(0,0,0,.3)";
    view_Box.style.padding = "18px";
    view_Box.style.overflow = "hidden";
    view_Box.style.position = "fixed";
    view_Box.style.top = "0";
    view_Box.style.left = "0";
    //view_Box.style.display = "flex";
    view_Box.style.alignItems = "center";
    view_Box.style.justifyContent = "center";
    view_Box.style.zIndex = "1000";
    vi_mainu.appendChild(view_Box);


    // CREATE PARENTS FIRST
    const info_Box = document.createElement('div');
    const history_Box = document.createElement('div');
    const view_form = document.createElement('div');
    const do_btn = document.createElement('div');

    // ----------------------------------------Create VIEW PARENT FORM CHILDES
        //view_Box.classList.add('view');
    //view_Box.id = 'view-form';
    //view_Box.style.display='none'; 
    // Add the product item element to the product grid container	
    // this form is for buttons 
    //const view_form = document.createElement('div');
    //view_form.id = 'viewfome_panal';
    const hidden_info_name = document.createElement('input');
    view_form.appendChild(hidden_info_name);
    //hidden_info_name.classList.add('p_name');
    hidden_info_name.name="product_name";
    hidden_info_name.value = vs_n;
    hidden_info_name.innerText = vs_n;

    hidden_info_name.hidden = true;
    const hidden_info_code = document.createElement('input');
    view_form.appendChild(hidden_info_code);
    //hidden_info_code.classList.add('p_code');
    hidden_info_code.name="product_code";
    hidden_info_code.value = vs_price;
    hidden_info_code.hidden = true;
    
    const hidden_info_type = document.createElement('input');
    view_form.appendChild(hidden_info_type);
    //hidden_info_type.classList.add('p_type');
    hidden_info_type.name="product_type";
    hidden_info_type.value = vs_price;
    hidden_info_type.hidden = true;
    
    const hidden_info_imge = document.createElement('input');
    view_form.appendChild(hidden_info_imge);
    //hidden_info_imge.classList.add('p_img');
    hidden_info_imge.name="product_image";
    hidden_info_imge.value= "";
    hidden_info_imge.hidden = true;
    
    const hidden_info_price = document.createElement('input');
    view_form.appendChild(hidden_info_price);
    //hidden_info_price.classList.add('p_price');
    hidden_info_price.name="product_price";
    hidden_info_price.value = vs_price;
    hidden_info_price.innerText = vs_price;
    hidden_info_price.hidden = true;
    
    const hidden_info_disc = document.createElement('input');
    view_form.appendChild(hidden_info_disc);
    //hidden_info_disc.classList.add('p_disc');
    hidden_info_disc.name="product_disc";
    hidden_info_disc.innerText = vs_dic;
    hidden_info_disc.value = vs_dic;
    hidden_info_disc.hidden = true;
    
    const hidden_info_info = document.createElement('input');
    view_form.appendChild(hidden_info_info);
    //hidden_info_info.classList.add('p_info');
    hidden_info_info.name="product_info";

    hidden_info_info.value = vs_info;
    hidden_info_info.hidden = true;
    const hidden_info_size = document.createElement('input');
    view_form.appendChild(hidden_info_size);
    //hidden_info_size.classList.add('p_size');
    hidden_info_size.name="product_size";
    hidden_info_size.value= "";
    hidden_info_size.hidden = true;
    const hidden_info_color = document.createElement('input');
    view_form.appendChild(hidden_info_color);
    //hidden_info_color.classList.add('p_color');
    hidden_info_color.name="product_color";
    hidden_info_color.value= "";
    hidden_info_color.hidden = true;
    const hidden_info_path = document.createElement('input');
    view_form.appendChild(hidden_info_path);
    //hidden_info_path.classList.add('p_path');
    hidden_info_path.name="product_path";
    hidden_info_path.value= vs_path;
    hidden_info_path.hidden = true;
    
  
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
      view_Box.remove();
  });

    //sec_shop_name
    
    console.log("in View_Selected 1");
    var shop_name = (vs_At_Shop + " ").split(' ');
    var na = vs_n.replaceAll(' ', '_');
    
    //var path = ("img\\" + shop_name[0] + "\\products\\" + (vs_type).replaceAll(' ', '\\') + "\\"+ na + "\\"+ vs_code).replaceAll('\\\\', '\\');
    var images = vs_img;
    console.log(images[0]);
    
    const viewbox_title = document.createElement('h1');
    //viewbox_title.classList.add('heading_viewbox_title');
    viewbox_title.value = "View";
    view_Box.appendChild(viewbox_title);
    
    /// other info box that will hold all info about item
    const tabbtn_Box = document.createElement('div');
    view_Box.appendChild(tabbtn_Box);
    //tabbtn_Box.classList.add('tabbtn_Box');
    tabbtn_Box.style.width ="100%";
    tabbtn_Box.style.height ="auto";
    tabbtn_Box.style.background ="rgba(0,0,0,.3)";
    tabbtn_Box.style.padding ="3px";
    tabbtn_Box.style.display ="inline-flex";
    tabbtn_Box.style.color ="aliceblue";
    tabbtn_Box.style.position ="relative";
    


    const select_tab_btn = document.createElement('button');
    tabbtn_Box.appendChild(select_tab_btn);
    select_tab_btn.style.width ="auto";
    select_tab_btn.style.height ="auto";
    select_tab_btn.style.gap ="10px";
    select_tab_btn.style.background ="rgba(0,0,0,.3)";
    select_tab_btn.style.padding ="revert";
    select_tab_btn.style.border ="outset";
    select_tab_btn.style.display ="inline-flex";
    select_tab_btn.style.color ="aliceblue";
    select_tab_btn.style.position ="relative";
    select_tab_btn.style.size ="auto";
    //select_tab_btn.classList.add('btns');
    select_tab_btn.name="select_tab_btn";
    select_tab_btn.innerText= "Select";
    select_tab_btn.value= "Select";
    select_tab_btn.addEventListener('click', ()=>{
        info_Box.style.display = 'inline-flex';
        view_form.style.display = 'block';
        history_Box.style.display = 'none';
    });

    const history_tab_btn = document.createElement('button');
    tabbtn_Box.appendChild(history_tab_btn);
    history_tab_btn.style.width ="auto";
    history_tab_btn.style.height ="auto";
    history_tab_btn.style.gap ="10px";
    history_tab_btn.style.background ="rgba(0,0,0,.3)";
    history_tab_btn.style.padding ="revert";
    history_tab_btn.style.border ="outset";
    history_tab_btn.style.display ="inline-flex";
    history_tab_btn.style.color ="aliceblue";
    history_tab_btn.style.position ="relative";
    history_tab_btn.style.size ="auto";
    //history_tab_btn.classList.add('btns');
    history_tab_btn.name="history_tab_btn";
    history_tab_btn.innerText= "History";
    history_tab_btn.value= "History";
    history_tab_btn.addEventListener('click', ()=>{
        info_Box.style.display = 'none';
        view_form.style.display = 'none';
        history_Box.style.display = 'block';
    });
    console.log("in View_Selected 3");
    const about_tab_btn = document.createElement('button');
    tabbtn_Box.appendChild(about_tab_btn);
    about_tab_btn.style.width ="auto";
    about_tab_btn.style.height ="auto";
    about_tab_btn.style.gap ="10px";
    about_tab_btn.style.background ="rgba(0,0,0,.3)";
    about_tab_btn.style.padding ="revert";
    about_tab_btn.style.border ="outset";
    about_tab_btn.style.display ="inline-flex";
    about_tab_btn.style.color ="aliceblue";
    about_tab_btn.style.position ="relative";
    about_tab_btn.style.size ="auto";
    //about_tab_btn.classList.add('btns');
    about_tab_btn.name="about_tab_btn";
    about_tab_btn.innerText= "About";
    about_tab_btn.value= "About";
    about_tab_btn.addEventListener('click', ()=>{
        info_Box.style.display = 'none';
        view_form.style.display = 'none';
    });


    /// other info box that will hold all info about item
    

    // ----------------------------------------Create info_Box PARENT FORM CHILDES
    //info_Box.classList.add('info_Box');
    info_Box.id = 'info_Box-panal';
    info_Box.style.width ="100%";
    info_Box.style.height ="auto";
    info_Box.style.background ="rgba(0,0,0,.3)";
    info_Box.style.padding ="3px";
    info_Box.style.display ="inline-flex";
    info_Box.style.color ="aliceblue";
    info_Box.style.position ="relative";
    
    // image box that will be created image 
    const Images_Box = document.createElement('div');
    info_Box.appendChild(Images_Box);
    //Images_Box.classList.add('img_box');
    Images_Box.id = 'info_Box-panal';
    Images_Box.style.width ="50%";
    Images_Box.style.height ="330px";
    Images_Box.style.background ="rgba(0,0,0,.3)";
    Images_Box.style.padding ="6px";
    Images_Box.style.display ="list-item";
    
    for(var z = 0; z <= Images_Box.children.length-1; z++){
        Images_Box.children[z].remove();
    }

    for(var m = 0; images[m]; m++){
        var img = document.createElement('img');
        //alert("image "+  vs_path + "/" + images[m]);
        img.src =  vs_path + "/" + images[m];
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
            img.addEventListener('click', function () {
                let imgs_count = Images_Box.children.length;
                let num = z;
                let list = Images_Box;
                for(var p = 0; p <= list.children.length-1; p++){
                   var n = 100/list.children.length;
                   if(100/3 >= n) n=n;
                   else n = 100/3;
                   if(p == Number(num)){
                      list.children[p].style.width =String(100)+"%";
                      list.children[p].style.height =String(100-100/2)+"%";
                   }
                   else {
                      list.children[p].style.width =String(n)+"%";
                      list.children[p].style.height =String(100/4)+"%";
                   }
                }
                list.value = String(num);
                
                if(num == 0||num == imgs_count-1){
                    this.style.width =String(100)+"%";
                    this.style.height =String(100-100/4)+"%";
                }
                else {
                    this.style.width =String(100)+"%";
                    this.style.height =String(100-100/3)+"%";
                }
                this.parentNode.insertBefore(this, this.parentNode.firstChild);
             });
        }
    }

    
    // item info will be desplyed in this box
    const otherinfo_Box = document.createElement('div');
    info_Box.appendChild(otherinfo_Box);
    otherinfo_Box.style.width ="50%";
    //otherinfo_Box.classList.add('sub_info_Box');
    
    const p_name_title = document.createElement('h1');
    //p_name_title.classList.add('p_name');
    p_name_title.value = vs_n;
    p_name_title.innerText = vs_n;
    otherinfo_Box.appendChild(p_name_title);
    
    const p_price_info = document.createElement('h1');
    //p_price_info.classList.add('p_price');
    p_price_info.value = "R" + vs_price;
    p_price_info.innerText = "R" + vs_price;
    otherinfo_Box.appendChild(p_price_info);

    const p_disc_info = document.createElement('h1');
    //p_disc_info.classList.add('p_disc');
    p_disc_info.value = "color_box_id";
    p_disc_info.innerText = vs_dic;
    otherinfo_Box.appendChild(p_disc_info);
  
    const size_info_id = document.createElement('div');
    otherinfo_Box.appendChild(size_info_id);
    size_info_id.id = "selection_box_id";
    size_info_id.value = "View";
    //size_info_id.classList.add('selection_box');
    size_info_id.id = 'info_Box-panal';
    size_info_id.style.width ="100%";
    size_info_id.style.size ="auto";
    console.log("vs_info>>"+vs_info);
    function get_selecteditems() {
        selectedItems = size_info_id.selectedItems;
    }
    read_item(vs_info, size_info_id, selectedItems, get_selecteditems);


    // ----------------------------------------Create do_btn PARENT FORM CHILDES
    //do_btn.classList.add('view_btn_form');
    do_btn.style.display ="line";
    
    const do_like_btn = document.createElement('button');
    do_btn.appendChild(do_like_btn);
    //do_like_btn.classList.add('btns');
    do_like_btn.style.width = '33%';
    do_like_btn.style.color = 'var(--white)';
    do_like_btn.style.textAlign = "center";
    do_like_btn.style.marginTop ="1rem";
    do_like_btn.style.backgroundColor ="var(--blue)";
    do_like_btn.style.padding ="1.2rem 3rem";
    do_like_btn.style.borderRadius ="0.5rem";
    
    do_like_btn.name="add_to_cart";
    do_like_btn.innerText= "like";
    do_like_btn.value= "like";
    
    const do_buy_btn = document.createElement('button');
    do_btn.appendChild(do_buy_btn);
    //do_buy_btn.classList.add('btns');
    do_buy_btn.style.width = '33%';
    do_buy_btn.style.color = 'var(--white)';
    do_buy_btn.style.textAlign = "center";
    do_buy_btn.style.marginTop ="1rem";
    do_buy_btn.style.backgroundColor ="var(--blue)";
    do_buy_btn.style.padding ="1.2rem 3rem";
    do_buy_btn.style.borderRadius ="0.5rem";
    do_buy_btn.name="add_to_cart";
    do_buy_btn.innerText= "Buy";
    do_buy_btn.value= "Buy";
    
    const do_cart_btn = document.createElement('button');
    do_btn.appendChild(do_cart_btn);
    //do_cart_btn.classList.add('btns');
    do_cart_btn.style.width = '33%';
    do_cart_btn.style.color = 'var(--white)';
    do_cart_btn.style.textAlign = "center";
    do_cart_btn.style.marginTop ="1rem";
    do_cart_btn.style.backgroundColor ="var(--blue)";
    do_cart_btn.style.padding ="1.2rem 3rem";
    do_cart_btn.style.borderRadius ="0.5rem";
    
    //do_cart_btn.classList.add('btns_add_to_cart');
    do_cart_btn.name="add_to_cart";
    do_cart_btn.value= "Add to cart";
    do_cart_btn.innerText= "Add to cart";
    do_cart_btn.addEventListener('click', function() {
        selecteditem_info.push(vs_id);
        selecteditem_info.push(vs_n);
        selecteditem_info.push(vs_price);
        selecteditem_info.push(images);
		    addNewItem(selecteditem_info, selectedItems);
	});
    
    /// other info box that will hold all info about item
    
    // ----------------------------------------Create history_Box PARENT FORM CHILDES
    //const history_Box = document.createElement('div');
    //history_Box.classList.add('history_Box');
    history_Box.id = 'history_Box-panal';
    history_Box.style.display = 'none';
    
    create_list(history_Box, 'LIST DOWN', 1, "50%", "50%", "V-TEXT-LIST", "DOCUMENTS", "", 1);
    create_list(history_Box, 'LIST DOWN', 1, "50%", "100%", "V-CHART-LINE-document_barcode-price", "DOCUMENTS", "", 1);

    view_Box.appendChild(info_Box);
    view_Box.appendChild(history_Box);
    view_Box.appendChild(view_form);
    view_form.appendChild(do_btn);

    //{l,[|black,2|,|green,3|,|white,5|,]},{xl,[|white,5|,|black,2|,|green,6|,]},
    console.log("disply_item vs_info>>"+vs_info);
    document.getElementById('shopping-cart-form').style.display='none'; 
    document.getElementById('login-form').style.display='none';
}


//disply_item("", "", "", "", "", "", "", "", "", "");

/*window.onscroll = () => {
    var mainy = 150;
    var sy = scrollY; 
var sy = scrollY; 
var y = mainy + sy;
var ya  = y+ vi_mainu.scrollTop
//document.getElementById('view-form').style.top = ya + 'px';
    document.querySelector('#shopping-cart-form').style.top = y + 'px';
    //menu.classList.remove('fa-times');
    //navbar.classList.remove('active');
};*/
