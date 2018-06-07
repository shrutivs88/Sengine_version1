var whiteSpaceRegEx = /\s/g;
var alphabetsWithWhiteSpaceRegEx = /\w+/g;
var phoneRegEx = /^\d{10}$/;
var emailRegEx = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
contactFirstName = "";
contactFirstNameErrFlag = true;
contactFirstNameErrMsg = "";
contactLastName = "";
contactLastNameErrFlag = true;
contactLastNameErrMsg = "";
contactEmail = "";
contactEmailErrFlag = true;
contactEmailErrMsg = "";
contactCategory = "";
contactCategoryErrFlag = true;
contactCategoryErrMsg = "";
contactDesignation = "";
contactDesignationErrFlag = true;
contactDesignationErrMsg = "";
contactMobile = "";
contactMobileErrFlag = true;
contactMobileErrMsg = "";
contactCountry = "";
contactCountryErrFlag = true;
contactCountryErrMsg = "";
contactState = "";
contactStateErrFlag = true;
contactStateErrMsg = "";
contactCity = "";
contactCityErrFlag = true;
contactCityErrMsg = "";
contactLinkedIn = "";
contactLinkedInErrFlag = true;
contactLinkedInErrMsg = "";
contactFacebook = "";
contactFacebookErrFlag = true;
contactFacebookErrMsg = "";
contactTwitter = "";
contactTwitterErrFlag = true;
contactTwitterErrMsg = "";
contactAddress = "";
contactAddressErrFlag = true;
contactAddressErrMsg = "";

function validateContactFirstName() {
    var inputElement = $("#contact-first-name-div input");
    var errorElement = $("#contact-first-name-div p");
    contactFirstName = inputElement.val();
    contactFirstNameErrFlag = false;
    contactFirstNameErrMsg = "";
    inputElement.css({"border-color":"green"});
    if(contactFirstName == "" || contactFirstName == null || contactFirstName == undefined) {
        contactFirstNameErrFlag = true;
        contactFirstNameErrMsg = "First Name Is Required !";
        inputElement.css({"border-color":"red"});
    } else if(contactFirstName.match(whiteSpaceRegEx)) {
        contactFirstNameErrFlag = true;
        contactFirstNameErrMsg = "Whitespace Is Not Allowed !";
        inputElement.css({"border-color":"red"});
    }
    errorElement.text(contactFirstNameErrMsg);
}

function validateContactLastName() {
    var inputElement = $("#contact-last-name-div input");
    var errorElement = $("#contact-last-name-div p");
    contactLastName = inputElement.val();
    contactLastNameErrFlag = false;
    contactLastNameErrMsg = "";
    inputElement.css({"border-color":"green"});
    if(contactLastName == "" || contactLastName == null || contactLastName == undefined) {
        contactLastNameErrFlag = true;
        contactLastNameErrMsg = "Last Name Is Required !";
        inputElement.css({"border-color":"red"});
    } else if(contactLastName.match(whiteSpaceRegEx)) {
        contactLastNameErrFlag = true;
        contactLastNameErrMsg = "Whitespace Is Not Allowed !";
        inputElement.css({"border-color":"red"});
    }
    errorElement.text(contactLastNameErrMsg);
}

function validateContactEmail() {
    var inputElement = $("#contact-email-div input");
    var errorElement = $("#contact-email-div p");
    contactEmail = inputElement.val();
    contactEmailErrFlag = false;
    contactEmailErrMsg = "";
    inputElement.css({"border-color":"green"});
    if(contactEmail == "" || contactEmail == null || contactEmail == undefined) {
        contactEmailErrFlag = true;
        contactEmailErrMsg = "Email Is Required !";
        inputElement.css({"border-color":"red"});
    } else if(contactEmail.match(whiteSpaceRegEx)) {
        contactEmailErrFlag = true;
        contactEmailErrMsg = "Whitespace Is Not Allowed !";
        inputElement.css({"border-color":"red"});
    } else if(!contactEmail.match(emailRegEx)) {
        contactEmailErrFlag = true;
        contactEmailErrMsg = "E-Mail Format Is Not Valid !";
        inputElement.css({"border-color":"red"});
    }
    errorElement.text(contactEmailErrMsg);
}

function validateContactCategory() {
    var inputElement = $("#contact-category-div input");
    var errorElement = $("#contact-category-div p");
    contactCategory = inputElement.val();
    contactCategoryErrFlag = false;
    contactCategoryErrMsg = "";
    inputElement.css({"border-color":"green"});
    if(contactCategory == "" || contactCategory == null || contactCategory == undefined) {
        contactCategoryErrFlag = true;
        contactCategoryErrMsg = "Category Is Required !";
        inputElement.css({"border-color":"red"});
    }
    errorElement.text(contactCategoryErrMsg);
}

