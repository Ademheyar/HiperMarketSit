
<!DOCTYPE html>
<html>
<head>
    <title>Shopping List Management</title>
</head>
<body>
    <h1>Shopping List Management</h1>
    <form>
        Shop Name: <input type="text" id="shop_name"><br>
        Time Code: <input type="text" id="time_code"><br>
        Item Color: <input type="text" id="item_color"><br>
        Item Size: <input type="text" id="item_size"><br>
        Item Quantity: <input type="text" id="item_qty"><br>
        Item Barcode: <input type="text" id="item_barcode"><br>
        Item Image Info: <input type="text" id="item_image_info"><br>
        <button type="button" onclick="saveData()">Save</button>
        <button type="button" onclick="deleteData()">Delete</button>
    </form>

    <h2>Current List</h2>
    <pre id="listDisplay"></pre>
    
    <div id="mainDiv"></div>
</body>
    <script>
    let myList = [
            ['ShopName', [
                ['TimeCode', [
                    ['ItemColor', [
                      ['ItemSize', ['ItemQty', 'ItemBarcode', 'ItemImageInfo']
                      ]
                    ]]
                ]]
            ]]
        ];
    const myListAsString = `[
    ['ShopName', [
        ['TimeCode', [
            ['ItemColor', [
                ['ItemSize', ['ItemQty', 'ItemBarcode', 'ItemImageInfo']]
            ]]
        ]]
    ]]
]`;   

function listToString(inputList) {
    return JSON.stringify(inputList);
}
function stringToList(inputString) {
    return JSON.parse(inputString);
}
function modifyList(lst, path, newValues) {
    let current = lst;
    for (let name of path.slice(0, -1)) {
        let found = false;
        for (let i = 0; i < current.length; i++) {
            if (Array.isArray(current[i]) && current[i][0] === name) {
                current = current[i][1];
                found = true;
                break;
            }
        }
        if (!found) {
            // If the path doesn't exist, create the new path
            let newPath = [name, []];
            current.push(newPath);
            current = newPath[1];
        }
    }

    let lastName = path[path.length - 1];
    for (let i = 0; i < current.length; i++) {
        if (Array.isArray(current[i]) && current[i][0] === lastName) {
            current[i][1].push(...newValues);
            return true;
        }
    }

    // If the last part of the path doesn't exist, create it
    let newLastName = [lastName, [...newValues]];
    current.push(newLastName);
    return true;
}

function deleteFromList(lst, path) {
    if (path.length === 0) {
        return false;
    }

    let current = lst;
    for (let i = 0; i < path.length - 1; i++) {
        let name = path[i];
        let found = false;
        for (let j = 0; j < current.length; j++) {
            if (Array.isArray(current[j]) && current[j][0] === name) {
                current = current[j][1];
                found = true;
                break;
            }
        }
        if (!found) return false;
    }

    let lastName = path[path.length - 1];
    for (let i = 0; i < current.length; i++) {
        if (Array.isArray(current[i]) && current[i][0] === lastName) {
            current.splice(i, 1);
            return true;
        }
    }
    return false;
}

function readList(lst) {
    return lst;
}

        function saveData() {
            let shopName = document.getElementById('shop_name').value;
            let timeCode = document.getElementById('time_code').value;
            let itemColor = document.getElementById('item_color').value;
            let itemSize = document.getElementById('item_size').value;
            let itemQty = document.getElementById('item_qty').value;
            let itemBarcode = document.getElementById('item_barcode').value;
            let itemImageInfo = document.getElementById('item_image_info').value;
            let pathList = [shopName, timeCode, itemColor, itemSize];
            let newpath = []
            for (let value of pathList) {
              if (value.trim() === '') return
              newpath.push(value)
            }
            console.log('Uploading newpath:', newpath);
            // Modify or add to the list based on input values
            modifyList(myList, newpath, [itemQty, itemBarcode, itemImageInfo]);

            // Display what is in the list
            createNextComboBox(null);
        }

        function deleteData() {
            let shopName = document.getElementById('shop_name').value;
            let timeCode = document.getElementById('time_code').value;
            let itemColor = document.getElementById('item_color').value;
            let itemSize = document.getElementById('item_size').value;
            let pathList = [shopName, timeCode, itemColor, itemSize];
            let newpath = []
            for (let value of pathList) {
              if (value.trim() === '') break
              newpath.push(value)
            }
            console.log('dele newpath:', newpath);
            // Delete specified data from the list
            deleteFromList(myList, newpath);

            // Display what is in the list
            displayList();
            createNextComboBox(null);
        }
        
  let selectedValues = [];

  function createNextComboBox(selectedValue) {
    const mainDiv = document.getElementById("mainDiv");
    const existingComboBox = document.querySelector("#mainDiv select");
    if (selectedValues.length < document.querySelectorAll("#mainDiv select").length) {
          if (existingComboBox) {
             let sibling = existingComboBox.nextElementSibling;
        while (sibling) {
          mainDiv.removeChild(sibling);
          sibling = existingComboBox.nextElementSibling;
        }
        mainDiv.removeChild(existingComboBox);
        selectedValues = [];
          }
        }
        
console.log("gong to create nee");
  const nextList = getList(selectedValues, myList);
console.log("found new ", nextList);
    if (nextList) {
      const newComboBox = document.createElement("select");
      //newComboBox.id = "nextList";
      newComboBox.onchange = function () {
        console.log("Dropdown changed");
        let sibling = this.nextElementSibling;
        while (sibling) {
          mainDiv.removeChild(sibling);
          sibling = this.nextElementSibling;
          if (selectedValues.length > document.querySelectorAll("#mainDiv select").length-1) {
          selectedValues.pop(); // Remove the last selected value
          }
        }
        if (selectedValues.length > document.querySelectorAll("#mainDiv select").length-1) {
      selectedValues.pop(); // Remove the last selected value
    }
        selectedValues.push(this.value)
        createNextComboBox(null);
      };

      nextList.forEach((item) => {
        if(item.length == 2)
        {
          const option = document.createElement("option");
          option.value = item[0];
          option.text = item[0];
          newComboBox.appendChild(option);
        }
        else{
          const option = document.createElement("option");
          option.value = item;
          option.text = item;
          newComboBox.appendChild(option);
        }
      });
      newComboBox.value="";
      mainDiv.appendChild(newComboBox);
    }
  }

  function getList(values, nestedList) {
   // if (!value) {
    //  return nestedList.map((item) => [item[0]]);
    //}
    let currentList = nestedList;
    for (const value of values) {
      const found = currentList.find((item) => item[0] === value);
      if (found) {
        currentList = found[1];
      } else {
        return null;
      }
    }
    return currentList;
  }
  
  createNextComboBox(null);
    </script>
</html>