<?php
/**
 * Constants
 */
define("BASEURL", "http://". $_SERVER['SERVER_NAME'] ."/". explode("/", $_SERVER['PHP_SELF'])[1] ."/");
define("DEFAULT_PASSWORD", "sales1234");
define("BDM_LIST_LIMIT", 4);
define("BDE_LIST_LIMIT", 4);
define("COMPANY_LIST_LIMIT", 4);
define("CONTACT_LIST_LIMIT", 4);
define("ERR_BLANK", "One Or More Fields Are Blank!");
define("ERR_WHITESPACE", "Whitespaces Are Not Allowed!");
define("ERR_CONTACT_EXISTS", "Contact With This Email ID Is Already Uploaded");
define("ERR_COMPANY_EXISTS", "Company With This Website Address Is Already Uploaded");
?>