

        var clients = [];

        var client = {

          "clientFirstName":"",

          "clientLastName":"",

          "clientEmail":"",

          "clientEmail2":"",

          "clientEmail3":"",

          "clientMobile":"",

          "clientCategory":"",

          "clientDesignation":"",

          "clientCity":"",

          "clientState":"",

          "clientCountry":"",

          "clientAddress":"",

          "clientLinkedInid":"",

          "clientFacebookid":"",

          "clientTwitterid":"",

          

        };



        var clientFirstNameErrorFlag = true;

        var clientLastNameErrorFlag = true;

        var clientEmailErrorFlag = true;

        var clientEmailErrorFlag2 = true;

        var clientEmailErrorFlag3 = true;

        var clientMobileErrorFlag = true;

        var clientCategoryErrorFlag = true;

        var clientDesignationErrorFlag = true;

        var clientCityErrorFlag = true;

        var clientStateErrorFlag = true;

        var clientCountryErrorFlag  = true;

        var clientAddressErrorFlag = true;

        var clientLinkedInErrorFlag = true;

        var clientFacebookIdErrorFlag = true;

        var clientTwitterIdErrorFlag = true;

        var multipleEmailsErrFlag = true;
        
        var multipleEmailsErrMessage = "";

        var clientFirstNameErrorMsg = "";

        var clientLastNameErrorMsg = "";

        var clientEmailErrorMsg = "";

        var clientMobileErrorMsg = "";

        var clientCategoryErrorMsg = "";

        var clientDesignationErrorMsg = "";

        var clientCityErrorMsg = "";

        var clientStateErrorMsg = "";

        var clientCountryErrorMsg = "";

        var clientAddressErrorMsg = "";

        var clientLinkedInErrorMsg = "";

        var clientFacebookIdErrorMsg = "";

        var clientTwitterIdErrorMsg = "";



         function validateClientFirstName()

        {

            var clientFirstName = $("#clientFirstName").val().trim();

            clientFirstNameErrorFlag=false;

            clientFirstNameErrorMsg="";

            $("#clientFirstName").css({"border":"2px solid green"});

            if(clientFirstName=="")

            {

                clientFirstNameErrorFlag=true;

                $("#clientFirstName").css({"border":"2px solid red"}) ;

                clientFirstNameErrorMsg="Please Enter Your First Name";

            }

                $("#clientFirstNameError").text(clientFirstNameErrorMsg);

        }



        function validateClientLastName()

        {

            var clientLastName = $("#clientLastName").val().trim();

            clientLastNameErrorFlag=false;

            clientLastNameErrorMsg="";

            $("#clientLastName").css({"border":"2px solid green"});

            if(clientLastName=="")

            {

                clientLastNameErrorFlag=true;

                $("#clientLastName").css({"border":"2px solid red"}) ;

                clientLastNameErrorMsg="Please Enter Your Last Name";

            }

                 $("#clientLastNameError").text(clientLastNameErrorMsg);

        }

	//this below email is for validating the contacts through company list

	function validateClientEmails1()

        {

            var clientEmail = $("#clientEmail").val();

            EmailRegEx= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

            clientEmailErrorFlag=false;

            clientEmailErrorMsg="";

            $("#clientEmail").css({"border":"2px solid green"});

            if(clientEmail=="")

            {

                clientEmailErrorFlag=true;

                $("#clientEmail").css({"border":"2px solid red"}) ;

            }

            else if(!EmailRegEx.test(clientEmail))

            {

                $("#clientEmail").css({"border":"2px solid red"}) ;   

            }

              

        }



        function validateClientEmails2()

        {

            var clientEmail2 = $("#clientEmail2").val();

                EmailRegEx2= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

                clientEmailErrorFlag2=false;

                clientEmailErrorMsg="";

                $("#clientEmail2").css({"border":"2px solid green"});

                if(clientEmail2=="")

                {

                    clientEmailErrorFlag2=true;

                    $("#clientEmail2").css({"border":"2px solid red"}) ;

                }

                else if(!EmailRegEx2.test(clientEmail2))

                {

                    $("#clientEmail2").css({"border":"2px solid red"}) ;     

                }



        }



        function validateClientEmails3()

        {

            var clientEmail3 = $("#clientEmail3").val();

            EmailRegEx3= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

            clientEmailErrorFlag3=false;

            clientEmailErrorMsg="";

            $("#clientEmail3").css({"border":"2px solid green"});

            if(clientEmail3=="")

            {

                clientEmailErrorFlag3=true;

                $("#clientEmail3").css({"border":"2px solid red"}) ;

              //  clientEmailErrorMsg="Please Enter Your Email-Id";

            }

            else if(!EmailRegEx3.test(clientEmail3))

            {

                $("#clientEmail3").css({"border":"2px solid red"}) ;

               // clientEmailErrorMsg="Invalid Email format";      

            }

               // $("#clientEmailError3").text(clientEmailErrorMsg);

        }



