<div class="list-group" id="side-menu">
<br>
    <a href="home.php" class="list-group-item">Home</a>
    <?php if ($_SESSION['role'] == "ADMIN") : ?>
        <a href="admin/addbdm.php" class="list-group-item">Add BDM</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "ADMIN") : ?>
        <a href="admin/addbde.php" class="list-group-item">Add BDE</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "ADMIN") : ?>
        <a href="admin/addclient.php" class="list-group-item">Add Client</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "ADMIN") : ?>
        <a href="admin/bdmlist.php" class="list-group-item">BDM List</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "ADMIN") : ?>
        <a href="admin/bdelist.php" class="list-group-item">BDE List</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "ADMIN") : ?>
        <a href="admin/clientcompanylist.php" class="list-group-item">Client Company List</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "ADMIN") : ?>
        <a href="admin/clientcontactlist.php" class="list-group-item">Client Contact List</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "ADMIN") : ?>
        <a href="admin/configurations.php" class="list-group-item">Configurations</a>
    <?php endif; ?>
    
      <!--BDE SIDE MENU -->
    <?php if ($_SESSION['role'] == "BDE") : ?>
        <a href="bde/bde_registration.php" class="list-group-item">Add Client</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "BDE") : ?>
        <a href="bde/bde_csv.php" class="list-group-item">CSV File Upload</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "BDE") : ?>
        <a href="bde/bde_clientlist.php" class="list-group-item">Client List</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "BDE") : ?>
        <a href="bde/bde_companyclientlist.php" class="list-group-item"> Company List</a>
    <?php endif; ?>
    
    
    <!-- BDM side menu -->
    <?php if ($_SESSION['role'] == "BDM") : ?>
        <a href="bdm/companylist.php" class="list-group-item">Client Company List</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "BDM") : ?>
        <a href="bdm/clientlist.php" class="list-group-item">Client Contact List</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "BDM") : ?>
        <a href="bdm/bdelist.php" class="list-group-item">BDE List</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "BDM") : ?>
        <a href="bdm/inbox.php" class="list-group-item">Mail Inbox</a>
    <?php endif; ?>
    
    
</div>

 
