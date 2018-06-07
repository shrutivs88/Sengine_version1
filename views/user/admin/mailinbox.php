<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sales Team Application</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo BASEURL; ?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo BASEURL; ?>assets/css/styles.css" />
    <script src="<?php echo BASEURL; ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo BASEURL; ?>assets/js/bootstrap.min.js"></script>
</head>
<body>
    <?php include 'navbar.php';?>
    <div class="content-view">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3">
                    <?php include("sidemenu.php"); ?>
                </div>
                <div class="col-sm-9">
                    <h2 class="text-center">Mail Inbox</h2>
                    <div class="server-message" id="server-message">
                        <?php
                            if(isset($_SESSION["serverMsg"])) {
                                echo "<p class='text-center'>" . $_SESSION["serverMsg"] . "</p>";
                                unset($_SESSION['serverMsg']);
                            }
                        ?>
                    </div>
                    <div id="inbox-div" class="data-list-wrapper">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr class="info">
                                    <th>Date</th>
                                    <th>From</th>
                                    <th>Message</th>
                                    <th>Attachment</th>
                                </tr>
                            </thead>
                            <tbody id="inbox-list"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php';?>
    <script>
    var updateOffset = 0;
    var isUpdateOffsetPristine = true;

    $(document).ready(function() {
        mailInboxFetch();
    });

    function mailInboxFetch() {
        $("#load-more-btn").prop('disabled', true);
        $.ajax({
            type: "POST",
            url: "<?php echo BASEURL ?>actions/admin/performfetchmailinbox.php",
            data: {
                
            },
 
            success: function(response) {
               // console.log(response);
           // exit();
                
                $("#inbox-list").append(response);
                
            },
            error: function(response) {
                $("#inbox-div").html("<h4 class='text-center'>Something Went Wrong!</h4>");
            }
        });
    }

   

  

    </script>
</body>
</html>