//first email validation this through registration of client

        function validateClientEmail()

        {

            var clientEmail = $("#clientEmail").val();

            EmailRegEx= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

            clientEmailErrorFlag=false;

            clientEmailErrorMsg="";

            $("#clientEmail").css({"border":"2px solid green"});

            if(clientEmail=="")

            {

                clientEmailErrorFlag=true;

                $("#clientEmail").css({"border":"2px solid red"}) ;

                clientEmailErrorMsg="Please Enter Your Email-Id";

            }

            else if(!EmailRegEx.test(clientEmail))

           {

                $("#clientEmail").css({"border":"2px solid red"}) ;

                clientEmailErrorMsg="Invalid Email format";

                

           }

                $("#clientEmailError").text(clientEmailErrorMsg);



        }

//second email validation

            function validateClientEmail2()

            {

                var clientEmail2 = $("#clientEmail2").val();

                EmailRegEx2= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

                clientEmailErrorFlag2=false;

                clientEmailErrorMsg="";

                $("#clientEmail2").css({"border":"2px solid green"});

                if(clientEmail2=="")

                {

                    clientEmailErrorFlag2=true;

                    $("#clientEmail2").css({"border":"2px solid red"}) ;

                    clientEmailErrorMsg="Please Enter Your Email-Id";

                }

                else if(!EmailRegEx.test(clientEmail2))

            {

                    $("#clientEmail2").css({"border":"2px solid red"}) ;

                    clientEmailErrorMsg="Invalid Email format";

                    

            }

                    $("#clientEmailError2").text(clientEmailErrorMsg);



            }



 //third email validation

            function validateClientEmail3()

            {

                var clientEmail3 = $("#clientEmail3").val();

                EmailRegEx3= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

                clientEmailErrorFlag3=false;

                clientEmailErrorMsg="";

                $("#clientEmail3").css({"border":"2px solid green"});

                if(clientEmail3=="")

                {

                    clientEmailErrorFlag3=true;

                    $("#clientEmail3").css({"border":"2px solid red"}) ;

                    clientEmailErrorMsg="Please Enter Your Email-Id";

                }

                else if(!EmailRegEx.test(clientEmail3))

            {

                    $("#clientEmail3").css({"border":"2px solid red"}) ;

                    clientEmailErrorMsg="Invalid Email format";

                    

            }

                    $("#clientEmailError3").text(clientEmailErrorMsg);



            } 

 

        function validateClientMobile()

        {

            var clientMobile = $("#clientMobile").val().trim();

            clientMobileErrorFlag=false;

            clientMobileErrorMsg="";

            $("#clientMobile").css({"border":"2px solid green"});

            if(clientMobile==""||clientMobile.length<10||clientMobile.length>10||isNaN(clientMobile))

            {

                clientMobileErrorFlag=true;

                $("#clientMobile").css({"border":"2px solid red"}) ;

                clientMobileErrorMsg="Please Enter Your Mobile number";

            }

                $("#clientMobileError").text(clientMobileErrorMsg);

        }



        function validateClientCategoty()

        {

            var clientCategory = $("#clientCategory").val().trim();

            clientCategoryErrorFlag=false;

            clientCategoryErrorMsg="";

            $("#clientCategory").css({"border":"2px solid green"});

            if(clientCategory=="")

            {

                clientCategoryErrorFlag=true;

                $("#clientCategory").css({"border":"2px solid red"}) ;

                clientCategoryErrorMsg="Please select your category";

            }

                $("#clientCategoryError").text(clientCategoryErrorMsg);

        }



        function validateClientDesignation()

        {

            var clientDesignation = $("#clientDesignation").val().trim();

            clientDesignationErrorFlag=false;

            clientDesignationErrorMsg="";

            $("#clientDesignation").css({"border":"2px solid green"});

            if(clientDesignation=="")

            {

                clientDesignationErrorFlag=true;

                $("#clientDesignation").css({"border":"2px solid red"}) ;

                clientDesignationErrorMsg="Please select your designation";

            }

                $("#clientDesignationError").text(clientDesignationErrorMsg);

        }



        function validateClientCity()

        {

            var clientCity = $("#clientCity").val().trim();

            clientCityErrorFlag=false;

            clientCityErrorMsg="";

            $("#clientCity").css({"border":"2px solid green"});

            if(clientCity=="")

            {

                clientCityErrorFlag=true;

                $("#clientCity").css({"border":"2px solid red"}) ;

                clientCityErrorMsg="Please select your city";

            }

                $("#clientCityError").text(clientCityErrorMsg);



        }

        function validateClientState()

        {

            var clientState = $("#clientState").val().trim();

            clientStateErrorFlag=false;

            clientStateErrorMsg="";

            $("#clientState").css({"border":"2px solid green"});

            if(clientState=="")

            {

                clientStateErrorFlag=true;

                $("#clientState").css({"border":"2px solid red"}) ;

                clientStateErrorMsg="Please select your state";

            }

                $("#clientStateError").text(clientStateErrorMsg);

        }



        function validateClientCountry()

        {

            var clientCountry = $("#clientCountry").val().trim();

            clientCountryErrorFlag=false;

            clientCountryErrorMsg="";

            $("#clientCountry").css({"border":"2px solid green"});

            if(clientCountry=="")

            {

                clientCountryErrorFlag=true;

                $("#clientCountry").css({"border":"2px solid red"}) ;

                clientCountryErrorMsg="Please select your country";

            }

                $("#clientCountryError").text(clientCountryErrorMsg);



        }

        function validateClientAddress()

        {

            var clientAddress = $("#clientAddress").val().trim();

            clientAddressErrorFlag=false;

            clientAddressErrorMsg="";

            $("#clientAddress").css({"border":"2px solid green"});

            if(clientAddress=="")

            {

                clientAddressErrorFlag=true;

                $("#clientAddress").css({"border":"2px solid red"}) ;

                clientAddressErrorMsg="Please enter your Address";

            }

                $("#clientAddressError").text(clientAddressErrorMsg);

        }

        function validateClientLinkedIn()

        {

            var clientLinkedIn = $("#clientLinkedInid").val().trim();

           // clientLinkedInErrorFlag=false;

           //clientLinkedInErrorMsg="";

            $("#clientLinkedInid").css({"border":"2px solid green"});

            if(clientLinkedIn=="" )

            {

                clientLinkedInErrorFlag=true;

               // $("#clientLinkedInid").css({"border":"2px solid red"}) ;

               // clientLinkedInErrorMsg="Please Enter Your Linkedin id";

            }else if(/(ftp|http|https):\/\/?(?:www\.)?linkedin.com(\w+:{0,1}\w*@)?(\S+)(:([0-9])+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/.test(clientLinkedIn))

            {

                clientLinkedInErrorFlag=false;

               // clientLinkedInErrorMsg="<p style='color:green;'>valid Linkedin URL</p>"; 

            }

                $("#clientLinkedInError").text(clientLinkedInErrorMsg);

        }

        

        function validateClientFacebookId()

        {

            var clientFacebookId = $("#clientFacebookid").val().trim();

           // clientFacebookIdErrorFlag=false;

          //  clientFacebookIdErrorMsg="";

            $("#clientFacebookid").css({"border":"2px solid green"});

            if(clientFacebookId=="")

            {

                //clientFacebookIdErrorFlag=true;

                clientFacebookIdErrorFlag=false;

            //    $("#clientFacebookid").css({"border":"2px solid red"}) ;

               // clientFacebookIdErrorMsg="Please Enter Your FacebookmId";

            }

                $("#clientFacebookIdError").text(clientFacebookIdErrorMsg);

        }



        function validateClientTwitterId()

        {

            var clientTwitterId = $("#clientTwitterid").val().trim();

           // clientTwitterIdErrorFlag=false;      

           // clientTwitterIdErrorMsg="";

            $("#clientTwitterid").css({"border":"2px solid green"});

            if(clientTwitterId=="")

            {

                clientTwitterIdErrorFlag=false;

               // $("#clientTwitterid").css({"border":"2px solid red"}) ;

              //  clientTwitterIdErrorMsg="Please Enter your TwitterId";

            }

                $("#clientTwitterIdError").text(clientTwitterIdErrorMsg);

        }

        function validateMultipleEmails(){
            var EmailRegEx= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            var clientMultipleEmails = $("#clientEmail").val().trim();
            var emailsArray = clientMultipleEmails.split(',');
            multipleEmailsErrFlag = false;
            multipleEmailsErrMessage = "";
            $("#clientEmail").css({"border":"2px solid green"});
            if(emailsArray.length === 1 && emailsArray[0] == "") {
                multipleEmailsErrFlag = true;
                multipleEmailsErrMessage = "One Or More Emails Are Required";
                $("#clientEmail").css({"border":"2px solid red"});
            } else if(emailsArray.length > 3) {
                multipleEmailsErrFlag = true;
                multipleEmailsErrMessage = "Maximum Of 3 Emails Are Allowed";
                $("#clientEmail").css({"border":"2px solid red"});
            } else {
                $.each(emailsArray, function(key, value) {
                    if(!value.trim().match(EmailRegEx)) {
                        multipleEmailsErrFlag = true;
                        multipleEmailsErrMessage = "One Or More Email Is Not Valid";
                        $("#clientEmail").css({"border":"2px solid red"});
                    }
                });
            }
            $("#clientEmailError").text(multipleEmailsErrMessage);
        }

        function validateUpdateClient() {
            console.log("validateUpdateClient called");
            validateClientFirstName();

            validateClientLastName();

            validateMultipleEmails();

            validateClientMobile();

            validateClientCategoty();

            validateClientDesignation();

			validateClientAddress();

			validateClientCountry();

            validateClientState();

            validateClientCity();

            if(clientFirstNameErrorFlag == false && clientLastNameErrorFlag == false && multipleEmailsErrFlag == false && 
                clientMobileErrorFlag == false && clientCategoryErrorFlag == false && clientDesignationErrorFlag == false && 
                    clientCityErrorFlag == false && clientStateErrorFlag == false && clientCountryErrorFlag == false && 
                        clientAddressErrorFlag== false) {
                    return true;
                }
                return false;
        }



        function saveClient() {

            validateClientFirstName();

            validateClientLastName();

            validateClientEmail();

            validateClientEmail2();

            validateClientEmail3();

            validateClientMobile();

            validateClientCategoty();

            validateClientDesignation();

			validateClientAddress();

			validateClientCountry();

            validateClientState();

            validateClientCity();

            //check
            
            if(clientFirstNameErrorFlag == false && clientLastNameErrorFlag == false && clientEmailErrorFlag == false &&
                clientEmailErrorFlag2 == false && clientEmailErrorFlag3 == false && clientMobileErrorFlag == false && 
                clientCategoryErrorFlag == false && clientDesignationErrorFlag == false && clientCityErrorFlag == false && 
                clientStateErrorFlag == false && clientCountryErrorFlag == false && clientAddressErrorFlag== false && 
                clientAddressErrorFlag == false)
                {

                    //console.log("success");
                    //step1: get all input data from modal and save it in client object

                    client.clientFirstName = $("#clientFirstName").val();

                    client.clientLastName = $("#clientLastName").val();

                    client.clientEmail = $("#clientEmail").val();

                    client.clientEmail2 = $("#clientEmail2").val();

                    client.clientEmail3 = $("#clientEmail3").val();

                    client.clientMobile = $("#clientMobile").val();

                    client.clientCategory = $("#clientCategory").val();

                    client.clientDesignation = $("#clientDesignation").val();

                    client.clientAddress = $("#clientAddress").val();

                    client.clientCountry = $("#clientCountry").val();

                    client.clientState = $("#clientState").val();

                    client.clientCity = $("#clientCity").val();

                    client.clientLinkedInid = $("#clientLinkedInid").val();

                    client.clientFacebookid = $("#clientFacebookid").val();

                    client.clientTwitterid = $("#clientTwitterid").val();

                    

                    //step2: deep copy client object to clients array

                    var clientObj = jQuery.extend(true, {}, client);

                    clients.push(clientObj);

                    //step3: reset client object

                    client.clientFirstName = ""; 

                    client.clientLastName = "";

                    client.clientEmail = "";

                    client.clientEmail2 = "";

                    client.clientEmail3 = "";

                    client.clientMobile = "";

                    client.clientCategory = "";

                    client.clientDesignation = "";

                    client.clientCity = "";

                    client.clientState = "";

                    client.clientCountry = "";

                    client.clientAddress = "";

                    client.clientLinkedInid = "";

                    client.clientFacebookid = "";

                    client.clientTwitterid = "";

                        

                    //step4: close modal(data-dismiss)

                    

                $('#exampleModal').modal('hide');

                resetInputField();

                // $('#clientEmail2').hide();

                // $('#clientEmail3').hide();

                // $('#add-another-email-btn').show(); 

                    //show number of contacts added

                    $('#total-clients').html("Total " + clients.length + " client are successfully added ");
                }
        }



        function resetInputField(){

            $("#clientFirstName").text("");

            $("#clientFirstName").val("");

            $("#clientFirstName").css({"border-color":"#ccc"});

            $("#clientFirstNameError").text("");





            $("#clientLastName").text("");

            $("#clientLastName").val("");

            $("#clientLastName").css({"border-color":"#ccc"});

            $("#clientLastNameError").text("");



            //first email id reset

            $("#clientEmail").text("");

            $("#clientEmail").val("");

            $("#clientEmail").css({"border-color":"#ccc"});

            $("#clientEmailError").text("");



            //second email id reset

            $("#clientEmail2").text("");

            $("#clientEmail2").val("");

            $("#clientEmail2").css({"border-color":"#ccc"});

            $("#clientEmailError").text("");



            //third email id reset

            $("#clientEmail3").text("");

            $("#clientEmail3").val("");

            $("#clientEmail3").css({"border-color":"#ccc"});

            $("#clientEmailError").text("");



            $("#clientMobile").text("");

            $("#clientMobile").val("");

            $("#clientMobile").css({"border-color":"#ccc"});

            $("#clientMobileError").text("");



            $("#clientCategory").text("");

            $("#clientCategory").val("");

            $("#clientCategory").css({"border-color":"#ccc"});

            $("#clientCategoryError").text("");



            $("#clientDesignation").text("");

            $("#clientDesignation").val("");

            $("#clientDesignation").css({"border-color":"#ccc"});

            $("#clientDesignationError").text("");

			

			

            $("#clientAddress").text("");

            $("#clientAddress").val("");

            $("#clientAddress").css({"border-color":"#ccc"});

            $("#clientAddressError").text("");

			

			 $("#clientCountry").text("");

            $("#clientCountry").val("");

            $("#clientCountry").css({"border-color":"#ccc"});

            $("#clientCountryError").text("");



          

            $("#clientState").text("");

            $("#clientState").val("");

            $("#clientState").css({"border-color":"#ccc"});

            $("#clientStateError").text("");



            $("#clientCity").text("");

            $("#clientCity").val("");

            $("#clientCity").css({"border-color":"#ccc"});

            $("#clientCityError").text("");







            $("#clientLinkedInid").text("");

            $("#clientLinkedInid").val("");

            $("#clientLinkedInid").css({"border-color":"#ccc"});

          

            

            $("#clientFacebookid").text("");

            $("#clientFacebookid").val("");

            $("#clientFacebookid").css({"border-color":"#ccc"});

           



            

            $("#clientTwitterid").text("");

            $("#clientTwitterid").val("");

            $("#clientTwitterid").css({"border-color":"#ccc"});



            addcontact();



            $('#clientEmail2').remove();

            $('#clientEmail3').remove();

            $("#clientEmailError2").text("");

            $("#clientEmailError3").text("");

            $('#add-another-email-btn').show();

           

        }



        function resetModal(){

            $("#clientFirstName").val("");

            $("#clientFirstNameError").text("");



            $("#clientLastName").val("");

            $("#clientLastNameError").text("");



            $("#clientEmail").val("");

            $("#clientEmailError").text("");



            $("#clientEmail2").val("");

            $("#clientEmailError").text("");



            $("#clientEmail3").val("");

            $("#clientEmailError").text("");



            $("#clientMobile").val("");

            $("#clientMobileError").text("");



            $("#clientCategory").val("");

            $("#clientCategoryError").text("");



            $("#clientDesignation").val("");

            $("#clientDesignationError").text("");



            $("#clientCity").val("");

            $("#clientCityError").text("");



            $("#clientState").val("");

            $("#clientStateError").text("");



            $("#clientCountry").val("");

            $("#clientCountryError").text("");



            $("#clientAddress").val("");

            $("#clientAddressError").text("");



            $("#clientLinkedInid").val("");

            $("#clientFacebookid").val("");

            $("#clientTwitterid").val("");  

            

        } 



        



        var companyNameErrorFlag = true;

        var companyWebsiteErrorFlag = true;

        var companyAddressErrorFlag = true;

        var companyPhoneErrorFlag = true;

        var companyEmailErrorFlag = true;

        var companyLinkedInErrorFlag = true;

        



        var companyNameErrorMsg= "";

        var companyWebsiteErrorMsg="";

        var companyAddressErrorMsg = "";

        var companyPhoneErrorMsg = "";

        var companyEmailErrorMsg = "";

        var companyLinkedInErrorMsg = "";

         



        function validateCompanyName()

        {

            var companyName=$("#companyName").val().trim();

            companyNameErrorFlag=false;

            companyNameErrorMsg="";

            $("#companyName").css({"border":"2px solid green"});

            if(companyName=="")

            {

                companyNameErrorFlag=true;

                $("#companyName").css({"border":"2px solid red"}) ;

                companyNameErrorMsg="Please Enter Company Name";

            }

            //console.log($("#companyNameError"));

            $("#companyNameError").text(companyNameErrorMsg);



        }



        function validateCompanyWebsite()

        {

            var companyWebsite = $("#companyWebsite").val().trim();

           websiteRegEx = /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/;

            companyWebsiteErrorFlag=false;

            companyWebsiteErrorMsg="";

            $("#companyWebsite").css({"border":"2px solid green"});

            if(companyWebsite=="")

            {

                companyWebsiteErrorFlag=true;

                $("#companyWebsite").css({"border":"2px solid red"}) ;

                companyWebsiteErrorMsg="Please Enter a Website URL";

            }

            else if(!websiteRegEx.test(companyWebsite))

           {

                $("#companyWebsite").css({"border":"2px solid red"}) ;

                companyWebsiteErrorMsg="Invalid website format";

                

           }

            //console.log($("#companyNameError"));

            $("#companyWebsiteError").text(companyWebsiteErrorMsg);



        }



        function validateCompanyAddress()

        {

            var companyAddress = $("#companyAddress").val().trim();

            companyAddressErrorFlag=false;

            companyAddressErrorMsg="";

            $("#companyAddress").css({"border":"2px solid green"});

            if(companyAddress=="")

            {

                companyAddressErrorFlag=true;

                $("#companyAddress").css({"border":"2px solid red"}) ;

                companyAddressErrorMsg="Please Enter Company Address";

            }

            //console.log($("#companyNameError"));

            $("#companyAddressError").text(companyAddressErrorMsg);

        }

        

        function validateCompanyPhone()

        {

            var companyPhone = $("#companyPhone").val().trim();

            companyPhoneErrorFlag=false;

            companyPhoneErrorMsg="";

            $("#companyPhone").css({"border":"2px solid green"});

            if(companyPhone==""||companyPhone.length<10||companyPhone.length>10||isNaN(companyPhone))

            {

                companyPhoneErrorFlag=true;

                $("#companyPhone").css({"border":"2px solid red"}) ;

                companyPhoneErrorMsg="Please Enter Company Phone";

            }

            //console.log($("#companyNameError"));

            $("#companyPhoneError").text(companyPhoneErrorMsg);

        }



        function validateCompanyEmail()

        {

            var companyEmail = $("#companyEmail").val();

            EmailRegEx= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

            companyEmailErrorFlag=false;

            companyEmailErrorMsg="";

            $("#companyEmail").css({"border":"2px solid green"});

            if(companyEmail=="")

            {

                companyEmailErrorFlag=true;

                $("#companyEmail").css({"border":"2px solid red"}) ;

                companyEmailErrorMsg="Please Enter Your Email-Id";

            }

            else if(!EmailRegEx.test(companyEmail))

           {

                $("#companyEmail").css({"border":"2px solid red"}) ;

                companyEmailErrorMsg="Invalid Email format";

                

           }

                $("#companyEmailError").text(companyEmailErrorMsg);



        }

      /*  function validateCompanyEmail()

        {

            var companyEmail = $("#companyEmail").val().trim();

            companyEmailErrorFlag=false;

            companyEmailErrorMsg="";

            $("#companyEmail").css({"border":"2px solid green"});

            if(companyEmail=="")

            {

                companyEmailErrorFlag=true;

                $("#companyEmail").css({"border":"2px solid red"}) ;

                companyEmailErrorMsg="Please Enter Company Email-Id";

            }

            //console.log($("#companyNameError"));

            $("#companyEmailError").text(companyEmailErrorMsg);

        }*/





        function validateCompanyLinkedIn()

        {

            var companyLinkedIn = $("#companyLinkedIn").val().trim();

            companyLinkedInErrorFlag=false;

            companyLinkedInErrorMsg="";

            $("#companyLinkedIn").css({"border":"2px solid green"});

            if(companyLinkedIn=="")

            {

                companyLinkedInErrorFlag=true;

                $("#companyLinkedIn").css({"border":"2px solid red"}) ;

                companyLinkedInErrorMsg="Please Enter Your linked in ID";

            }

            //console.log($("#companyNameError"));

            $("#companyLinkedInError").text(companyLinkedInErrorMsg);

        }





//this below function is used for the reset for add contact in company Client list 



        function addContactFormReset() {

            addContactFormResetErrFlags();

            addContactFormResetErrMsgs();

            addContactFormResetErrOnForm();

            $("#server-message").text("");

        }

        

        function addContactFormResetErrFlags() {

            clientFirstNameErrorFlag = true;

            clientLastNameErrorFlag = true;

            clientEmailErrorFlag = true;

            clientMobileErrorFlag = true;

            clientCategoryErrorFlag = true;

            clientDesignationErrorFlag = true;

            clientCityErrorFlag = true;

            clientStateErrorFlag = true;

            clientCountryErrorFlag  = true;

            clientAddressErrorFlag = true;

            clientLinkedInErrorFlag = true;

            clientFacebookIdErrorFlag = true;

            clientTwitterIdErrorFlag = true;

        }

        

        function addContactFormResetErrMsgs() {

            clientFirstNameErrorMsg = "";

            clientLastNameErrorMsg = "";

            clientEmailErrorMsg = "";

            clientMobileErrorMsg = "";

            clientCategoryErrorMsg = "";

            clientDesignationErrorMsg = "";

            clientCityErrorMsg = "";

            clientStateErrorMsg = "";

            clientCountryErrorMsg = "";

            clientAddressErrorMsg = "";

            clientLinkedInErrorMsg = "";

            clientFacebookIdErrorMsg = "";

            clientTwitterIdErrorMsg = "";

        }

        

        function addContactFormResetErrOnForm() {

            $("#clientFirstName").text("");

            $("#clientFirstName").val("");

            $("#clientFirstName").css({"border-color":"#ccc"});



            $("#clientLastName").text("");

            $("#clientLastName").val("");

            $("#clientLastName").css({"border-color":"#ccc"});

        

            $("#clientEmail").text("");

            $("#clientEmail").val("");

            $("#clientEmail").css({"border-color":"#ccc"});

 

            $("#clientMobile").text("");

            $("#clientMobile").val("");

            $("#clientMobile").css({"border-color":"#ccc"});



            $("#clientCategory").text("");

            $("#clientCategory").val("");

            $("#clientCategory").css({"border-color":"#ccc"});



            $("#clientDesignation").text("");

            $("#clientDesignation").val("");

            $("#clientDesignation").css({"border-color":"#ccc"});



            $("#clientCity").text("");

            $("#clientCity").val("");

            $("#clientCity").css({"border-color":"#ccc"});



            $("#clientState").text("");

            $("#clientState").val("");

            $("#clientState").css({"border-color":"#ccc"});



            $("#clientCountry").text("");

            $("#clientCountry").val("");

            $("#clientCountry").css({"border-color":"#ccc"});



            $("#clientAddress").text("");

            $("#clientAddress").val("");

            $("#clientAddress").css({"border-color":"#ccc"});



            $("#clientLinkedInid").text("");

            $("#clientLinkedInid").val("");

            $("#clientLinkedInid").css({"border-color":"#ccc"});



            

            $("#clientFacebookid").text("");

            $("#clientFacebookid").val("");

            $("#clientFacebookid").css({"border-color":"#ccc"});



            

            $("#clientTwitterid").text("");

            $("#clientTwitterid").val("");

            $("#clientTwitterid").css({"border-color":"#ccc"});



        }



      

       

        



        