var whiteSpaceRegEx = /\s/g;
var alphabetsWithWhiteSpaceRegEx = /\w+/g;
var websiteRegEx = /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)?/g;
var phoneRegEx = /^\d{10}$/;
var emailRegEx = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
var companyName = "";
var companyNameErrFlag = true;
var companyNameErrMsg = "";
var companyWebsite = "";
var companyWebsiteErrFlag = true;
var companyWebsiteErrMsg = "";
var companyPhone = "";
var companyPhoneErrFlag = true;
var companyPhoneErrMsg = "";
var companyEmail = "";
var companyEmailErrFlag = true;
var companyEmailErrMsg = "";
var companyLinkedIn = "";
var companyLinkedInErrFlag = true;
var companyLinkedInErrMsg = "";
var companyAddress = "";
var companyAddressErrFlag = true;
var companyAddressErrMsg = "";
var assignToBdm = "";
var assignToBdmErrFlag = true;
var assignToBdmErrMsg = "";
var assignToBde = "";
var assignToBdeErrFlag = true;
var assignToBdeErrMsg = "";

function validateCompanyName() {
    companyName = $("#companyName").val();
    companyNameErrFlag = false;
    companyNameErrMsg = "";
    $("#companyName").css({"border-color":"green"});
    if(companyName == "" || companyName == null || companyName == undefined) {
        companyNameErrFlag = true;
        companyNameErrMsg = "Company Name Is Required !";
        $("#companyName").css({"border-color":"red"});
    } else if(!companyName.match(alphabetsWithWhiteSpaceRegEx)) {
        companyNameErrFlag = true;
        companyNameErrMsg = "Whitespace Is Not Allowed !";
        $("#companyName").css({"border-color":"red"});
    }
    $("#companyNameErrMsg").text(companyNameErrMsg);
}

function validateCompanyWebsite() {
    companyWebsite = $("#companyWebsite").val();
    companyWebsiteErrFlag = false;
    companyWebsiteErrMsg = "";
    $("#companyWebsite").css({"border-color":"green"});
    if(companyWebsite == "" || companyWebsite == null || companyWebsite == undefined) {
        companyWebsiteErrFlag = true;
        companyWebsiteErrMsg = "Company Website Is Required !";
        $("#companyWebsite").css({"border-color":"red"});
    } else if(companyWebsite.match(whiteSpaceRegEx)) {
        companyWebsiteErrFlag = true;
        companyWebsiteErrMsg = "Whitespace Is Not Allowed !";
        $("#companyWebsite").css({"border-color":"red"});
    } else if(!companyWebsite.match(websiteRegEx)) {
        companyWebsiteErrFlag = true;
        companyWebsiteErrMsg = "Website Format Is Not Valid !";
        $("#companyWebsite").css({"border-color":"red"});
    }
    $("#companyWebsiteErrMsg").text(companyWebsiteErrMsg);
}

function validateCompanyPhone() {
    companyPhone = $("#companyPhone").val();
    companyPhoneErrFlag = false;
    companyPhoneErrMsg = "";
    $("#companyPhone").css({"border-color":"green"});
    if(companyPhone == "" || companyPhone == null || companyPhone == undefined) {
        companyPhoneErrFlag = true;
        companyPhoneErrMsg = "Company Phone Is Required !";
        $("#companyPhone").css({"border-color":"red"});
    } else if(companyPhone.match(whiteSpaceRegEx)) {
        companyPhoneErrFlag = true;
        companyPhoneErrMsg = "Whitespace Is Not Allowed !";
        $("#companyPhone").css({"border-color":"red"});
    } else if(!companyPhone.match(phoneRegEx)) {
        companyPhoneErrFlag = true;
        companyPhoneErrMsg = "Phone Number Format Is Not Valid !";
        $("#companyPhone").css({"border-color":"red"});
    }
    $("#companyPhoneErrMsg").text(companyPhoneErrMsg);
}

function validateCompanyEmail() {
    companyEmail = $("#companyEmail").val();
    companyEmailErrFlag = false;
    companyEmailErrMsg = "";
    $("#companyEmail").css({"border-color":"green"});
    if(companyEmail == "" || companyEmail == null || companyEmail == undefined) {
        companyEmailErrFlag = true;
        companyEmailErrMsg = "Company E-Mail Is Required !";
        $("#companyEmail").css({"border-color":"red"});
    } else if(companyEmail.match(whiteSpaceRegEx)) {
        companyEmailErrFlag = true;
        companyEmailErrMsg = "Whitespace Is Not Allowed !";
        $("#companyEmail").css({"border-color":"red"});
    } else if(!companyEmail.match(emailRegEx)) {
        companyEmailErrFlag = true;
        companyEmailErrMsg = "E-Mail Format Is Not Valid !";
        $("#companyPhone").css({"border-color":"red"});
    }
    $("#companyEmailErrMsg").text(companyEmailErrMsg);
}

