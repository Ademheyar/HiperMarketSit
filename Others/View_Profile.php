<script>
  
   /*function saveData() {
      let newpath = []
      let currentList = mylist;
      

      let shopName = document.getElementById('shop_name').value;
      let timeCode = document.getElementById('time_code').value;
      let itemColor = document.getElementById('item_color').value;
      let itemSize = document.getElementById('item_size').value;
      let itemQty = document.getElementById('item_qty').value;
      let itemBarcode = document.getElementById('item_barcode').value;
      let itemImageInfo = "";
      Array.from(previousFiles).forEach(function(file) {
         if (itemImageInfo == "") itemImageInfo += file["newname"];
         else itemImageInfo += ";"+file["newname"];
      });
      let sv = [shopName, timeCode, itemColor, itemSize];
      let index = 0;
      for (const value of sv) {
         const found = currentList.find((item) => item[0] === value);
         if (found) {
            currentList = found[1];
            index++;
         }
         else break;
      }

      let pathList = [shopName, [[timeCode, [[itemColor, [[itemSize, [[itemQty, itemBarcode, itemImageInfo]]]]]]]]];
      for(i = 0; ; i++){
         if(index <= 0) break;
         pathList = pathList[1][0];
         index--;
      }

      for(var ind = 0; ind < previousFiles.length; ind++) {
         Images_new_names.push([previousFiles[ind]["name"], previousFiles[ind]["newname"]]);
         allImages = [...allImages, previousFiles[ind]];
      }

      currentList.push(pathList);
      text = JSON.stringify(myList); // listtostring(myList);
      document.querySelector('.add-product-form .input_table .p_info').value = text;
      
      Clearimag();
      // Display what is in the list
      createNextComboBox(null);
      update_selected_images(imagesInput);
   }





   let addlisnerto = [document.getElementById('shop_name'), document.getElementById('time_code'), document.getElementById('item_color'), document.getElementById('item_size'), document.getElementById('item_name')];










   function clear_all(){
      allImages = []; 
      Images_new_names = []; 
      selectedValues = [];
      myList = [];
      // Clear the image list and input field
      imageList.innerHTML = '';
      imagesInput.value = '';
      //imgdis.src = "";
      //imgdis.innerHTML = '';
      Clearimag();
   }
   
   function show_images(){
      while (imageList.firstChild) imageList.removeChild(imageList.firstChild);
      let id = allImages.length;
      previousFiles.forEach(function(image) {
         const img = document.createElement('img');
         img.src = URL.createObjectURL(image);
         img.value = image.name;
         img.accessKey = id;
         img.className = 'image-item';


         // Set the source of the 'output' object to the clicked image
         //imgdis.src = URL.createObjectURL(image);
         //imgdis.value = img.value;
         //imgdis.accessKey = id;
         console.log('files name:', image.name);        
         const src = img.getAttribute('src');
         img.addEventListener('click', (event) => {
            //imgdis.src = event.target.src;
            //imgdis.value = event.target.value;
            //imgdis.accessKey = event.target.accessKey;
         });
         imageList.appendChild(img);
         id++;
      });
   }

   /*function update_selected_images(target){
      target.files = null;
      var newFileList = new DataTransfer();
      for(var ind = 0; ind < allImages.length; ind++) newFileList.items.add(allImages[ind]);
      target.files = newFileList.files;
      console.log('uploadFiles allImages:', allImages);
      console.log('uploadFiles target.files:', target.files);
      show_images();
   }

   function Deleimag(){
      previousFiles.splice(parseInt(//imgdis.accessKey)-allImages.length, 1);
      show_images(); //update_selected_images(imagesInput);
   }*/

   /*addlisnerto.forEach(function(element) {
      element.addEventListener('input', (event) => {
         let shopName = document.getElementById('shop_name').value;
         let timeCode = document.getElementById('time_code').value;
         let itemColor = document.getElementById('item_color').value;
         let itemSize = document.getElementById('item_size').value;
         let itemname = document.getElementById('item_name').value;
         Array.from(previousFiles).forEach(function(file) {
            let type = "";
            if(file["type"] == "image/png")  type = ".png";
            if(file["type"] == "image/jpg") type = ".jpg";
            if(file["type"] == "image/jpeg") type = ".jpeg";
            file["newname"] = shopName+"_"+timeCode+"_"+itemColor+"_"+itemSize+"_"+itemname+type;
         });
         console.log('element previousFiles :', previousFiles);
      });
   });
   // This is where you would upload the files to a server
   function uploadFiles(files) {
      files.forEach(function(image) {
         const img = document.createElement('img');
         img.src = URL.createObjectURL(image);
         img.value = image.name;
         img.className = 'image-item';

         // Set the source of the 'output' object to the clicked image
         //imgdis.src = URL.createObjectURL(image);
         //imgdis.value = image.name;
         
         const src = img.getAttribute('src');
         img.addEventListener('click', (event) => {
            //imgdis.src = event.target.src;
            //imgdis.value = event.target.value;
         });
         imageList.appendChild(img);
      });
      console.log('uploadFiles files:', files);
   }
var GetImageFile = function(file) {
      var input = file.target;
      /*var reader = new FileReader();
      alert("hhhhhhhhhhhhhhh");

      reader.onload = function(){
         var dataURL = reader.result;
         document.querySelector('#step4form .img_info_box .adding_box .output').src = dataURL;
         var src1 = document.querySelector('.add-product-form .input_table .p_img_path1');
         var src2 = document.querySelector('.add-product-form .input_table .p_img_path2');
         src1.value = dataURL;
         src2.value = src2.value + document.querySelector('.add-product-form .input_table .box .adding_box .p_image').value + "~";
         var list = document.querySelector('.add-product-form .input_table .img_info_box .imgs_box');
         
         var img = document.createElement('image');
         img.src = dataURL;
         img.style.width ="100px";
         img.style.height ="100px";
         img.style.color ="black";
         img.value = dataURL;
         list.appendChild(img);
         
         document.querySelector('.add-product-form h3').textContent = src2.value;
      }
      //document.querySelector('#step4form .img_info_box .adding_box .output').src = input.files[0];
      
      alert(input.value);
      alert(document.querySelector('#step4form .img_info_box .adding_box .output').src);
   }*/
</script>