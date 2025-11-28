<?php

namespace App\Enum;

enum UserRoles: string
{
    //
    case SUPER_ADMIN = "super_admin";
    case BRANCH_SUPERVISOR = "branch_supervisor";
    case KITCHEN = "kitchen";
    case CASHIER = "cashier";
    case WAITER = "waiter";
}