function validateCompanyLinkedIn() {
    companyLinkedIn = $("#companyLinkedIn").val();
    companyLinkedInErrFlag = false;
    companyLinkedInErrMsg = "";
    $("#companyLinkedIn").css({"border-color":"green"});
    if(companyLinkedIn == "" || companyLinkedIn == null || companyLinkedIn == undefined) {
        companyLinkedInErrFlag = true;
        companyLinkedInErrMsg = "Company LinkedId Is Required !";
        $("#companyLinkedIn").css({"border-color":"red"});
    } else if(companyLinkedIn.match(whiteSpaceRegEx)) {
        companyLinkedInErrFlag = true;
        companyLinkedInErrMsg = "Whitespace Is Not Allowed !";
        $("#companyLinkedIn").css({"border-color":"red"});
    }
    $("#companyLinkedInErrMsg").text(companyLinkedInErrMsg);
}

function validateCompanyAddress() {
    companyAddress = $("#companyAddress").val();
    companyAddressErrFlag = false;
    companyAddressErrMsg = "";
    $("#companyAddress").css({"border-color":"green"});
    if(companyAddress == "" || companyAddress == null || companyAddress == undefined) {
        companyAddressErrFlag = true;
        companyAddressErrMsg = "Company Address Is Required !";
        $("#companyAddress").css({"border-color":"red"});
    }
    $("#companyAddressErrMsg").text(companyAddressErrMsg);
}

function validateAssignToBdm() {
    assignToBdm = $("#assignToBdm").val();
    assignToBdmErrFlag = false;
    assignToBdmErrMsg = "";
    $("#assignToBdm").css({"border-color":"green"});
    if(assignToBdm == "" || assignToBdm == null || assignToBdm == undefined) {
        assignToBdmErrFlag = true;
        assignToBdmErrMsg = "BDM Is Required !";
        $("#assignToBdm").css({"border-color":"red"});
    }
    $("#assignToBdmErrMsg").text(assignToBdmErrMsg);
}

function validateAssignToBde() {
    assignToBde = $("#assignToBde").val();
    assignToBdeErrFlag = false;
    assignToBdeErrMsg = "";
    $("#assignToBde").css({"border-color":"green"});
    if(assignToBde == "" || assignToBde == null || assignToBde == undefined) {
        assignToBdeErrFlag = true;
        assignToBdeErrMsg = "BDE Is Required !";
        $("#assignToBde").css({"border-color":"red"});
    }
    $("#assignToBdeErrMsg").text(assignToBdeErrMsg);
}

function addClientFormValidation() {
    validateCompanyName();
    validateCompanyWebsite();
    validateCompanyPhone();
    validateCompanyEmail();
    validateCompanyLinkedIn();
    validateCompanyAddress();
    validateAssignToBdm();
    validateAssignToBde();
    if(companyNameErrFlag == false && companyWebsiteErrFlag == false 
        && companyPhoneErrFlag == false && companyEmailErrFlag == false 
            && companyLinkedInErrFlag == false && companyAddressErrMsg == false 
                && assignToBdmErrFlag == false && assignToBdeErrFlag == false) {
                    $("#addClientForm").submit();
                }
}

function addClientFormReset() {
    addClientFormResetErrFlags();
    addClientFormResetErrMsgs();
    addClientFormResetErrOnForm();
    $("#server-message").text("");
}

function addClientFormResetErrFlags() {
    companyNameErrFlag = true;
    companyWebsiteErrFlag = true;
    companyPhoneErrFlag = true;
    companyEmailErrFlag = true;
    companyLinkedInErrFlag = true;
    companyAddressErrFlag = true;
    assignToBdmErrFlag = true;
}

function addClientFormResetErrMsgs() {
    companyNameErrMsg = "";
    companyWebsiteErrMsg = "";
    companyPhoneErrMsg = "";
    companyEmailErrMsg = "";
    companyLinkedInErrMsg = "";
    companyAddressErrMsg = "";
    assignToBdmErrMsg = "";
}

function addClientFormResetErrOnForm() {
    $("#companyNameErrMsg").text("");
    $("#companyWebsiteErrMsg").text("");
    $("#companyPhoneErrMsg").text("");
    $("#companyEmailErrMsg").text("");
    $("#companyLinkedInErrMsg").text("");
    $("#companyAddressErrMsg").text("");
    $("#assignToBdmErrMsg").text("");
    $("#companyName").val("");
    $("#companyWebsite").val("");
    $("#companyPhone").val("");
    $("#companyEmail").val("");
    $("#companyLinkedIn").val("");
    $("#companyAddress").val("");
    $("#assignToBdm").val("");
    $("#companyName").css({"border-color":"#ccc"});
    $("#companyWebsite").css({"border-color":"#ccc"});
    $("#companyPhone").css({"border-color":"#ccc"});
    $("#companyEmail").css({"border-color":"#ccc"});
    $("#companyLinkedIn").css({"border-color":"#ccc"});
    $("#companyAddress").css({"border-color":"#ccc"});
    $("#assignToBdm").css({"border-color":"#ccc"});
}