<?php
namespace App\Enums;

abstract class OrderStatusEnum
{
    const PENDING = 0;
    const COMPLETED = 1;

    const QUOTEACCEPTED = 1;
    const QUOTEREJECTED = 2;
    const QUOTEPENDING = 0;

}
?>