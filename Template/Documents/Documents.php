<?php 

if (session_id() === "") session_start();

if(file_exists('/Template/Chart/Call_Chart.php')) include '/Template/Chart/Call_Chart.php';
if(file_exists('/Template/Chart/Call_Chart.php')) include('/Template/Chart/Call_Chart.php');
 $doc_selected_Shop_Id = isset($_SESSION['Selected_Shop']) ? $_SESSION['Selected_Shop'] : -1;
?> 
<script src="js/Get/sendajax.js"></script>
<script src="js/Chart/char.js"></script>

<script>
    //<h2>Documents List</h2>
    //<div class="doc_chart_frame">
                             
    const DocumentsTab = document.querySelector('body .Main main .DocumentsTab');

    const doc_chart_frame = document.createElement('div');
    DocumentsTab.appendChild(doc_chart_frame);
    doc_chart_frame.class = 'doc_chart_frame';
    doc_chart_frame.style.color = 'blue';
    doc_chart_frame.style.width = '100%';

    const Documents_tab = document.createElement('div');
    doc_chart_frame.appendChild(Documents_tab);
    Documents_tab.class = 'Documents_tab';
    Documents_tab.style.color = 'blue';
    Documents_tab.style.width = '100%';

    const Documents_refresh_button = document.createElement('button');
    Documents_tab.appendChild(Documents_refresh_button);
    Documents_refresh_button.class = 'Documents_profiletablinks';
    Documents_refresh_button.style.top = '1px';
    Documents_refresh_button.style.laft = '1px';
    Documents_refresh_button.value = 'Refreash';
    Documents_refresh_button.textContent = 'Refreash';
    Documents_refresh_button.onclick = function () {
        
        console.log('Documents_refresh_button clicked');
    };

    const Documents_Home_Tab = document.createElement('div');

    const Documents_tab_tab_btn = document.createElement('button');
    Documents_tab.appendChild(Documents_tab_tab_btn);
    Documents_tab_tab_btn.class = 'Documents_profiletablinks';
    Documents_tab_tab_btn.style.top = '1px';
    Documents_tab_tab_btn.style.laft = '1px';
    Documents_tab_tab_btn.value = 'Documents';
    Documents_tab_tab_btn.textContent = 'Documents';
    Documents_tab_tab_btn.onclick = function () {
        // hide all document tabs that are opend 
        if(Documents_Home_Tab.style.display == 'none') Documents_Home_Tab.style.display = 'block';
        console.log('Documents_tab_tab_btn clicked', Documents_Home_Tab.style.display);
    };

    doc_chart_frame.appendChild(Documents_Home_Tab);
    Documents_Home_Tab.id = 'Documents_Home_Tab';
    Documents_Home_Tab.classList.add('Documents_Home_Tab');
    Documents_Home_Tab.classList.add('Documents_profiletabcontent');
    Documents_Home_Tab.style.top = '1px';
    Documents_Home_Tab.style.laft = '1px';
    Documents_Home_Tab.style.color = 'blue';
    Documents_Home_Tab.style.width = '100%';
    



    const container_Setting = document.createElement('div');
    Documents_Home_Tab.appendChild(container_Setting);
    container_Setting.style.backgroundColor = '#ff990094';
    container_Setting.style.top = '1px';
    container_Setting.style.laft = '1px';
    container_Setting.style.color = 'blue';
    container_Setting.style.width = '100%';
    //container_Setting.style.position = 'absolute';
    //container_Setting.style.display = 'flex';
    container_Setting.style.boxShadow = 'var(--box-shadow)';
    container_Setting.style.border = 'var(--border)';
    container_Setting.style.borderRadius = '1.5rem';

    const setting_contener = document.createElement('div');
    container_Setting.appendChild(setting_contener);
    //setting_contener.style.textAlign = 'center';
    setting_contener.style.boxShadow = 'var(--box-shadow)';
    setting_contener.style.border = 'var(--border)';
    setting_contener.style.borderRadius = '1.5rem';
    setting_contener.style.marginRight = 'auto';
    //setting_contener.style.position ='relative';
    //setting_contener.style.alignContent = 'space-between';
    //setting_contener.style.flexWrap = 'wrap';
    //setting_contener.style.height = '90%'; 

    setting_contener.style.display = 'flex';
    setting_contener.style.flexDirection = 'row';
    setting_contener.style.flexWrap = 'wrap';
    //setting_contener.style.gap = '1.5rem';
    setting_contener.style.overflowX = 'auto';
    setting_contener.style.overflowY = 'hidden';
    setting_contener.style.width = '100%';
    //setting_contener.style.height = 'auto';
    setting_contener.style.behavior = 'smooth';
    //setting_contener.style.flexWrap = 'wrap';

    // Check if title display is enabled
    const search_info = [['Document Id:', null], [' Document Type:', null], ['Document Barcode:', null], ['Extension Barcode:', null]
    ['Document Items:', null], ['Sold Item Info:', null], ['User ID:', null], ['Customer ID:', null], ['Customer ID:', null]];
    search_info.forEach(element => {
        if(Array.isArray(element) && element.length > 1){
            let lable = document.createElement('label');
            lable.textContent = element[0];
            lable.style.fontSize = 'small';
            var Document_ID_input = document.createElement('input');
            Document_ID_input.type = 'text';
            Document_ID_input.style.boxShadow = 'var(--box-shadow)';
            Document_ID_input.style.border = 'var(--border)';
            Document_ID_input.style.borderRadius = '1.5rem';
            lable.appendChild(Document_ID_input);
            setting_contener.appendChild(lable);
            element[1] = lable;
        }
    });

    var currentDate = new Date();
    var formattedDate = currentDate.toISOString().split('T')[0];

    var Document_CREATED_DATE_lable = document.createElement('label');
    Document_CREATED_DATE_lable.textContent = 'Created Date:';
    Document_CREATED_DATE_lable.style.fontSize = 'small';
    var Document_CREATED_DATE_CHECKBOX = document.createElement('input');
    Document_CREATED_DATE_CHECKBOX.type = 'checkbox';
    Document_CREATED_DATE_CHECKBOX.checked = 1;
    Document_CREATED_DATE_CHECKBOX.value = "title";
    Document_CREATED_DATE_CHECKBOX.style.boxShadow = 'var(--box-shadow)';
    Document_CREATED_DATE_CHECKBOX.style.border = 'var(--border)';
    Document_CREATED_DATE_CHECKBOX.style.borderRadius = '1.5rem';
    Document_CREATED_DATE_lable.appendChild(Document_CREATED_DATE_CHECKBOX);
    setting_contener.appendChild(Document_CREATED_DATE_lable);

    var Document_EXPIRE_DATE_lable = document.createElement('label');
    Document_EXPIRE_DATE_lable.textContent = 'Expire Date:';
    Document_EXPIRE_DATE_lable.style.fontSize = 'small';
    var Document_EXPIRE_DATE_CHECKBOX = document.createElement('input');
    Document_EXPIRE_DATE_CHECKBOX.type = 'checkbox';
    Document_EXPIRE_DATE_CHECKBOX.checked = 1;
    Document_EXPIRE_DATE_CHECKBOX.value = "title";
    Document_EXPIRE_DATE_CHECKBOX.style.boxShadow = 'var(--box-shadow)';
    Document_EXPIRE_DATE_CHECKBOX.style.border = 'var(--border)';
    Document_EXPIRE_DATE_CHECKBOX.style.borderRadius = '1.5rem';
    Document_EXPIRE_DATE_lable.appendChild(Document_EXPIRE_DATE_CHECKBOX);
    setting_contener.appendChild(Document_EXPIRE_DATE_lable);
    
    var Document_UPDATED_DATE_lable = document.createElement('label');
    Document_UPDATED_DATE_lable.textContent = 'Updated Date:';
    Document_UPDATED_DATE_lable.style.fontSize = 'small';
    var Document_UPDATED_DATE_CHECKBOX = document.createElement('input');
    Document_UPDATED_DATE_CHECKBOX.type = 'checkbox';
    Document_UPDATED_DATE_CHECKBOX.checked = 1;
    Document_UPDATED_DATE_CHECKBOX.value = "title";
    Document_UPDATED_DATE_CHECKBOX.style.boxShadow = 'var(--box-shadow)';
    Document_UPDATED_DATE_CHECKBOX.style.border = 'var(--border)';
    Document_UPDATED_DATE_CHECKBOX.style.borderRadius = '1.5rem';
    Document_UPDATED_DATE_lable.appendChild(Document_UPDATED_DATE_CHECKBOX);
    setting_contener.appendChild(Document_UPDATED_DATE_lable);
    

    var Document_from_lable = document.createElement('label');
    Document_from_lable.textContent = 'From:';
    Document_from_lable.style.fontSize = 'small';
    const Document_EXPIRE_DATE_INPUT = document.createElement('input');
    Document_EXPIRE_DATE_INPUT.className = 'start-date_btn'; // Remove the dot from the selector to set the class name
    Document_EXPIRE_DATE_INPUT.setAttribute('type', 'date');
    Document_EXPIRE_DATE_INPUT.setAttribute('id', 'start-date_btn');
    Document_EXPIRE_DATE_INPUT.setAttribute('value', formattedDate);
    Document_EXPIRE_DATE_INPUT.style.justifyContent = 'center';
    Document_EXPIRE_DATE_INPUT.style.alignItems = 'center';
    // Set the default value of the date input element
    Document_EXPIRE_DATE_INPUT.value = formattedDate;
    Document_from_lable.appendChild(Document_EXPIRE_DATE_INPUT);
    setting_contener.appendChild(Document_from_lable);

    var Document_TO_lable = document.createElement('label');
    Document_TO_lable.textContent = 'To:';
    Document_TO_lable.style.fontSize = 'small';
    const Document_UPDATED_DATE_INPUT = document.createElement('input');
    Document_UPDATED_DATE_INPUT.className = 'end-date_btn'; // Remove the dot from the selector to set the class name
    Document_UPDATED_DATE_INPUT.setAttribute('type', 'date');
    Document_UPDATED_DATE_INPUT.setAttribute('id', 'end-date_btn');
    Document_UPDATED_DATE_INPUT.setAttribute('value', formattedDate);
    Document_UPDATED_DATE_INPUT.style.justifyContent = 'center';
    Document_UPDATED_DATE_INPUT.style.alignItems = 'center';
    // Set the default value of the date input element
    Document_UPDATED_DATE_INPUT.value = formattedDate;
    Document_TO_lable.appendChild(Document_UPDATED_DATE_INPUT);
    setting_contener.appendChild(Document_TO_lable);

    const Documents_SEARCH_button = document.createElement('button');
    Documents_SEARCH_button.class = 'Documents_profiletablinks';
    Documents_SEARCH_button.value = 'SEARCH';
    Documents_SEARCH_button.textContent = 'SEARCH';
    setting_contener.appendChild(Documents_SEARCH_button);
    

    

    

    //const Documents_Home_Lists = .querySelector('.Documents_Home_Tab .Documents_Home_Lists');
    //const shop_list_container = document.querySelector('body .Main main .shop_product_items_list_container .list_prd_frame');
    create_list(Documents_Home_Tab, 'LIST DOWN', 1, "100%", "50%", "V-TABLE-LIST", "DOCUMENTS", "", 0, <?php echo $doc_selected_Shop_Id;?>);
    
    // info tab
    const Documents_Info_tab = document.createElement('div');
    Documents_Home_Tab.appendChild(Documents_Info_tab);
    Documents_Info_tab.class = 'Documents_Info_tab';
    //Documents_Info_tab.style.color = 'blue';
    //Documents_Info_tab.style.width = '100%';

    const Documents_Info_tab_button0 = document.createElement('button');
    Documents_Info_tab.appendChild(Documents_Info_tab_button0);
    Documents_Info_tab_button0.class = 'Documents_profiletablinks';
    Documents_Info_tab_button0.value = 'Info';
    Documents_Info_tab_button0.textContent = 'Info';

    const Documents_Info_BY_USER_button = document.createElement('button');
    Documents_Info_tab.appendChild(Documents_Info_BY_USER_button);
    Documents_Info_BY_USER_button.class = 'Documents_profiletablinks';
    Documents_Info_BY_USER_button.value = 'USER INFO';
    Documents_Info_BY_USER_button.textContent = 'USER INFO';
    



    const Documents_Info = document.createElement('div');
    Documents_Home_Tab.appendChild(Documents_Info);
    Documents_Info.id = 'Documents_Info_div';
    Documents_Info.classList.add('Documents_Info_div');
    Documents_Info.classList.add('Documents_Info_divtabcontent');
    Documents_Info.style.border = 'var(--border)';
    /* display: block; */
    Documents_Info.style.borderradius = '1.5rem';
    Documents_Info.style.display = 'flex';
    Documents_Info.style.flexWrap = 'wrap';
    //Documents_Info.id = 'Documents_Info';
    //Documents_Info.class.add('Documents_Tab');
    //Documents_Info.class.add('Documents_Info_tabcontent');
    //Documents_Info.classList.remove("active");
    //color = 'blue';
    //Documents_Info.style.width = '100%';
    
    //<h2>Documents List</h2>
    //const Documents_Info_dive = Documents_Home_Lists.querySelector('.Documents_Info .Documents_Info_dive');
    //const shop_list_container = document.querySelector('body .Main main .shop_product_items_list_container .list_prd_frame');

    create_list(Documents_Info, 'LIST DOWN', 1, "50%", "50%", "V-TABLE-LIST", "DOCUMENTS", "TOP_SALED", 0, <?php echo $doc_selected_Shop_Id;?>);
    create_list(Documents_Info, 'LIST DOWN', 1, "50%", "50%", "V-TEXT-LIST", "DOCUMENTS", "TOTAL_SUM;TOTAL_COUNTED", 0, <?php echo $doc_selected_Shop_Id;?>);
    create_list(Documents_Info, 'LIST DOWN', 1, "100%", "50%", "V-CHART-LINE-document_barcode-price", "DOCUMENTS", "", 0, <?php echo $doc_selected_Shop_Id;?>);
    create_list(Documents_Info, 'LIST DOWN', 1, "50%", "50%", "V-TABLE-LIST", "DOCUMENTS", "TOP_SALED_TYPES", 0, <?php echo $doc_selected_Shop_Id;?>);
    

    const Documents_Info_BY_USER = document.createElement('div');
    Documents_Home_Tab.appendChild(Documents_Info_BY_USER);
    Documents_Info_BY_USER.id = 'Documents_Info_BY_USER_div';
    Documents_Info_BY_USER.classList.add('Documents_Info_BY_USER_div');
    Documents_Info_BY_USER.classList.add('Documents_Info_BY_USER_divtabcontent');
    Documents_Info_BY_USER.style.borderradius = '1.5rem';
    Documents_Info_BY_USER.style.display = 'none';
    Documents_Info_BY_USER.style.flexWrap = 'wrap';
    //Documents_Info_BY_USER.id = 'Documents_Info_BY_USER';
    //Documents_Info_BY_USER.class.add('Documents_Tab');
    //Documents_Info_BY_USER.class.add('Documents_Info_BY_USER_content');
    //Documents_Info_BY_USER.classList.remove("active");
    //Documents_Info_BY_USER.style.color = 'blue';
    //Documents_Info_BY_USER.style.width = '100%';

    create_list(Documents_Info_BY_USER, 'LIST DOWN', 1, "50%", "50%", "V-TABLE-LIST", "DOCUMENTS", "TOP_USERS", 0, <?php echo $doc_selected_Shop_Id;?>);

    // end info tab

    Documents_Info_tab_button0.onclick=function () {
        Documents_Info.style.display = 'flex';
        Documents_Info_BY_USER.style.display = 'none';
    };
    Documents_Info_BY_USER_button.onclick=function () {
        Documents_Info.style.display = 'none';
        Documents_Info_BY_USER.style.display = 'flex';
    };
    Documents_SEARCH_button.onclick= function () {
        console.log('Documents_SEARCH_button clicked');
        const paretnchileds = setting_contener.childNodes;
        let search_value = "";
        paretnchileds.forEach(item => {
            if(item.childNodes.length > 1 && item.tagName == 'LABEL' && (item.childNodes[1].value != '' || item.childNodes[1].value != 0)) {
                var value = item.childNodes[1].value;
                if (item.childNodes[1].tagName == 'INPUT' && item.childNodes[1].type == 'checkbox') {
                    value = item.childNodes[1].checked;
                }
                if(search_value  != "") search_value += ";" + item.textContent + value;
                else search_value = item.textContent + value;
            }
        });
        let paths = ['body .Main main .DocumentsTab .Documents_Home_Tab', 'body .Main main .DocumentsTab .Documents_Home_Tab .Documents_Info_divtabcontent', 
                    'body .Main main .DocumentsTab .Documents_Home_Tab .Documents_Info_BY_USER_div'];
        paths.forEach(path => {
            give_result_to_list(path, search_value);
        });
        console.log('item search', search_value);
    };
</script>