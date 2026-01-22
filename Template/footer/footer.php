<!-- start #footer Legal Stuff
 
Privacy Policy
 
Security
 
Website Accessibility
 
Manage Cookies -->
<div id="footer">
   <main>
      <div class="footertabs">
         <button class="footertablinks" onclick="footer_openTab(event, 'FooterHomeTab')">Follow Us</button>
         <button class="footertablinks" onclick="footer_openTab(event, 'InfoTab')">Information</button>
         <button class="footertablinks" onclick="footer_openTab(event, 'SubscribeTab')">Subscribe</button>
         <button class="footertablinks" onclick="footer_openTab(event, 'AccountsTab')">Accounts</button>
         <button class="footertablinks" onclick="footer_openTab(event, 'SupportTab')">Report/Support</button>
         <button class="footertablinks" onclick="footer_openTab(event, 'AboutTab')">About</button>
      </div>

      <div id="FooterHomeTab" class="footertabcontent">
        <ul class="footer-list">
            <li>&#10003; Payment Alternatives Buy Now Pay Later</li>
            <li>&#10003; Delivery, Swift Delivery, Including Next Day Options</li>
            <li>&#10003; Not satisfied? Seamless Return & Exchange</li>
       </ul>
         <form class="form-row">
                <div class="col">
                   <input type="text" class="form-control" placeholder="Email *">
                </div>
                <div class="col">
                   <button type="submit" class="btn btn-primary mb-2">Subscribe</button>
                </div>
             </form>
         <div>
            <a href="#" class="color-second font-size-14">Follow Us On:</a>
            <img src="img/icons/facebook.png" alt="Facebook" class="social-icon">
            <img src="img/icons/instagram.png" alt="Instagram" class="social-icon">
            <img src="img/icons/twitter.png" alt="Twitter" class="social-icon">
            <img src="img/icons/whatsapp.png" alt="WhatsApp" class="social-icon">
            <img src="img/icons/tiktok.png" alt="tiktok" class="social-icon">
         </div>
         <div>
            <img src="img/icons/appstore.png" alt="appstore" class="downlodapp-icon">
            <img src="img/icons/googleplay.png" alt="googleplay" class="downlodapp-icon">
         </div>
         <a href="#" class="color-second font-size-14"></a>
      </div>
      
      <div id="InfoTab" class="footertabcontent">
         <div class="footer_container_row">
            <div class="col-lg-3 col-12">
               <h4 class="font-rubik font-size-20">Hiper Market</h4>
               <p class="font-size-14 font-rale text-white-50">looking for.</p>
            </div>
            <div class="col-lg-4 col-12">
               <h4 class="font-rubik font-size-20">Newsletter</h4>
              
            </div>
            <div class="col-lg-2 col-12">
               <h4 class="font-rubik font-size-20">Information</h4>
               <div class="d-flex flex-column flex-wrap">
                  <a href="#" class="font-rale font-size-14 text-white-50 pb-1">About Us</a>
                  <a href="#" class="font-rale font-size-14 text-white-50 pb-1">Delivery Information</a>
                  <a href="#" class="font-rale font-size-14 text-white-50 pb-1">Privacy Policy</a>
                  <a href="#" class="font-rale font-size-14 text-white-50 pb-1">Terms & Conditions</a>
               </div>
            </div>
            <div class="col-lg-2 col-12">
               <h4 class="font-rubik font-size-20">Account</h4>
               <div class="d-flex flex-column flex-wrap">
                  <a href="#" class="font-rale font-size-14 text-white-50 pb-1">My Account</a>
                  <a href="#" class="font-rale font-size-14 text-white-50 pb-1">Order History</a>
                  <a href="#" class="font-rale font-size-14 text-white-50 pb-1">Wish List</a>
                  <a href="#" class="font-rale font-size-14 text-white-50 pb-1">Newsletters</a>
               </div>
            </div>
         </div>
      </div>
      
      <div id="SubscribeTab" class="footertabcontent">

      </div>
      
      <div id="SupportTab" class="footertabcontent">
         <a href="#" class="color-second font-size-14">Support us by sending your feedback, ideas, reports, comments, suggestions, and any other input you may have.</a>
         <form class="form-row">
                <div class="col">
                   <input type="text" class="form-control" placeholder="What's on your mind?">
                </div>
                <div class="col">
                   <button type="submit" class="btn btn-primary mb-2">Send</button>
                </div>
             </form>
      </div>
      
      <div id="AccountsTab" class="footertabcontent">

      </div>
      
      <a href="#" class="color-second font-size-14">&copy; 2022 BY ADDIS_SOFTWARES Adem Heyar (ademheyar@gmail.com)</a>
     <span class="color-second font-size-14"> | All rights reserved.</span>
    </main>
</div>

<!-- Owl-carousel -->
<script>
    const footer = document.getElementById("footer");
    // Handle tab switching
    function footer_openTab(evt, tabName) {
        // Get all tab content elements and hide them
        const tabContent = document.getElementsByClassName("footertabcontent");
        for (let i = 0; i < tabContent.length; i++) {
            tabContent[i].style.display = "none";
        }

        // Remove 'active' class from all tablinks
        const tabLinks = footer.getElementsByClassName("footertablinks");
        for (let i = 0; i < tabLinks.length; i++) {
            tabLinks[i].classList.remove("active");
        }

        // Show the selected tab and mark the corresponding tablink as active
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.classList.add("active");
    }
    footer_openTab({currentTarget: document.getElementsByClassName('footertablinks')[0]}, 'FooterHomeTab');
</script>
<!-- !Owl-carousel -->

<style>
#footer {
    position: relative;
    border-bottom: 1px solid #ccc;
    padding: 20px;
    width: 100%;
    background: #f8f9fa;
}

#footer .footertabs {
   /* display: flex;
    justify-content: space-around;
    align-items: center;
    padding: 10px;
    /*border-radius: 5px;*/
    background: #343a40;
    margin: 5px 0;
    overflow-x: auto;
}

#footer .footertabs button {
    background: none;
    color: #fff;
    border: none;
    cursor: pointer;
    padding: 10px 20px;
    transition: background 0.3s;
}

#footer .footertabs button:hover {
    background: #495057;
    border-radius: 5px;
}

#footer .footertabs button.active {
    background: #007bff;
    border-radius: 5px;
}

#footer .footertabcontent {
    display: none;
    padding: 20px;
    background: #fff;
    border-top: 1px solid #ccc;
    margin-top: 10px;
    min-height: 40℅;
}

.footertabcontent a {
    display: block;
    margin: 5px 0;
    color: #343a40;
    text-decoration: none;
}

.footertabcontent a:hover {
    text-decoration: underline;
}

.footer_container_row {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
}

.footer_container_row .col-12 {
    margin-bottom: 20px;
}

#footer .footer_container_row h4 {
    margin-bottom: 10px;
}

#footer .social-icon {
    width: 24px;
    height: 24px;
    margin: 0 5px;
}
#footer .downlodapp-icon {
    width: auto;
    height: 24px;
    margin: 0 5px;
}

#footer ul {
    list-style: none;
    padding: 0;
}

#footer ul li {
    margin: 10px 0;
    padding-left: 20px;
    position: relative;
}
#footer a.color-second,
#footer span.color-second {
    display: inline-block;
    margin: 5px 0;
    color: #343a40;
    text-decoration: none;
}

#footer a.color-second:hover,
#footer span.color-second:hover {
    text-decoration: underline;
}
</style>