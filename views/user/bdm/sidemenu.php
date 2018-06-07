<div class="list-group" id="side-menu">
<br>
    <a href="home.php" class="list-group-item">Home</a>
     <?php if ($_SESSION['role'] == "BDM") : ?>
        <a href="companylist.php" class="list-group-item">Client Company List</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "BDM") : ?>
        <a href="clientlist.php" class="list-group-item">Client Contact List</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "BDM") : ?>
        <a href="bdelist.php" class="list-group-item">BDE List</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "BDM"): ?>
        <a href="inbox.php" class="list-group-item"> Mail Inbox</a>
    <?php endif; ?>
 
  
</div>