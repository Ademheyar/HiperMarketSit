<?php
if (session_id() == "") session_start();
@include 'config.php';
$items = array(); // Create an empty array to hold the items

if (isset($_SESSION['Shop_name'])){
  $shopName = $_SESSION['Shop_name'];
  $sql = "SELECT * FROM Shops WHERE shop_name=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $shopName);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $items = $row;
  }
}

?>

<section class="slide_section">
  <div class="slider">
    <div class="slide">
    <?php
    if (!empty($items)) {
      $at = 0;
      foreach (explode(",", $items["banner_image"]) as $img) {
        if ($at == 0) {
          ?>
          <input type="radio" name="radio-btn" id="radio1">
          <div class="st first">
            <img src="<?php echo "./" . $items["shop_name"] . "/banner/" . $img; ?>" alt="">
          </div>
          <?php
        } else {
          ?>
          <input type="radio" name="radio-btn" id="radio1">
          <div class="st">
            <img src="<?php echo "./" . $items["shop_name"] . "/banner/" . $img; ?>" alt="">
          </div>
          <?php
        }
        $at += 1;
      }
    }
    ?>
    </div>
    <div class="nav-m">
      <label for="radio1" class="m-btn"></label>
      <label for="radio2" class="m-btn"></label>
      <label for="radio3" class="m-btn"></label>
    </div>
    <?php
    if (!empty($items) && $items["image"] != "") {
      ?>
      <div class="Profile_image">
        <img src="<?php echo "./" . $items["shop_name"] . "/banner/" . $items["image"]; ?>" alt="">
        <label text="<?php echo $items["shop_name"]; ?>"></label>
        <label text="<?php echo $items["shop_name"]; ?>"></label>
      </div>
      <?php
    } else {
      ?>
      <div class="Profile_image">
        <img src="./img/no_Profile_image.jpg" alt="">
        <label value="sss"><?php echo $items["shop_name"]; ?></label>
      </div>
      <?php
    }
    ?>
  </div>
</section>

<!-- Owl-carousel -->
<script type="text/javascript">
  var counter = 1;
  setInterval(function(){
    if(document.getElementById('radio' + counter)) document.getElementById('radio' + counter).checked=true;
    counter++;
    if (counter > 3) {
      counter = 1;
    }
  }, 5000);
</script>

<!-- !Owl-carousel -->

<style>
  .slide_section {
    padding: 2rem;
    margin: 0;
    height: 30%;
    display: flex;
    justify-content: center;
  }
  
  .slider {
    width: 100%;
    height: auto;
    border-radius: 10px;
    overflow: hidden;
  }
  
  .slider .Profile_image {
   position: absolute;
    width: 15%;
    text-align: center;
    top: 8rem;
    border-image: round;
  }

  .slider .Profile_image img {
    width: 100%;
    top: 12rem;
    border-image: round;
    box-shadow: var(--box-shadow);
    border: var(--border);
    border-radius: 1.5rem;
  }
  
  .slide {
    width: 500%;
    height: 100%;
    display: flex;
  }
  
  .slide input {
    display: none;
  }
  
  .st {
    width: 20%;
    height: 20%;
    transition: 2s;
  }
  
  .st img {
    width: 100%;
  }
  
  .nav-m {
    position: absolute;
    width: 100%;
    margin-top: -40px;
    justify-content: center;
    display: flex;
  }
  
  .nav-auto {
    position: absolute;
    width: 100%;
    display: flex;
    justify-content: center;
  }
  
  .nav-auto div {
    border: 2px solid #23e3c2;
    padding: 5px;
    border-radius: 10px;
    transition: 1s;
  }
  
  .nav-auto div:not(:last-child) {
    margin-right: 30px;
    justify-content: center;
  }
  
  .m-btn {
    border: 2px solid #23e3c2;
    padding: 5px;
    border-radius: 10px;
    cursor: pointer;
    transition: 1s;
  }
  
  .m-btn:not(:last-child) {
    margin-right: 30px;
  }
  
  .m-btn:hover {
    background-color: #23e3c2;
  }
  
  #radio1:checked ~ .first {
    margin-left: 0;
  }
  
  #radio2:checked ~ .first {
    margin-left: -20%;
  }
  
  #radio3:checked ~ .first {
    margin-left: -40%;
  }
  
  #radio1:checked ~ .nav-auto .a-b1 {
    background-color: #23e3c2;
  }
  
  #radio2:checked ~ .nav-auto .a-b2 {
    background-color: #23e3c2;
  }
  
  #radio3:checked ~ .nav-auto .a-b3 {
    background-color: #23e3c2;
  }
</style>
