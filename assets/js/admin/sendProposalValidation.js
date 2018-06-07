var subject = "";
var subjectErrFlag = true;
var subjectErrMsg = "";

var message = "";
var messageErrFlag = true;
var messageErrMsg = "";

function validateSubject() {
    subject = $("#subject").val();
    subjectErrFlag = false;
    subjectErrMsg = "";
    $("#subject").css({"border-color":"green"});
    if(subject == "" || subject == null || subject == undefined) {
        subjectErrFlag = true;
        subjectErrMsg = "Subject Is Required !";
        $("#subject").css({"border-color":"red"});
    }
    $("#subjectErrMsg").text(subjectErrMsg);
}

function validateMessage() {
    message = $("#message").val();
    messageErrFlag = false;
    messageErrMsg = "";
    $("#message").css({"border-color":"green"});
    if(message == "" || message == null || message == undefined) {
        messageErrFlag = true;
        messageErrMsg = "Message Is Required !";
        $("#message").css({"border-color":"red"});
    }
    $("#messageErrMsg").text(messageErrMsg);
}

function emailFormValidation() {
    validateSubject();
    validateMessage();
    if(subjectErrFlag == false && messageErrFlag == false) {
        $("#emailForm").submit();
    }
}
