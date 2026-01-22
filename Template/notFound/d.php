<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Nested List Dropdown</title>
  <style>
    /* Add your styling here */
    /* This is just an example */
    body {
      font-family: Arial, sans-serif;
    }

    #mainDiv {
      margin-top: 20px;
    }

    select {
      padding: 8px;
      font-size: 16px;
      margin-right: 10px;
    }
  </style>
</head>
<body>

<div id="mainDiv"></div>

<script>
  const myList = [
    ['ShopName', [
      ['TimeCode', [
        ['ItemColor', [
          ['ItemSize', ['ItemQty', 'ItemBarcode', 'ItemImageInfo']]
        ]]
      ]]
    ]],
    ['ShopName2', [
      ['TimeCode', [
        ['ItemColor', [
          ['ItemSize', ['ItemQty', 'ItemBarcode', 'ItemImageInfo']]
        ]]
      ]],
      ['TimeCode2', [
        ['ItemColor', [
          ['ItemSize', ['ItemQty', 'ItemBarcode', 'ItemImageInfo']]
        ]]
      ]]
    ]]
  ];
  const selectedValues = [];

  function createNextComboBox(selectedValue) {
    const mainDiv = document.getElementById("mainDiv");
    const existingComboBox = document.getElementById("nextList");
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

</body>
</html>