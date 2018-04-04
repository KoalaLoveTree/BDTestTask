<?php
/**
 * Created by PhpStorm.
 * User: bigdrop
 * Date: 4/4/18
 * Time: 4:33 PM
 */

namespace common\interfaces;

interface StatusInterface
{
    const STATUS_DELETED = 0;
    const STATUS_MODERATION = 5;
    const STATUS_APPROVE = 10;
}