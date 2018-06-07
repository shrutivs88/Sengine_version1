<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-header-collape" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../home.php">Sales Team App</a>
        </div>
        <div class="collapse navbar-collapse" id="app-header-collape">
            <ul class="nav navbar-nav">
                <li><a href="../home.php">Home</a></li>
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
                 <li><a href="companylist.php">Client Company List</a></li>
                <li><a href="clientlist.php">Client Contact List</a></li>
                 <li><a href="bdelist.php">BDE List</a></li>
                 <li><a href="inbox.php">Mail Inbox</a></li>
                     
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
                <li><a href="../editprofile.php"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
                <li><a href="<?php echo BASEURL; ?>actions/performlogout.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
            </ul>
        </div>
    </div>
</nav>