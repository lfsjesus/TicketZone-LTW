<?php

declare(strict_types=1);

require_once(__DIR__ .  '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/session.php');

$session = new Session();

if (!$session->isLoggedIn()) {
  header('Location: ../pages/login_page.php');
  die();
}

drawHeader("About Us");
?>
<section id="main-wrapper">
  <?php
  drawNavbar($session);
  ?>
  <main>
    <h1>About Us</h1>
    <p>Welcome to TicketZone, your reliable destination for all your support ticket needs. We understand the importance of efficient customer support and strive to provide a seamless experience for both users and businesses.</p>
    <p>At TicketZone, we believe that every customer query deserves attention and resolution. Our mission is to empower businesses to handle support requests effectively while ensuring customers receive timely and satisfactory responses.</p>
    <h3>
      <li>Submit Tickets</li>
    </h3>
    <p>Need assistance or have a question? Our user-friendly ticket submission system allows you to quickly create a support ticket. Simply provide a detailed description of your issue, and our dedicated support team will address it promptly.</p>
    <h3>
      <li>Track Progress</li>
    </h3>
    <p>Stay informed about the progress of your support ticket through our convenient tracking system. You'll receive real-time updates as our team works diligently to resolve your query. We understand that your time is valuable, and our aim is to provide efficient support at every step.</p>
    <h3>
      <li>Expert Assistance</li>
    </h3>
    <p>Our team of knowledgeable support agents is here to help. They have the expertise and experience to address a wide range of issues and provide you with the guidance and solutions you need. Rest assured that your support ticket will be handled by professionals who are committed to delivering exceptional service.</p>
    <h3>
      <li>Knowledge Base</li>
    </h3>
    <p>Explore our comprehensive FAQ, filled with answers that cover frequently asked questions and common troubleshooting steps. This valuable resource allows you to find answers to common issues quickly and efficiently, saving you time and effort.</p>
    <h3>
      <li>Customer Satisfaction</li>
    </h3>
    <p>At TicketZone, we prioritize customer satisfaction. We continuously monitor and improve our support processes to ensure that your experience exceeds expectations.</p>
    <p>Join the TicketZone community today and experience hassle-free support ticket management. We are committed to streamlining the support process, empowering businesses, and providing excellent customer service. Let us assist you in resolving your queries and providing the support you deserve.</p>
  </main>
</section>
<?php
drawFooter();
?>