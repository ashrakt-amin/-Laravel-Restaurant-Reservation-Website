<?php
namespace App\Enums ;

enum TableStatus : string
{
    case Pending ="Pending";
    case Available ="Available" ;
    case Unavailable ="Unavailable" ;

}
