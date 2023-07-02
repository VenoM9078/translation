<?php
namespace App\Enums;

abstract class LogActionsEnum
{
    const NEWORDER = "Created Order";

    const ISADMIN = 1;
    const NOTADMIN = 0;
    const ASSIGNEDTRANSLATOR = "Assigned Translator";
    const ASSIGNEDINTERPRETER = "Assigned Interpreter";
    const ASSIGNEDPROOFREADER = "Assigned Proof Reader";
    const SENTQUOTE = "Sent Quote";

    const INVOICESENT = "Sent Invoice";
    const INVOICESENTNUMBER = 1;
    const ACCEPTTRANSLATION = "Accepted Translation Request";
    const ACCEPTINTERPRETATION = "Accepted Interpretation Request";
    const DECLINEINTERPRETATION = "Declined Interpretation Request";
    const ACCEPTINTERPRETATIONNUMBER = 1;
    const DECLINEINTERPRETATIONNUMBER = 2;
    const DECLINETRANSLATION = "Declined Translation Request";
    const UPLOADTRANSLATION = "Uploaded Translated Document";
    const UPLOADPROOFREAD = "Uploaded Proof Read Document";
    const ACCEPTPROOFREAD = "Accepted Proof Read Request";
    const DECLINEPROOFREAD = "Declined Proof Read Request";

    const QUOTEREQUESTED = "Requested for Quote";
    const ORDERCOMPLETED = "Completed Order";
    const PAYMENTCOMPLETED = "Completed Payment";
    const
        LATEPAYMENTCOMPLETED = "Completed Late Payment";
    const WILLPAYLATE = "Will Pay Later";

    const CANCELLEDINTERPRETATION = "Cancelled Interpretation";
    const CANCELLEDORDER = "Cancelled Order";
    const PAYMENTCOMPLETEDNUMBER = 1;
    const LATEPAYMENTCOMPLETEDNUMBER = 2;
    const QUOTESENT = "Sent Quote";
    const WILLPAYLATENUMBER = 3;

    const PAYMENTINCOMPLETEDNUMBER = 0;
    const ACCEPTEDNUMBER = 1;
    const DECLINENUMBER = 2;
    const QUOTEAPPROVED = "Approved Quote";
    const QUOTEDISAPPROVED = "Disapproved Quote";

    const CREATEDINTERPRETATION = "Created Interpretation";
    const COMPLETEDINTERPRETATION = "Completed Interpretation";
    const COMPLETEDINTERPRETATIONNUMBER = 1;
    const PAIDINTERPRETATION = 1;
    const LATEPAIDINTERPRETATION = 2;
    const INCOMPLETEINTERPRETATION = 0;

    const ISINTERPRETATION = 1;
    const ZEROTRANSLATIONSTATUS = 0;
}
?>