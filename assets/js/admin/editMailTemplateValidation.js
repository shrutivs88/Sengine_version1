var whiteSpaceRegEx = /\s/g;
var templateName = "";
var templateNameErrFlag = true;
var templateNameErrMsg = "";
var templateHeader = "";
var templateHeaderErrFlag = true;
var templateHeaderErrMsg = "";
var templateFooter = "";
var templateFooterErrFlag = true;
var templateFooterErrMsg = "";

function validateTemplateName() {
    templateName = $("#templateName").val();
    templateNameErrFlag = false;
    templateNameErrMsg = "";
    $("#templateName").css({"border-color":"green"});
    if(templateName == "" || templateName == null || templateName == undefined) {
        templateNameErrFlag = true;
        templateNameErrMsg = "Template Name Is Required !";
        $("#templateName").css({"border-color":"red"});
    } else if(!templateName.replace(whiteSpaceRegEx, '').length) {
        templateNameErrFlag = true;
        templateNameErrMsg = "Template Name Cannot Be Empty !";
        $("#templateName").css({"border-color":"red"});
    }
    $("#templateNameErrMsg").text(templateNameErrMsg);
}

function validateTemplateHeader() {
    templateHeader = $("#templateHeader").val();
    templateHeaderErrFlag = false;
    templateHeaderErrMsg = "";
    $("#templateHeader").css({"border-color":"green"});
    if(templateHeader == "" || templateHeader == null || templateHeader == undefined) {
        templateHeaderErrFlag = true;
        templateHeaderErrMsg = "Template Header Is Required !";
        $("#templateHeader").css({"border-color":"red"});
    } else if(!templateHeader.replace(whiteSpaceRegEx, '').length) {
        templateHeaderErrFlag = true;
        templateHeaderErrMsg = "Template Header Cannot Be Empty !";
        $("#templateHeader").css({"border-color":"red"});
    }
    $("#templateHeaderErrMsg").text(templateHeaderErrMsg);
}

function validateTemplateFooter() {
    templateFooter = $("#templateFooter").val();
    templateFooterErrFlag = false;
    templateFooterErrMsg = "";
    $("#templateFooter").css({"border-color":"green"});
    if(templateFooter == "" || templateFooter == null || templateFooter == undefined) {
        templateFooterErrFlag = true;
        templateFooterErrMsg = "Template Footer Is Required !";
        $("#templateFooter").css({"border-color":"red"});
    } else if(!templateFooter.replace(whiteSpaceRegEx, '').length) {
        templateFooterErrFlag = true;
        templateFooterErrMsg = "Template Footer Cannot Be Empty !";
        $("#templateFooter").css({"border-color":"red"});
    }
    $("#templateFooterErrMsg").text(templateFooterErrMsg);
}

function mailTemplateFormValidation() {
    validateTemplateName();
    validateTemplateHeader();
    validateTemplateFooter();
    if(templateNameErrFlag == false && templateHeaderErrFlag == false && templateFooterErrFlag == false) {
        $("#mailTemplateForm").submit();
    }
}

function mailTemplateFormReset() {
    mailTemplateFormResetErrFlags();
    mailTemplateFormResetErrMsgs();
    mailTemplateFormResetErrOnForm();
    $("#server-message").text("");
}

function mailTemplateFormResetErrFlags() {
    templateNameErrFlag = true;
    templateHeaderErrFlag = true;
    templateFooterErrFlag = true;
}

function mailTemplateFormResetErrMsgs() {
    templateName = "";
    templateHeader = "";
    templateFooter = "";
}

function mailTemplateFormResetErrOnForm() {
    $("#templateNameErrMsg").text("");
    $("#templateHeaderErrMsg").text("");
    $("#templateFooterErrMsg").text("");
    $("#templateName").val("");
    $("#templateHeader").val("");
    $("#templateFooter").val("");
    $("#templateName").css({"border-color":"#ccc"});
    $("#templateHeader").css({"border-color":"#ccc"});
    $("#templateFooter").css({"border-color":"#ccc"});
}