function validateContactDesignation() {
    var inputElement = $("#contact-designation-div input");
    var errorElement = $("#contact-designation-div p");
    contactDesignation = inputElement.val();
    contactDesignationErrFlag = false;
    contactDesignationErrMsg = "";
    inputElement.css({"border-color":"green"});
    if(contactDesignation == "" || contactDesignation == null || contactDesignation == undefined) {
        contactDesignationErrFlag = true;
        contactDesignationErrMsg = "Designation Is Required !";
        inputElement.css({"border-color":"red"});
    }
    errorElement.text(contactDesignationErrMsg);
}

function validateContactMobile() {
    var inputElement = $("#contact-mobile-div input");
    var errorElement = $("#contact-mobile-div p");
    contactMobile = inputElement.val();
    contactMobileErrFlag = false;
    contactMobileErrMsg = "";
    inputElement.css({"border-color":"green"});
    if(contactMobile == "" || contactMobile == null || contactMobile == undefined) {
        contactMobileErrFlag = true;
        contactMobileErrMsg = "Mobile Is Required !";
        inputElement.css({"border-color":"red"});
    } else if(!contactMobile.match(phoneRegEx)) {
        contactMobileErrFlag = true;
        contactMobileErrMsg = "Phone Number Format Is Not Valid !";
        inputElement.css({"border-color":"red"});
    }
    errorElement.text(contactMobileErrMsg);
}

function validateContactCountry() {
    var inputElement = $("#contact-country-div select");
    var errorElement = $("#contact-country-div p");
    contactCountry = inputElement.val();
    contactCountryErrFlag = false;
    contactCountryErrMsg = "";
    inputElement.css({"border-color":"green"});
    if(contactCountry == "" || contactCountry == null || contactCountry == undefined) {
        contactCountryErrFlag = true;
        contactCountryErrMsg = "Country Is Required !";
        inputElement.css({"border-color":"red"});
    }
    errorElement.text(contactCountryErrMsg);
}

function validateContactState() {
    var inputElement = $("#contact-state-div select");
    var errorElement = $("#contact-state-div p");
    contactState = inputElement.val();
    contactStateErrFlag = false;
    contactStateErrMsg = "";
    inputElement.css({"border-color":"green"});
    if(contactState == "" || contactState == null || contactState == undefined) {
        contactStateErrFlag = true;
        contactStateErrMsg = "State Is Required !";
        inputElement.css({"border-color":"red"});
    }
    errorElement.text(contactStateErrMsg);
}

function validateContactCity() {
    var inputElement = $("#contact-city-div select");
    var errorElement = $("#contact-city-div p");
    contactCity = inputElement.val();
    contactCityErrFlag = false;
    contactCityErrMsg = "";
    inputElement.css({"border-color":"green"});
    if(contactCity == "" || contactCity == null || contactCity == undefined) {
        contactCityErrFlag = true;
        contactCityErrMsg = "City Is Required !";
        inputElement.css({"border-color":"red"});
    }
    errorElement.text(contactCityErrMsg);
}

function validateContactLinkedIn() {
    var inputElement = $("#contact-linkedin-div input");
    var errorElement = $("#contact-linkedin-div p");
    contactLinkedIn = inputElement.val();
    contactLinkedInErrFlag = false;
    contactLinkedInErrMsg = "";
    inputElement.css({"border-color":"green"});
    if(contactLinkedIn == "" || contactLinkedIn == null || contactLinkedIn == undefined) {
        contactLinkedInErrFlag = true;
        contactLinkedInErrMsg = "LinkedIn Is Required !";
        inputElement.css({"border-color":"red"});
    }
    errorElement.text(contactLinkedInErrMsg);
}

function validateContactFacebook() {
    var inputElement = $("#contact-facebook-div input");
    var errorElement = $("#contact-facebook-div p");
    contactFacebook = inputElement.val();
    contactFacebookErrFlag = false;
    contactFacebookErrMsg = "";
    inputElement.css({"border-color":"green"});
    if(contactFacebook == "" || contactFacebook == null || contactFacebook == undefined) {
        contactFacebookErrFlag = true;
        contactFacebookErrMsg = "Facebook Is Required !";
        inputElement.css({"border-color":"red"});
    }
    errorElement.text(contactFacebookErrMsg);
}

