<?php

define('DEV_MODE', true);
define('LIVE_SITE', true); // http://erabiler.cloud2business.dk/
// define('LIVE_SITE', false); // http://167.71.33.87/

if (LIVE_SITE) {

    // Det Digitale Bilhus
    define("S1_BIRTHDAY_TEMPLATE_ID", 454);
    define("S1_ANNIVERSARY_TEMPLATE_ID", 462);
    // Bil og Co
    define("RC_BIRTHDAY_TEMPLATE_ID", 455);
    define("RC_ANNIVERSARY_TEMPLATE_ID", 468);
    // SDK Biler
    define("QY_BIRTHDAY_TEMPLATE_ID", 456);
    define("QY_ANNIVERSARY_TEMPLATE_ID", 469);
    // MFA Biler
    define("PY_BIRTHDAY_TEMPLATE_ID", 457);
    define("PY_ANNIVERSARY_TEMPLATE_ID", 463);
    // STS Biler
    define("MH_BIRTHDAY_TEMPLATE_ID", 458);
    define("MH_ANNIVERSARY_TEMPLATE_ID", 464);
    // ERA Biler
    define("LB_BIRTHDAY_TEMPLATE_ID", 459);
    define("LB_ANNIVERSARY_TEMPLATE_ID", 465);
    // Autohallen
    define("KU_BIRTHDAY_TEMPLATE_ID", 460);
    define("KU_ANNIVERSARY_TEMPLATE_ID", 466);
    // NHE Biler
    define("JF_BIRTHDAY_TEMPLATE_ID", 461);
    define("JF_ANNIVERSARY_TEMPLATE_ID", 467);

    //Socnet Rights
    define("S1_RIGHTS","DR414");
    define("RC_RIGHTS","DR54");
    define("QY_RIGHTS","DR52");
    define("PY_RIGHTS","DR53");
    define("MH_RIGHTS","DR50");
    define("LB_RIGHTS","DR51");
    define("KU_RIGHTS","DR56");
    define("JF_RIGHTS","DR55");


} else {

    // Det Digitale Bilhus
    define("S1_BIRTHDAY_TEMPLATE_ID", 455);
    define("S1_ANNIVERSARY_TEMPLATE_ID", 454);
    // Bil og Co
    define("RC_BIRTHDAY_TEMPLATE_ID", 463);
    define("RC_ANNIVERSARY_TEMPLATE_ID", 456);
    // SDK Biler
    define("QY_BIRTHDAY_TEMPLATE_ID", 464);
    define("QY_ANNIVERSARY_TEMPLATE_ID", 457);
    // MFA Biler
    define("PY_BIRTHDAY_TEMPLATE_ID", 465);
    define("PY_ANNIVERSARY_TEMPLATE_ID", 458);
    // STS Biler
    define("MH_BIRTHDAY_TEMPLATE_ID", 466);
    define("MH_ANNIVERSARY_TEMPLATE_ID", 459);
    // ERA Biler
    define("LB_BIRTHDAY_TEMPLATE_ID", 467);
    define("LB_ANNIVERSARY_TEMPLATE_ID", 460);
    // Autohallen
    define("KU_BIRTHDAY_TEMPLATE_ID", 468);
    define("KU_ANNIVERSARY_TEMPLATE_ID", 461);
    // NHE Biler
    define("JF_BIRTHDAY_TEMPLATE_ID", 469);
    define("JF_ANNIVERSARY_TEMPLATE_ID", 462);

    //Socnet Rights
    define("S1_RIGHTS","DR414");
    define("RC_RIGHTS","DR54");
    define("QY_RIGHTS","DR52");
    define("PY_RIGHTS","DR53");
    define("MH_RIGHTS","DR50");
    define("LB_RIGHTS","DR51");
    define("KU_RIGHTS","DR56");
    define("JF_RIGHTS","DR55");

}
