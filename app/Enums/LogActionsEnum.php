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

    const INVOICESENT  = "Sent Invoice";
    const ACCEPTTRANSLATION = "Accepted Translation Request";
    const DECLINETRANSLATION = "Declined Translation Request";
    const UPLOADTRANSLATION = "Uploaded Translated Document";
}
?>