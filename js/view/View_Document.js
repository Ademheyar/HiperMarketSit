
function View_Selected_Document(data) {
    console.log("selected  View_Selected_Document >>" , data);

    // Check if title display is enabled
    var currentDate = new Date();
    var formattedDate = currentDate.toISOString().split('T')[0];
    var dowhat="Create New";
    var sy = scrollY;
    var y = sy;
  
    const vd_body = document.querySelector('body');
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
    //view_Box.style.alignItems = "center";
    //view_Box.style.justifyContent = "center";
    view_Box.style.zIndex = "1000";
    vd_body.appendChild(view_Box);

    // CREATE PARENTS FIRST
    const info_Box = document.createElement('div');
    const item_Box = document.createElement('div');
    const payment_Box = document.createElement('div');
    const view_form = document.createElement('div');
    const do_btn = document.createElement('div');

    console.log("in View_Selected 1");
    var shop_name = ('vs_At_Shop' + " ").split(' ');
    var na = 'vs_n'.replaceAll(' ', '_');
    
    //var path = ("img\\" + shop_name[0] + "\\products\\" + ('vs_type').replaceAll(' ', '\\') + "\\"+ na + "\\"+ 'vs_code').replaceAll('\\\\', '\\');
    var images = 'vs_img';
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
    


    const Information_tab_btn = document.createElement('button');
    tabbtn_Box.appendChild(Information_tab_btn);
    Information_tab_btn.style.width ="auto";
    Information_tab_btn.style.height ="auto";
    Information_tab_btn.style.gap ="10px";
    Information_tab_btn.style.background ="rgba(0,0,0,.3)";
    Information_tab_btn.style.padding ="revert";
    Information_tab_btn.style.border ="outset";
    Information_tab_btn.style.display ="inline-flex";
    Information_tab_btn.style.color ="aliceblue";
    Information_tab_btn.style.position ="relative";
    Information_tab_btn.style.size ="auto";
    //Information_tab_btn.classList.add('btns');
    Information_tab_btn.name="Information_tab_btn";
    Information_tab_btn.innerText= "Information";
    Information_tab_btn.value= "Information";
    Information_tab_btn.addEventListener('click', ()=>{
        info_Box.style.display = 'inline-flex';
        item_Box.style.display = 'none';
        payment_Box.style.display = 'none';
        view_form.style.display = 'block';
    });

    const Items_list_tab_btn = document.createElement('button');
    tabbtn_Box.appendChild(Items_list_tab_btn);
    Items_list_tab_btn.style.width ="auto";
    Items_list_tab_btn.style.height ="auto";
    Items_list_tab_btn.style.gap ="10px";
    Items_list_tab_btn.style.background ="rgba(0,0,0,.3)";
    Items_list_tab_btn.style.padding ="revert";
    Items_list_tab_btn.style.border ="outset";
    Items_list_tab_btn.style.display ="inline-flex";
    Items_list_tab_btn.style.color ="aliceblue";
    Items_list_tab_btn.style.position ="relative";
    Items_list_tab_btn.style.size ="auto";
    //Items_list_tab_btn.classList.add('btns');
    Items_list_tab_btn.name="Items_list_tab_btn";
    Items_list_tab_btn.innerText= "Items list";
    Items_list_tab_btn.value= "Items list";
    Items_list_tab_btn.addEventListener('click', ()=>{
        info_Box.style.display = 'none';
        item_Box.style.display = 'block';
        payment_Box.style.display = 'none';
        view_form.style.display = 'none';
    });

    console.log("in View_Selected 3");
    const Payment_list_tab_btn = document.createElement('button');
    tabbtn_Box.appendChild(Payment_list_tab_btn);
    Payment_list_tab_btn.style.width ="auto";
    Payment_list_tab_btn.style.height ="auto";
    Payment_list_tab_btn.style.gap ="10px";
    Payment_list_tab_btn.style.background ="rgba(0,0,0,.3)";
    Payment_list_tab_btn.style.padding ="revert";
    Payment_list_tab_btn.style.border ="outset";
    Payment_list_tab_btn.style.display ="inline-flex";
    Payment_list_tab_btn.style.color ="aliceblue";
    Payment_list_tab_btn.style.position ="relative";
    Payment_list_tab_btn.style.size ="auto";
    //Payment_list_tab_btn.classList.add('btns');
    Payment_list_tab_btn.name="Payment_list_tab_btn";
    Payment_list_tab_btn.innerText= "Payment list";
    Payment_list_tab_btn.value= "Payment list";
    Payment_list_tab_btn.addEventListener('click', ()=>{
        info_Box.style.display = 'none';
        item_Box.style.display = 'none';
        payment_Box.style.display = 'block';
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
    
    info_Box.style.boxShadow = 'var(--box-shadow)';
    info_Box.style.border = 'var(--border)';
    info_Box.style.borderRadius = '1.5rem';
    info_Box.style.marginRight = 'auto';
    //info_Box.style.position ='relative';
    //info_Box.style.alignContent = 'space-between';
    //info_Box.style.flexWrap = 'wrap';
    //info_Box.style.height = '90%'; 

    info_Box.style.display = 'flex';
    info_Box.style.flexDirection = 'row';
    info_Box.style.flexWrap = 'wrap';
    //info_Box.style.gap = '1.5rem';
    info_Box.style.overflowX = 'auto';
    info_Box.style.overflowY = 'hidden';
    info_Box.style.width = '100%';
    //info_Box.style.height = 'auto';
    info_Box.style.behavior = 'smooth';
    //info_Box.style.flexWrap = 'wrap';

    item_Box.id = 'item_Box-panal';
    item_Box.style.display = 'none';

    const table_divs = document.createElement('div');
    table_divs.style.overflowX = 'auto';
    const itemtable = document.createElement('table');
    table_divs.appendChild(itemtable);
    function add_item_List(newparment) {
        const tbody = itemtable.createTBody();
        const btn_divs = document.createElement('div');
        tbody.appendChild(btn_divs);
        btn_divs.className = 'item_editer_btns';
        btn_divs.style.width = '100%'
        btn_divs.style.height = '100%'
        btn_divs.style.display = 'none';

        const UpdateItem_btn = document.createElement('button');
        btn_divs.appendChild(UpdateItem_btn);
        //UpdateItem_btn.classList.add('lcb_1btns');
        //UpdateItem_btn.name = 'add_to_cart';
        UpdateItem_btn.innerText = 'Update';
        UpdateItem_btn.style.backgroundColor = 'var(--with)';
        UpdateItem_btn.style.width = '100%'
        UpdateItem_btn.style.height = '100%'
        UpdateItem_btn.style.marginTop = '1rem';
        UpdateItem_btn.style.position = 'inherit';
        UpdateItem_btn.addEventListener('click', function() {
            Payment_type_INPUT.value = newparment[0];
            Payment_Amount_INPUT.value = newparment[1];
            Payment_Date_INPUT.value = newparment[2];
        });

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
        DeleteItem_btn.addEventListener('click', function() { 
            tbody.remove();
        });

        const tr = tbody.insertRow();
        for (let row = 0; row < newparment.length; row++) {
            const r = newparment[row];
            const td = tr.insertCell();
            td.textContent = r;
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
    }

    const itemsetting_contener = document.createElement('div');
    item_Box.appendChild(itemsetting_contener);
    //itemsetting_contener.style.textAlign = 'center';
    itemsetting_contener.style.boxShadow = 'var(--box-shadow)';
    itemsetting_contener.style.border = 'var(--border)';
    itemsetting_contener.style.borderRadius = '1.5rem';
    itemsetting_contener.style.marginRight = 'auto';
    itemsetting_contener.style.display = 'flex';
    itemsetting_contener.style.flexDirection = 'row';
    itemsetting_contener.style.flexWrap = 'wrap';
    itemsetting_contener.style.overflowX = 'auto';
    itemsetting_contener.style.overflowY = 'hidden';
    itemsetting_contener.style.width = '100%';
    itemsetting_contener.style.behavior = 'smooth';

    let itemsearchlable = document.createElement('label');
    itemsearchlable.textContent = 'Search Item : ';
    itemsearchlable.style.fontSize = 'small';
    itemsearchlable.style.display = 'flex';
    const Payment_itemsearch_ComboBox = document.createElement("input");
    //Payment_itemsearch_ComboBox.id = "nextList";
    Payment_itemsearch_ComboBox.type = 'text';
    Payment_itemsearch_ComboBox.value = "";

    const search_list_contener = document.createElement('div');
    //search_list_contener.style.textAlign = 'center';
    search_list_contener.style.boxShadow = 'var(--box-shadow)';
    search_list_contener.style.border = 'var(--border)';
    search_list_contener.style.borderRadius = '1.5rem';
    search_list_contener.style.marginRight = 'auto';
    search_list_contener.style.flexDirection = 'row';
    search_list_contener.style.overflow = 'auto';
    search_list_contener.style.behavior = 'smooth';
    search_list_contener.style.boxShadow = 'var(--box-shadow)';
    search_list_contener.style.border = 'var(--border)';
    search_list_contener.style.borderRadius = '1.5rem';
    search_list_contener.style.position = 'absolute';
    search_list_contener.style.bottom = '-15px';
    search_list_contener.style.display = 'none';
    search_list_contener.style.backgroundColor = 'white';
    search_list_contener.style.height = '100px';

    
    itemsearchlable.appendChild(Payment_itemsearch_ComboBox);
    itemsearchlable.appendChild(search_list_contener);
    itemsetting_contener.appendChild(itemsearchlable);
    
    const size_info_id = document.createElement('div');
    size_info_id.id = "selection_box_id";
    size_info_id.value = "View";
    //size_info_id.classList.add('selection_box');
    size_info_id.id = 'info_Box-panal';
    size_info_id.style.width ="100%";
    size_info_id.style.size ="auto";
    itemsetting_contener.appendChild(size_info_id);

    Payment_itemsearch_ComboBox.addEventListener('input',function () {
        if(Payment_itemsearch_ComboBox.value == "") search_list_contener.style.display = 'none';
        else{
            let formData = new FormData();
            formData.append('Search_Like_Query', 'Search_Like_Query');
            formData.append('Search_Query_value', Payment_itemsearch_ComboBox.value);
            fetchAjaxRequest('server/Products/Product.php', "POST", formData, 
            function (data){
                console.log('fetchAjaxRequest data', data);
                search_list_contener.style.display = 'block';
                while (search_list_contener.firstChild) search_list_contener.removeChild(search_list_contener.firstChild);
                while (size_info_id.firstChild) size_info_id.removeChild(size_info_id.firstChild);
                let result = data.result;
                for (let q = 0; q < result.length; q++) {
                    const row = result[q];
                    let itemsearchresultlable = document.createElement('label');
                    itemsearchresultlable.data = row;
                    itemsearchresultlable.textContent = row['id'] + " " + row['name'];
                    itemsearchresultlable.style.fontSize = 'small';
                    itemsearchresultlable.style.display = 'flex';
                    search_list_contener.appendChild(itemsearchresultlable);
                    itemsearchresultlable.addEventListener('click', function() {
                        if(this.style.backgroundColor == 'lightblue'){
                            var selectedItems = [];
                            function get_selecteditems() {
                                selectedItems = size_info_id.selectedItems;
                                for (let w = 0; w < selectedItems.length; w++) {
                                    const selectedItem = selectedItems[w];
                                    size_info_id.info[0] = selectedItem[1]; // code
                                    // 1 barcode
                                    size_info_id.info[3] = parseInt(selectedItem[4]);
                                    size_info_id.info[8] = selectedItem[2]; // color
                                    size_info_id.info[9] = selectedItem[3]; // size
                                    size_info_id.info[10] = selectedItem[0]; // shop
                                    size_info_id.info[10] = selectedItem[0]; // shop
                                    var totalprice = parseInt(selectedItem[4]) * parseInt(size_info_id.info[4]);
                                    size_info_id.info[7] = parseInt(totalprice); // shop
                                    add_item_List(size_info_id.info);
                                }
                                // 5 discount
                                // 6 tax
                                while (size_info_id.firstChild) size_info_id.removeChild(size_info_id.firstChild);
                                search_list_contener.style.display = 'none';
                                console.log('get_selecteditems selectedItems ', selectedItems);
                            }
                            console.log('itemsearchresultlable selected data data ', itemsearchresultlable.data);
                            console.log('itemsearchresultlable selected data data[more_info] ', itemsearchresultlable.data['more_info']);
                            read_item(itemsearchresultlable.data['more_info'], size_info_id, selectedItems, get_selecteditems);
                            size_info_id.info = ['code', 'barcode', itemsearchresultlable.data['name'], "QTY", itemsearchresultlable.data['price'], '0', '0', "TOTAL PRICE", "COLOR", "SIZE", "AT SHOP", ""];
                            search_list_contener.style.display = 'none';
                        }
                        else {
                            for (let c = 0; c < search_list_contener.childNodes.length; c++) search_list_contener.childNodes[c].style.backgroundColor = '';
                            this.style.backgroundColor = 'lightblue';
                        }
                    });
                };

                //
            }, function (error) { alert("error ON VIREW DOCUMENTS" + error); } );
        }
    });

    const item_keys = ["CODE", "BARCODE", "ITEM Name", "QTY", "PRICE", "DISCOUNT", "TAX", "TOTAL PRICE", "COLOR", "SIZE", "AT SHOP", "Extantion Barcode"];
    item_Box.appendChild(table_divs);

    itemtable.setAttribute('border', '1');
    itemtable.style.borderCollapse = 'collapse'; // = 'auto-fit';
    itemtable.style.borderSpacing = '0'; // = 'auto-fit';
    itemtable.style.borderRadius = '12px 12px 0 0'; // = 'auto-fit';
    itemtable.style.boxShadow = '0 12px 12px rgba(32, 32, 32, .3)'; // = 'auto-fit';
    itemtable.style.background = '#fafafa'; // = 'auto-fit';
    itemtable.style.textAlign = 'center'; // = 'auto-fit';

    // Create table header
    const itemheader = itemtable.createTHead();
    const itemheaderRow = itemheader.insertRow();
    item_keys.forEach(itemheaderText => {
        const th = document.createElement('th');
        th.style.padding = '12px 15px'; // = 'auto-fit';
        th.style.backgroundColor = '#333'; // = 'auto-fit';
        th.style.color = '#fff'; // = 'auto-fit';
        th.style.textAlign = 'center'; // = 'auto-fit';
        const text = document.createTextNode(itemheaderText);
        th.appendChild(text);
        itemheaderRow.appendChild(th);
    });

    const paymentkeys = ["Peyment Type", "Paid", "Paid Date", "Updated Date", "User", "Paid", "Extantion Bracodes"];
    
    payment_Box.style.display = 'none';
    const paymenttable = document.createElement('table');
    payment_Box.appendChild(paymenttable);


    
    paymenttable.setAttribute('border', '1');
    paymenttable.style.borderCollapse = 'collapse'; // = 'auto-fit';
    paymenttable.style.borderSpacing = '0'; // = 'auto-fit';
    paymenttable.style.borderRadius = '12px 12px 0 0'; // = 'auto-fit';
    paymenttable.style.boxShadow = '0 12px 12px rgba(32, 32, 32, .3)'; // = 'auto-fit';
    paymenttable.style.background = '#fafafa'; // = 'auto-fit';
    paymenttable.style.textAlign = 'center'; // = 'auto-fit';

    // Create paymenttable header
    const paymentheader = paymenttable.createTHead();
    const paymentheaderRow = paymentheader.insertRow();
    paymentkeys.forEach(headerText => {
        const th = document.createElement('th');
        th.style.padding = '12px 15px'; // = 'auto-fit';
        th.style.backgroundColor = '#333'; // = 'auto-fit';
        th.style.color = '#fff'; // = 'auto-fit';
        th.style.textAlign = 'center'; // = 'auto-fit';
        const text = document.createTextNode(headerText);
        th.appendChild(text);
        paymentheaderRow.appendChild(th);
    });
    const paymentsetting_contener = document.createElement('div');
    payment_Box.appendChild(paymentsetting_contener);
    //paymentsetting_contener.style.textAlign = 'center';
    paymentsetting_contener.style.boxShadow = 'var(--box-shadow)';
    paymentsetting_contener.style.border = 'var(--border)';
    paymentsetting_contener.style.borderRadius = '1.5rem';
    paymentsetting_contener.style.marginRight = 'auto';
    paymentsetting_contener.style.display = 'flex';
    paymentsetting_contener.style.flexDirection = 'row';
    paymentsetting_contener.style.flexWrap = 'wrap';
    paymentsetting_contener.style.overflowX = 'auto';
    paymentsetting_contener.style.overflowY = 'hidden';
    paymentsetting_contener.style.width = '100%';
    paymentsetting_contener.style.behavior = 'smooth';

    let Typelable = document.createElement('label');
    Typelable.textContent = 'Type';
    Typelable.style.fontSize = 'small';
    var Payment_type_INPUT = document.createElement('input');
    Payment_type_INPUT.type = 'text';
    Payment_type_INPUT.value = "";
    Payment_type_INPUT.style.boxShadow = 'var(--box-shadow)';
    Payment_type_INPUT.style.border = 'var(--border)';
    Payment_type_INPUT.style.borderRadius = '1.5rem';
    Typelable.appendChild(Payment_type_INPUT);
    paymentsetting_contener.appendChild(Typelable);

    let Amountlable = document.createElement('label');
    Amountlable.textContent = 'Amount';
    Amountlable.style.fontSize = 'small';
    var Payment_Amount_INPUT = document.createElement('input');
    Payment_Amount_INPUT.type = 'text';
    Payment_Amount_INPUT.value = "";
    Payment_Amount_INPUT.style.boxShadow = 'var(--box-shadow)';
    Payment_Amount_INPUT.style.border = 'var(--border)';
    Payment_Amount_INPUT.style.borderRadius = '1.5rem';
    Amountlable.appendChild(Payment_Amount_INPUT);
    paymentsetting_contener.appendChild(Amountlable);
    
    let Datelable = document.createElement('label');
    Datelable.textContent = 'Date';
    Datelable.style.fontSize = 'small';
    const Payment_Date_INPUT = document.createElement('input');
    Payment_Date_INPUT.className = 'end-date_btn';
    Payment_Date_INPUT.setAttribute('type', 'date');
    //Payment_Date_INPUT.setAttribute('id', 'end-date_btn');
    Payment_Date_INPUT.setAttribute('value', formattedDate);
    Payment_Date_INPUT.style.justifyContent = 'center';
    Payment_Date_INPUT.style.alignItems = 'center';
    // Set the default value of the date input element
    Payment_Date_INPUT.value = formattedDate;
    Datelable.appendChild(Payment_Date_INPUT);
    paymentsetting_contener.appendChild(Datelable);
    
    const Payment_add_btn = document.createElement('button');
    Payment_add_btn.style.width ="auto";
    Payment_add_btn.style.height ="auto";
    Payment_add_btn.style.gap ="10px";
    Payment_add_btn.style.background ="rgba(0,0,0,.3)";
    Payment_add_btn.style.padding ="revert";
    Payment_add_btn.style.border ="outset";
    Payment_add_btn.style.display ="inline-flex";
    Payment_add_btn.style.color ="aliceblue";
    Payment_add_btn.style.position ="relative";
    Payment_add_btn.style.size ="auto";
    //Payment_add_btn.classList.add('btns');
    Payment_add_btn.name="Payment_add_btn";
    Payment_add_btn.innerText= "Add Payment";
    Payment_add_btn.value= "Add Payment";
    paymentsetting_contener.appendChild(Payment_add_btn);

    function add_payment_List(newparment) {
        const tbody = paymenttable.createTBody();
        const btn_divs = document.createElement('div');
        tbody.appendChild(btn_divs);
        btn_divs.className = 'item_editer_btns';
        btn_divs.style.width = '100%'
        btn_divs.style.height = '100%'
        btn_divs.style.display = 'none';

        const UpdateItem_btn = document.createElement('button');
        btn_divs.appendChild(UpdateItem_btn);
        //UpdateItem_btn.classList.add('lcb_1btns');
        //UpdateItem_btn.name = 'add_to_cart';
        UpdateItem_btn.innerText = 'Update';
        UpdateItem_btn.style.backgroundColor = 'var(--with)';
        UpdateItem_btn.style.width = '100%'
        UpdateItem_btn.style.height = '100%'
        UpdateItem_btn.style.marginTop = '1rem';
        UpdateItem_btn.style.position = 'inherit';
        UpdateItem_btn.addEventListener('click', function() {
            Payment_type_INPUT.value = newparment[0];
            Payment_Amount_INPUT.value = newparment[1];
            Payment_Date_INPUT.value = newparment[2];
        });

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
        DeleteItem_btn.addEventListener('click', function() { 
            tbody.remove();
        });

        const tr = tbody.insertRow();
        for (let row = 0; row < newparment.length; row++) {
            const r = newparment[row];
            const td = tr.insertCell();
            td.textContent = r;
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
    }



    Payment_add_btn.addEventListener('click', ()=>{
        //TODO FIXE USER AND ISIT PIDE
        var newparment = [Payment_type_INPUT.value, Payment_Amount_INPUT.value, Payment_Date_INPUT.value, Payment_Date_INPUT.value, "", '0', ""];
        add_payment_List(newparment);
        Payment_type_INPUT.value = "";
        Payment_Amount_INPUT.value = ""; 
        Payment_Date_INPUT.value =  formattedDate;
    });
    

    const search_info = [[`document_id`, null], [`document_barcode`, null], [`documents_extension_barcode`, null], [`user_id`, null], [`customer_id`, null], [`document_type`, null], [`qty`, null], [`price`, null], [`discount`, null], [`tax`, null]];
    for(var [key, value] of Object.entries(data)){
        dowhat="Update";
        if(key == "document_created_date" || key == "document_expire_date" || key == "document_updated_date"){
            let lable = document.createElement('label');
            lable.textContent = key;
            lable.style.fontSize = 'small';
            const Document_CREATED_DATE_INPUT = document.createElement('input');
            Document_CREATED_DATE_INPUT.className = 'end-date_btn';
            Document_CREATED_DATE_INPUT.setAttribute('type', 'date');
            //Document_CREATED_DATE_INPUT.setAttribute('id', 'end-date_btn');
            Document_CREATED_DATE_INPUT.setAttribute('value', formattedDate);
            Document_CREATED_DATE_INPUT.style.justifyContent = 'center';
            Document_CREATED_DATE_INPUT.style.alignItems = 'center';
            // Set the default value of the date input element
            Document_CREATED_DATE_INPUT.value = formattedDate;
            lable.appendChild(Document_CREATED_DATE_INPUT);
            info_Box.appendChild(lable);
        }
        else if(key == "item")
        {
            if(value == "") value = "[]";
            let item_infos = JSON.parse(value);
            if(item_infos.length > 0){
                //const keys = Object.keys(data);
                const tbody = itemtable.createTBody();
                const tr = tbody.insertRow();
                for (let column = 0; column < item_infos.length; column++) {
                    const c = item_infos[column];
                    for (let row = 0; row < c.length; row++) {
                        const r = c[row];
                        const td = tr.insertCell();
                        td.textContent = r;
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
                }
            }
        }
        else if(key == "payments")
        {
            if(value == "") value = "[]";
            let payment_infos = JSON.parse(value);
            if(payment_infos.length > 0){
                //const keys = Object.keys(data)
                const tbody = paymenttable.createTBody();
                const tr = tbody.insertRow();
                for (let column = 0; column < payment_infos.length; column++) {
                    const c = payment_infos[column];
                    for (let row = 0; row < c.length; row++) {
                        const r = c[row];
                        const td = tr.insertCell();
                        td.textContent = r;
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
                }
            }
        }
        else{
            let lable = document.createElement('label');
            lable.textContent = key;
            lable.style.fontSize = 'small';
            var Document_ID_input = document.createElement('input');
            Document_ID_input.type = 'text';
            Document_ID_input.value = value;
            Document_ID_input.style.boxShadow = 'var(--box-shadow)';
            Document_ID_input.style.border = 'var(--border)';
            Document_ID_input.style.borderRadius = '1.5rem';
            lable.appendChild(Document_ID_input);
            info_Box.appendChild(lable);
        }
        //element[1] = lable;
    }

    do_btn.style.display ="flex";
    do_btn.style.gap ="1rem";
    
    const do_add_update_btn = document.createElement('button');
    do_btn.appendChild(do_add_update_btn);
    //do_add_update_btn.classList.add('btns');
    do_add_update_btn.style.color = 'var(--white)';
    do_add_update_btn.style.textAlign = "center";
    do_add_update_btn.style.marginTop ="1rem";
    do_add_update_btn.style.backgroundColor ="var(--blue)";
    do_add_update_btn.style.padding ="1.2rem 3rem";
    do_add_update_btn.style.borderRadius ="0.5rem";
    
    do_add_update_btn.name="add_to_cart";
    do_add_update_btn.innerText= dowhat;
    do_add_update_btn.value= dowhat;
    
    //do_add_update_btn.classList.add('btns_add_to_cart');
    do_add_update_btn.addEventListener('click', ()=>{
        let formData = new FormData();
        formData.append('ADD_UPDATE_DOCUMENT', 'ADD_UPDATE_DOCUMENT');
        formData.append('dowhat', dowhat);
        info_Box.childNodes.forEach(child => {
            const input = child.querySelector('input');
            formData.append(child.textContent, input.value);
        });
        var item_info_list = [];
        [...itemtable.getElementsByTagName('tbody')].forEach(tbody => {
            const rows = tbody.rows;
            var new_list = [];
            [...rows].forEach(row => {
                const cells = row.cells;
                [...cells].forEach(cell => {
                    new_list.push(cell.textContent);
                });
            });
            item_info_list.push(new_list);
        });
        formData.append('item', JSON.stringify(item_info_list));
        
        var payment_info_list = [];
        [...paymenttable.getElementsByTagName('tbody')].forEach(tbody => {
            const rows = tbody.rows;
            var new_list = [];
            [...rows].forEach(row => {
                const cells = row.cells;
                [...cells].forEach(cell => {
                    new_list.push(cell.textContent);
                });
            });
            payment_info_list.push(new_list);
        });

        console.log('going to send to fetchAjaxRequest payment_info_list', payment_info_list);
        formData.append('payments', JSON.stringify(payment_info_list));
        console.log('going to send to fetchAjaxRequest formData', formData);
        
        fetchAjaxRequest('server/Documents/Document.php', "POST", formData, 
        function (data){
            console.log('fetchAjaxRequest data', data);
            //
        }, function (error) { alert("error ON VIREW DOCUMENTS" + error); } );
    });

    /*const do_buy_btn = document.createElement('button');
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
    
    //do_buy_btn.classList.add('btns_add_to_cart');
    do_buy_btn.addEventListener('click', ()=>{
        selectedItems = [];
        selecteditem_info = [];
        view_Box.remove();
    });*/
    
  const view_Boxclose_btn = document.createElement('input');
  do_btn.appendChild(view_Boxclose_btn);
  view_Boxclose_btn.value = "Close";
  view_Boxclose_btn.style.background ="border-box";
  view_Boxclose_btn.style.color ="red";
  //view_Boxclose_btn.classList.add('btns');
  view_Boxclose_btn.style.color = 'var(--white)';
  view_Boxclose_btn.style.textAlign = "center";
  view_Boxclose_btn.style.marginTop ="1rem";
  view_Boxclose_btn.style.backgroundColor ="var(--blue)";
  view_Boxclose_btn.style.padding ="1.2rem 3rem";
  view_Boxclose_btn.style.borderRadius ="0.5rem";
  
  //view_Boxclose_btn.classList.add('btns_add_to_cart');
    view_Boxclose_btn.addEventListener('click', ()=>{
        selectedItems = [];
        selecteditem_info = [];
        view_Box.remove();
    });

    view_Box.appendChild(info_Box);
    view_Box.appendChild(item_Box);
    view_Box.appendChild(payment_Box);

    view_Box.appendChild(view_form);
    view_Box.appendChild(do_btn);

    //{l,[|black,2|,|green,3|,|white,5|,]},{xl,[|white,5|,|black,2|,|green,6|,]},
    console.log("disply_item 'vs_info'>>"+'vs_info');
    document.getElementById('shopping-cart-form').style.display='none'; 
    document.getElementById('login-form').style.display='none';
}