function validateContactTwitter() {
    var inputElement = $("#contact-twitter-div input");
    var errorElement = $("#contact-twitter-div p");
    contactTwitter = inputElement.val();
    contactTwitterErrFlag = false;
    contactTwitterErrMsg = "";
    inputElement.css({"border-color":"green"});
    if(contactTwitter == "" || contactTwitter == null || contactTwitter == undefined) {
        contactTwitterErrFlag = true;
        contactTwitterErrMsg = "Twitter Is Required !";
        inputElement.css({"border-color":"red"});
    }
    errorElement.text(contactTwitterErrMsg);
}

function validateContactAddress() {
    var inputElement = $("#contact-address-div textarea");
    var errorElement = $("#contact-address-div p");
    contactAddress = inputElement.val();
    contactAddressErrFlag = false;
    contactAddressErrMsg = "";
    inputElement.css({"border-color":"green"});
    if(contactAddress == "" || contactAddress == null || contactAddress == undefined) {
        contactAddressErrFlag = true;
        contactAddressErrMsg = "Address Is Required !";
        inputElement.css({"border-color":"red"});
    }
    errorElement.text(contactAddressErrMsg);
}

function addContactFormReset() {
    addContactFormResetErrFlags();
    addContactFormResetErrMsgs();
    addContactFormResetErrOnForm();
    $("#server-message").text("");
}

function addContactFormResetErrFlags() {
    contactFirstNameErrFlag = true;
    contactLastNameErrFlag = true;
    contactEmailErrFlag = true;
    contactCategoryErrFlag = true;
    contactDesignationErrFlag = true;
    contactMobileErrFlag = true;
    contactCountryErrFlag = true;
    contactStateErrFlag = true;
    contactCityErrFlag = true;
    contactLinkedInErrFlag = true;
    contactFacebookErrFlag = true;
    contactTwitterErrFlag = true;
    contactAddressErrFlag = true;
}

function addContactFormResetErrMsgs() {
    contactFirstNameErrMsg = "";
    contactLastNameErrMsg = "";
    contactEmailErrMsg = "";
    contactCategoryMsg = "";
    contactDesignationErrMsg = "";
    contactMobileErrMsg = "";
    contactCountryErrMsg = "";
    contactStateErrMsg = "";
    contactCityErrMsg = "";
    contactLinkedInErrMsg = "";
    contactFacebookErrMsg = "";
    contactTwitterErrMsg = "";
    contactAddressErrMsg = "";
}

function addContactFormResetErrOnForm() {
    $("#contact-first-name-div p").text("");
    $("#contact-last-name-div p").text("");
    $("#contact-email-div p").text("");
    $("#contact-category-div p").text("");
    $("#contact-designation-div p").text("");
    $("#contact-mobile-div p").text("");
    $("#contact-country-div p").text("");
    $("#contact-state-div p").text("");
    $("#contact-city-div p").text("");
    $("#contact-linkedin-div p").text("");
    $("#contact-facebook-div p").text("");
    $("#contact-twitter-div p").text("");
    $("#contact-address-div p").text("");

    $("#contact-first-name-div input").val("");
    $("#contact-last-name-div input").val("");
    $("#contact-email-div input").val("");
    $("#contact-category-div input").val("");
    $("#contact-designation-div input").val("");
    $("#contact-mobile-div input").val("");
    $("#contact-country-div select").val("");
    $("#contact-state-div select").val("");
    $("#contact-city-div select").val("");
    $("#contact-linkedin-div input").val("");
    $("#contact-facebook-div input").val("");
    $("#contact-twitter-div input").val("");
    $("#contact-address-div textarea").val("");

    $("#contact-first-name-div input").css({"border-color":"#ccc"});
    $("#contact-last-name-div input").css({"border-color":"#ccc"});
    $("#contact-email-div input").css({"border-color":"#ccc"});
    $("#contact-category-div input").css({"border-color":"#ccc"});
    $("#contact-designation-div input").css({"border-color":"#ccc"});
    $("#contact-mobile-div input").css({"border-color":"#ccc"});
    $("#contact-country-div select").css({"border-color":"#ccc"});
    $("#contact-state-div select").css({"border-color":"#ccc"});
    $("#contact-city-div select").css({"border-color":"#ccc"});
    $("#contact-linkedin-div input").css({"border-color":"#ccc"});
    $("#contact-facebook-div input").css({"border-color":"#ccc"});
    $("#contact-twitter-div input").css({"border-color":"#ccc"});
    $("#contact-address-div textarea").css({"border-color":"#ccc"});

}