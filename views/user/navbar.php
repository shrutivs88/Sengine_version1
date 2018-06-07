 <?php if ($_SESSION['role'] == "ADMIN") : ?>   
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-header-collape" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="home.php">Sales Team App</a>
        </div>
        <div class="collapse navbar-collapse" id="app-header-collape">
            <ul class="nav navbar-nav">
                <li><a href="home.php">Home</a></li>
                <!-- Admin Access Only -->
                <?php if ($_SESSION['role'] == "ADMIN") : ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">BDM<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="admin/addbdm.php">Add BDM</a></li>
                        <li><a href="admin/bdmlist.php">BDM List</a></li>
                    </ul>
                </li>
                <?php endif; ?>
                <!-- Admin Access Only -->
                <?php if ($_SESSION['role'] == "ADMIN") : ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">BDE<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="admin/addbde.php">Add BDE</a></li>
                        <li><a href="admin/bdelist.php">BDE List</a></li>
                    </ul>
                </li>
                <?php endif; ?>
                <!--Admin And BDE Access Only -->
                <?php if ($_SESSION['role'] == "ADMIN") : ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Client<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="admin/addclient.php">Add Client</a></li>
                        <li><a href="admin/clientcompanylist.php">Client Company List</a></li>
                        <li><a href="admin/clientcontactlist.php">Client Contact List</a></li>
                    </ul>
                </li>
                <?php endif; ?>
                <!-- Admin Access Only -->
                <?php if ($_SESSION['role'] == "ADMIN") : ?>
                    <li><a href="admin/configurations.php">Configurations</a></li>
                    <li><a href="admin/mailinbox.php">Mail Inbox</a></li>
                <?php endif; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a>Welcome, <?php echo $_SESSION['email']; ?></a></li>
                <li><a href="editprofile.php">Edit Profile</a></li>
                <li><a href="<?php echo BASEURL; ?>actions/performlogout.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
            </ul>
        </div>
    </div>
</nav>
 <?php endif; ?>    
<!--BDE ACCESS -->
<?php if ($_SESSION['role'] == "BDE") : ?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-header-collape" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="home.php">Sales Team App</a>
        </div>
        <div class="collapse navbar-collapse" id="app-header-collape">
            <ul class="nav navbar-nav">
                <li><a href="home.php">Home</a></li>
                <li><a href="bde/bde_companyclientlist.php">Company List</a></li>
                <!-- BDM & BDE Access Only -->
                
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Client<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <!-- BDE Access Only -->
                        <li><a href="bde/bde_registration.php">Add Client</a></li>
                        <li><a href="bde/bde_csv.php">BDE via CSV</a></li>
                        <li><a href="bde/bde_clientlist.php">Client List</a></li>
                      <!--  <li><a href="companyclientlist.php">Company Client List</a></li>-->
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a>Welcome, <?php echo $_SESSION['email']; ?></a></li>
               <li><a href="editprofile.php"><span class="glyphicon glyphicon-user"></span>Edit Profile</a></li> 
                <li><a href="<?php echo BASEURL; ?>actions/performlogout.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
            </ul>
        </div>
    </div>
</nav>
<?php endif; ?>

<!-- BDM navbar -->
 <?php if ($_SESSION['role'] == "BDM") : ?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-header-collape" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="home.php">Sales Team App</a>
        </div>
        <div class="collapse navbar-collapse" id="app-header-collape">
            <ul class="nav navbar-nav">
                <li><a href="home.php">Home</a></li>
                <!-- Admin Access Only -->
                <?php if ($_SESSION['role'] == "ADMIN") : ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">BDM<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Add BDM</a></li>
                        <li><a href="#">BDM List</a></li>
                    </ul>
                </li>
                <?php endif; ?>
                <!-- Admin Access Only -->
                <?php if ($_SESSION['role'] == "ADMIN") : ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">BDE<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Add BDE</a></li>
                        <li><a href="#">BDE List</a></li>
                    </ul>
                </li>
                <?php endif; ?>
                
                <!-- BDM Access Only -->
                <?php if ($_SESSION['role'] == "BDM") : ?>
                 <li><a href="bdm/companylist.php">Client Company List</a></li>
                <li><a href="bdm/clientlist.php">Client Contact List</a></li>
                 <li><a href="bdm/bdelist.php">BDE List</a></li>
                 <li><a href="bdm/inbox.php">Mail Inbox</a></li>
                     
                <?php endif; ?>

                <!-- BDE Access Only -->
                <?php if ($_SESSION['role'] == "BDE") : ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Client<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <!-- BDE Access Only -->
                        <li><a href="#">Add Client</a></li>
                        <li><a href="#">Client List</a></li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a>Welcome, <?php echo $_SESSION['email']; ?></a></li>
                <li><a href="editprofile.php"><span class="glyphicon glyphicon-user"></span>Edit Profile</a></li>
                <li><a href="<?php echo BASEURL; ?>actions/performlogout.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
            </ul>
        </div>
    </div>
</nav>
 <?php endif; ?>