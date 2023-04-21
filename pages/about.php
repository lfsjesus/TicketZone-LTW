<?php 
declare(strict_types = 1);

require_once(__DIR__ .  '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/session.php');

$session = new Session();

  drawHeader();
  drawNavbar($session);
  ?>
    <main>
        <p>
        Welcome to Name! We are a team of dedicated professionals committed to helping you resolve your customer issues promptly and efficiently. Our website provides a comprehensive ticketing system that enables you to submit, track, and resolve issues with ease.
        Our mission is to provide you with the tools and resources you need to streamline your support processes, improve customer satisfaction, and drive business success. We understand the importance of timely and effective support, and we strive to deliver exceptional service to all of our customers.
          At Name, we believe that great customer service is the foundation of any successful business. That's why we are committed to providing you with an intuitive and user-friendly platform that enables you to manage your customer issues seamlessly. Whether you're a small business owner or a large enterprise, our website has everything you need to deliver top-notch support to your customers.
        Thank you for choosing Name as your partner in customer support. We look forward to working with you and helping you achieve your business goals.
        </p>    
    </main>
  
  <?php
  drawFooter();
?>