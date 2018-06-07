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
    $("#companyName").attr('title', companyNameErrMsg);
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
    $("#companyWebsite").attr('title', companyWebsiteErrMsg);
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
    $("#companyPhone").attr('title', companyPhoneErrMsg);
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
        $("#companyEmail").css({"border-color":"red"});
    }
    $("#companyEmail").attr('title', companyEmailErrMsg);
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
    $("#companyLinkedIn").attr('title', companyLinkedInErrMsg);
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
    $("#companyAddress").attr('title', companyAddressErrMsg);
}

function isFormValid() {
    validateCompanyName();
    validateCompanyWebsite();
    validateCompanyPhone();
    validateCompanyEmail();
    validateCompanyLinkedIn();
    validateCompanyAddress();
    if(companyNameErrFlag == false && companyWebsiteErrFlag == false 
        && companyPhoneErrFlag == false && companyEmailErrFlag == false 
            && companyLinkedInErrFlag == false && companyAddressErrMsg == false) {
                return true;
            }
            return false;
}