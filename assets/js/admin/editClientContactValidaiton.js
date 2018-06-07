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
    var inputElement = $("#contact-first-name");
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
    inputElement.attr('title', contactFirstNameErrMsg);
}

function validateContactLastName() {
    var inputElement = $("#contact-last-name");
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
    inputElement.attr('title', contactLastNameErrMsg);
}

function validateContactEmail() {
    var inputElement = $("#contact-email");
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
    }
    inputElement.attr('title', contactEmailErrMsg);
}

function validateContactCategory() {
    var inputElement = $("#contact-category");
    contactCategory = inputElement.val();
    contactCategoryErrFlag = false;
    contactCategoryErrMsg = "";
    inputElement.css({"border-color":"green"});
    if(contactCategory == "" || contactCategory == null || contactCategory == undefined) {
        contactCategoryErrFlag = true;
        contactCategoryErrMsg = "Category Is Required !";
        inputElement.css({"border-color":"red"});
    }
    inputElement.attr('title', contactCategoryErrMsg);
}

function validateContactDesignation() {
    var inputElement = $("#contact-designation");
    contactDesignation = inputElement.val();
    contactDesignationErrFlag = false;
    contactDesignationErrMsg = "";
    inputElement.css({"border-color":"green"});
    if(contactDesignation == "" || contactDesignation == null || contactDesignation == undefined) {
        contactDesignationErrFlag = true;
        contactDesignationErrMsg = "Designation Is Required !";
        inputElement.css({"border-color":"red"});
    }
    inputElement.attr('title', contactDesignationErrMsg);
}

function validateContactMobile() {
    var inputElement = $("#contact-mobile");
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
    inputElement.attr('title', contactMobileErrMsg);
}

function validateContactCountry() {
    var inputElement = $("#contact-country");
    contactCountry = inputElement.val();
    contactCountryErrFlag = false;
    contactCountryErrMsg = "";
    inputElement.css({"border-color":"green"});
    if(contactCountry == "" || contactCountry == null || contactCountry == undefined) {
        contactCountryErrFlag = true;
        contactCountryErrMsg = "Country Is Required !";
        inputElement.css({"border-color":"red"});
    }
    inputElement.attr('title', contactCountryErrMsg);
}

function validateContactState() {
    var inputElement = $("#contact-state");
    contactState = inputElement.val();
    contactStateErrFlag = false;
    contactStateErrMsg = "";
    inputElement.css({"border-color":"green"});
    if(contactState == "" || contactState == null || contactState == undefined) {
        contactStateErrFlag = true;
        contactStateErrMsg = "State Is Required !";
        inputElement.css({"border-color":"red"});
    }
    inputElement.attr('title', contactStateErrMsg);
}

function validateContactCity() {
    var inputElement = $("#contact-city");
    contactCity = inputElement.val();
    contactCityErrFlag = false;
    contactCityErrMsg = "";
    inputElement.css({"border-color":"green"});
    if(contactCity == "" || contactCity == null || contactCity == undefined) {
        contactCityErrFlag = true;
        contactCityErrMsg = "City Is Required !";
        inputElement.css({"border-color":"red"});
    }
    inputElement.attr('title', contactCityErrMsg);
}

function validateContactAddress() {
    var inputElement = $("#contact-address");
    contactAddress = inputElement.val();
    contactAddressErrFlag = false;
    contactAddressErrMsg = "";
    inputElement.css({"border-color":"green"});
    if(contactAddress == "" || contactAddress == null || contactAddress == undefined) {
        contactAddressErrFlag = true;
        contactAddressErrMsg = "Address Is Required !";
        inputElement.css({"border-color":"red"});
    }
    inputElement.attr('title', contactAddressErrMsg);
}

function validateContactLinkedIn() {
    var inputElement = $("#contact-linkedin");
    contactLinkedIn = inputElement.val();
    contactLinkedInErrFlag = false;
    contactLinkedInErrMsg = "";
    inputElement.css({"border-color":"green"});
    if(contactLinkedIn == "" || contactLinkedIn == null || contactLinkedIn == undefined) {
        contactLinkedInErrFlag = true;
        contactLinkedInErrMsg = "LinkedIn Is Required !";
        inputElement.css({"border-color":"red"});
    }
    inputElement.attr('title', contactLinkedInErrMsg);
}

function validateContactFacebook() {
    var inputElement = $("#contact-facebook");
    contactFacebook = inputElement.val();
    contactFacebookErrFlag = false;
    contactFacebookErrMsg = "";
    inputElement.css({"border-color":"green"});
    if(contactFacebook == "" || contactFacebook == null || contactFacebook == undefined) {
        contactFacebookErrFlag = true;
        contactFacebookErrMsg = "Facebook Is Required !";
        inputElement.css({"border-color":"red"});
    }
    inputElement.attr('title', contactFacebookErrMsg);
}

function validateContactTwitter() {
    var inputElement = $("#contact-twitter");
    contactTwitter = inputElement.val();
    contactTwitterErrFlag = false;
    contactTwitterErrMsg = "";
    inputElement.css({"border-color":"green"});
    if(contactTwitter == "" || contactTwitter == null || contactTwitter == undefined) {
        contactTwitterErrFlag = true;
        contactTwitterErrMsg = "Twitter Is Required !";
        inputElement.css({"border-color":"red"});
    }
    inputElement.attr('title', contactTwitterErrMsg);
}

function isFormValid() {
    validateContactFirstName();
    validateContactLastName();
    validateContactEmail();
    validateContactCategory();
    validateContactDesignation();
    validateContactMobile();
    validateContactCountry();
    validateContactState();
    validateContactCity();
    validateContactAddress();
    validateContactLinkedIn();
    validateContactFacebook();
    validateContactTwitter();

    if(contactFirstNameErrFlag == false && contactLastNameErrFlag == false && contactEmailErrFlag == false && 
        contactCategoryErrFlag == false && contactDesignationErrFlag == false && contactMobileErrFlag == false &&
            contactCountryErrFlag == false && contactStateErrFlag == false && contactCityErrFlag == false && 
                contactLinkedInErrFlag == false && contactFacebookErrFlag == false && contactTwitterErrFlag == false &&
                    contactAddressErrFlag == false) {
                        return true;
                    }
                    return false;
}