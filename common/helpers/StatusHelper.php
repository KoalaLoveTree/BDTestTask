<?php
/**
 * Created by PhpStorm.
 * User: bigdrop
 * Date: 4/4/18
 * Time: 4:30 PM
 */

namespace common\helpers;

class StatusHelper
{

    public static function getServiceStatusString(int $code):string
    {
        switch ($code){
            case 0:
                return 'Ban';
                break;
            case 5:
                return 'Moderated';
                break;
            case 10:
                return 'Approved';
                break;
        }
        return $code;
    }



}