var whiteSpaceRegEx = /\s/g;
var mailConfigHost = "";
var mailConfigHostErrFlag = true;
var mailConfigHostErrMsg = "";
var mailConfigUserName = "";
var mailConfigUserNameErrFlag = true;
var mailConfigUserNameErrMsg = "";
var mailConfigPassword = "";
var mailConfigPasswordErrFlag = true;
var mailConfigPasswordErrMsg = "";

function validateMailConfigHost() {
    mailConfigHost = $("#mailConfigHost").val();
    mailConfigHostErrFlag = false;
    mailConfigHostErrMsg = "";
    $("#mailConfigHost").css({"border-color":"green"});
    if(mailConfigHost == "" || mailConfigHost == null || mailConfigHost == undefined) {
        mailConfigHostErrFlag = true;
        mailConfigHostErrMsg = "Host Name Is Required !";
        $("#mailConfigHost").css({"border-color":"red"});
    } else if(mailConfigHost.match(whiteSpaceRegEx)) {
        mailConfigHostErrFlag = true;
        mailConfigHostErrMsg = "Whitespace Is Not Allowed !";
        $("#mailConfigHost").css({"border-color":"red"});
    } else if(!mailConfigHost.replace(whiteSpaceRegEx, '').length) {
        mailConfigHostErrFlag = true;
        mailConfigHostErrMsg = "Host Name Cannot Be Empty !";
        $("#mailConfigHost").css({"border-color":"red"});
    }
    $("#mailConfigHostErrMsg").text(mailConfigHostErrMsg);
}

function validateMailConfigUserName() {
    mailConfigUserName = $("#mailConfigUserName").val();
    mailConfigUserNameErrFlag = false;
    mailConfigUserNameErrMsg = "";
    $("#mailConfigUserName").css({"border-color":"green"});
    if(mailConfigUserName == "" || mailConfigUserName == null || mailConfigUserName == undefined) {
        mailConfigUserNameErrFlag = true;
        mailConfigUserNameErrMsg = "User Name Is Required !";
        $("#mailConfigUserName").css({"border-color":"red"});
    } else if(mailConfigUserName.match(whiteSpaceRegEx)) {
        mailConfigUserNameErrFlag = true;
        mailConfigUserNameErrMsg = "Whitespace Is Not Allowed !";
        $("#mailConfigUserName").css({"border-color":"red"});
    } else if(!mailConfigUserName.replace(whiteSpaceRegEx, '').length) {
        mailConfigUserNameErrFlag = true;
        mailConfigUserNameErrMsg = "User Name Cannot Be Empty !";
        $("#mailConfigUserName").css({"border-color":"red"});
    }
    $("#mailConfigUserNameErrMsg").text(mailConfigUserNameErrMsg);
}

function validateMailConfigPassword() {
    mailConfigPassword = $("#mailConfigPassword").val();
    mailConfigPasswordErrFlag = false;
    mailConfigPasswordErrMsg = "";
    $("#mailConfigPassword").css({"border-color":"green"});
    if(mailConfigPassword == "" || mailConfigPassword == null || mailConfigPassword == undefined) {
        mailConfigPasswordErrFlag = true;
        mailConfigPasswordErrMsg = "Password Is Required !";
        $("#mailConfigPassword").css({"border-color":"red"});
    } else if(mailConfigPassword.match(whiteSpaceRegEx)) {
        mailConfigPasswordErrFlag = true;
        mailConfigPasswordErrMsg = "Whitespace Is Not Allowed !";
        $("#mailConfigPassword").css({"border-color":"red"});
    } else if(!mailConfigPassword.replace(whiteSpaceRegEx, '').length) {
        mailConfigPasswordErrFlag = true;
        mailConfigPasswordErrMsg = "Password Cannot Be Empty !";
        $("#mailConfigPassword").css({"border-color":"red"});
    }
    $("#mailConfigPasswordErrMsg").text(mailConfigPasswordErrMsg);
}

function mailConfigFormValidation() {
    validateMailConfigHost();
    validateMailConfigUserName();
    validateMailConfigPassword();
    if(mailConfigHostErrFlag == false && mailConfigUserNameErrFlag == false && mailConfigPasswordErrFlag == false) {
        $("#mailConfigForm").submit();
    }
}

function mailConfigFormReset() {
    mailConfigFormResetErrFlags();
    mailConfigFormResetErrMsgs();
    mailConfigFormResetErrOnForm();
    $("#server-message").text("");
}

function mailConfigFormResetErrFlags() {
    mailConfigHostErrFlag = true;
    mailConfigUserNameErrFlag = true;
    mailConfigPasswordErrFlag = true;
}

function mailConfigFormResetErrMsgs() {
    mailConfigHost = "";
    mailConfigUserName = "";
    mailConfigPassword = "";
}

function mailConfigFormResetErrOnForm() {
    $("#mailConfigHostErrMsg").text("");
    $("#mailConfigUserNameErrMsg").text("");
    $("#mailConfigPasswordErrMsg").text("");
    $("#mailConfigHost").val("");
    $("#mailConfigUserName").val("");
    $("#mailConfigPassword").val("");
    $("#mailConfigHost").css({"border-color":"#ccc"});
    $("#mailConfigUserName").css({"border-color":"#ccc"});
    $("#mailConfigPassword").css({"border-color":"#ccc"});
}