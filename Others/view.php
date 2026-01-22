<!DOCTYPE html>
<html>
<head>
  <title>Scrollable Item List</title>
  <style>
    /* Some basic styling for the scrollable list */
    #itemList {
      height: 400px;
      overflow-y: scroll;
      border: 1px solid #ccc;
      padding: 10px;
    }

    .item {
      padding: 10px;
      margin-bottom: 20px;
      background-color: #f0f0f0;
      border: 1px solid #ddd; /* Border around each item */
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }

    .itemName {
      font-weight: bold;
      margin-bottom: 5px;
    }

    .itemDescription {
      color: #555;
      margin-bottom: 5px;
    }

    .itemPrice {
      color: #007bff;
      font-weight: bold;
    }

    .itemImage {
      max-width: 150px;
      max-height: 150px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

<div id="itemList">
  <!-- Your initial items go here -->
  <div class="item">
    <div class="itemName">Item 1</div>
    <img class="itemImage" src="Img/item1.jpg" onerror="this.onerror=null;this.src='Img/error1.jpg';" alt="Item 1">
    <div class="itemDescription">Description for Item 1 goes here.</div>
    <div class="itemPrice">$19.99</div>
  </div>
  <div class="item">
    <div class="itemName">Item 2</div>
    <img class="itemImage" src="Img/item2.jpg" onerror="this.onerror=null;this.src='Img/error1.jpg';" alt="Item 2">
    <div class="itemDescription">Description for Item 2 goes here.</div>
    <div class="itemPrice">$24.99</div>
  </div>
  <!-- ... -->
</div>

<script>
  // Number of items initially loaded
  const initialItems = 10;

  // Function to create new items
  function createNewItem(index) {
    const newItem = document.createElement('div');
    newItem.classList.add('item');

    const itemName = document.createElement('div');
    itemName.classList.add('itemName');
    itemName.textContent = `Item ${index}`;
    newItem.appendChild(itemName);

    const itemImage = document.createElement('img');
    itemImage.classList.add('itemImage');
    itemImage.src = `Img/item${index}.jpg`; // Assuming images are named as item1.jpg, item2.jpg, etc.
    itemImage.onerror = function() {
      this.onerror = null;
      this.src = 'Img/error1.jpg'; // Replace with error image path
    };
    newItem.appendChild(itemImage);

    const itemDescription = document.createElement('div');
    itemDescription.classList.add('itemDescription');
    itemDescription.textContent = `Description for Item ${index} goes here.`;
    newItem.appendChild(itemDescription);

    const itemPrice = document.createElement('div');
    itemPrice.classList.add('itemPrice');
    itemPrice.textContent = `$${(Math.random() * 50).toFixed(2)}`; // Random price
    newItem.appendChild(itemPrice);

    return newItem;
  }

  // Function to check if scroll is at the bottom
  function isScrollAtBottom() {
    const itemList = document.getElementById('itemList');
    return itemList.scrollTop + itemList.clientHeight >= itemList.scrollHeight;
  }

  // Function to load more items
  function loadMoreItems() {
    const itemList = document.getElementById('itemList');
    const totalItems = itemList.getElementsByClassName('item').length;

    for (let i = totalItems + 1; i <= totalItems + 5; i++) {
      const newItem = createNewItem(i);
      itemList.appendChild(newItem);
    }
  }

  // Load initial items
  for (let i = 4; i <= initialItems; i++) {
    const newItem = createNewItem(i);
    document.getElementById('itemList').appendChild(newItem);
  }

  // Event listener for scrolling
  document.getElementById('itemList').addEventListener('scroll', function() {
    if (isScrollAtBottom()) {
      loadMoreItems();
    }
  });
</script>

</body>
</html>
