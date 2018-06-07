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
    <script src="<?php echo BASEURL; ?>assets/js/chrome_fix.js"></script>
    <script src="<?php echo BASEURL; ?>assets/js/admin/sendProposalValidation.js"></script>
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
                    <h2 class="text-center">Send Proposal</h2>
                    <div class="server-message" id="server-message">
                        <?php
                            if(isset($_SESSION["serverMsg"])) {
                                echo "<p class='text-center'>" . $_SESSION["serverMsg"] . "</p>";
                                unset($_SESSION['serverMsg']);
                            }
                        ?>
                    </div>
                    <div class="row">
                        <!-- Send Proposal Content -->
                        
                        <div class="col-sm-offset-1 col-sm-10">
                            <form id="emailForm" class="form-horizontal" enctype="multipart/form-data" action="<?php echo BASEURL; ?>actions/admin/performsendproposal.php" method="post">
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">From</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="fromAddr" id="fromAddr" placeholder="Enter From Address" class="form-control" readonly>
                                        <p id="fromAddrErrMsg"></p>
                                    </div>
                                </div>

                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">To</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="toAddr" id="toAddr" placeholder="Enter To Address" class="form-control" readonly>
                                        <p id="toAddrErrMsg"></p>
                                    </div>
                                </div>

                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Subject</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="subject" id="subject" placeholder="Enter Subject" class="form-control" onfocusout="validateSubject()">
                                        <p id="subjectErrMsg"></p>
                                    </div>
                                </div>

                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Template</label>
                                    <div class="col-sm-9">
                                    <select name="template" id="template" class="form-control">
                                        <option value="">Choose Template</option>
                                    </select>  
                                    <p id="templateErrMsg"></p>
                                    </div>
                                </div>

                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Message</label>
                                    <div class="col-sm-9">
                                       <textarea name="message" id="message" class="mail-message-area form-control" style="resize:none;" onfocusout="validateMessage()"></textarea>
                                        <p id="messageErrMsg"></p>
                                    </div>
                                </div>

                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Attachment</label>
                                    <div class="col-sm-9">
                                        <table id="file-upload-table" border="1">
                                            <tbody id="file-upload-btns">
                                                <tr id="btn-row-1">
                                                    <td colspan="2">
                                                        <input type="file" class="file-attach" name="attach1" id="file1" onclick="fileClicked(event)" onchange="fileChanged(event)">
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot id="file-upload-actions">
                                                <tr>
                                                    <td>
                                                        <button type="button" id="add-another-file-btn" class="btn btn-primary btn-sm" onclick="addAnotherFile()">Add Another File</button>
                                                    </td>
                                                    <td>
                                                        <button type="button" id="remove-file-btn" class="btn btn-warning btn-sm" onclick="removeFile()">Remove File</button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <input type="hidden" name="contactId" value="<?php echo $_GET["contactId"]; ?>">

                                <div class="form-group form-group-mod"> 
                                    <div class="col-sm-12 text-center">
                                        <button id="add-btn" type="button" class="btn btn-primary form-btn" onclick="emailFormValidation()">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php';?>
    <script>
        var fileIndex = 2;
        var isFileOneEmpty = true;
        var isFileTwoEmpty = true;
        var isFileThreeEmpty = true;

        var templatesResponse = null;

        $(document).ready(function() {
            setMessageTemplateOnChange();
            setFromAddress();
            setToAddress();
            loadTemplates();
        });

        function addAnotherFile() {
            if(fileIndex > 3) {
                return;
            }
            var previousAttachment = $("#file" + (fileIndex-1)).val();
            if(previousAttachment == "" || previousAttachment == null || previousAttachment == undefined) {
                alert("No File Selected");
                return;
            }
            var fileRowBuilder = "<tr id='btn-row-" + fileIndex + "'>";
            fileRowBuilder += "<td colspan='2'><input type='file' class='fileAttach' name='attach" + fileIndex + "' id='file" + fileIndex + "' onclick=fileClicked(event) onchange=fileChanged(event)></td>";
            fileRowBuilder += "</tr>";
            $("#file-upload-btns").append(fileRowBuilder);
            fileIndex++;
        }

        function removeFile() {
            if(fileIndex <= 2) {
                $("#file" + (fileIndex-1)).val("");
                return;
            }
            fileIndex--;
            $("#btn-row-" + fileIndex).remove();
        }

        function setFromAddress() {
            $.ajax({
                type: "GET",
                url: "<?php echo BASEURL; ?>actions/admin/performfetchmailconfig.php",
                success: function(response) {
                    $("#fromAddr").val(response.mailConfigUserName)
                }
            });
        }

        function setToAddress() {
            var request = {
                type: "POST",
                url: "<?php echo BASEURL; ?>actions/admin/performfetchcontact.php",
                data: {
                    contactId: <?php echo $_GET["contactId"]; ?>
                },
                success: function(response) {
                    $("#toAddr").val(response.email.split(",")[0].trim());
                }
            };
            $.ajax(request);
        }

        function loadTemplates() {
            var request = {
                type: "GET",
                url: "<?php echo BASEURL; ?>actions/admin/performfetchmailtemplatelistall.php",
                success: function(response) {
                    templatesResponse = response;
                    var templateListBuilder = "<option value=''>Choose Template</option>";
                    for(var i=0; i<response.length; i++) {
                        templateListBuilder += "<option value='" + response[i].mailTemplateId + "'>" + response[i].mailTemplateName + "</option>";
                    }
                    $("#template").html(templateListBuilder);
                }
            };
            $.ajax(request);
        }

        function setMessageTemplateOnChange() {
            $("#template").change(function() {
                var templateId = $("#template").val();
                $.each(templatesResponse, function(key, value) {
                    if(value.mailTemplateId == templateId) {
                        $("#message").val(value.mailTemplateHeader + "\n\n\n" + value.mailTemplateFooter);
                        validateMessage();
                        return;
                    }
                    if(templateId == "" || templateId == null || templateId == undefined) {
                        $("#message").val("");
                        validateMessage();
                        return;
                    }
                });
            });
        }

    </script>
    
</body>
</html>