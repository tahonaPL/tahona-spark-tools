<?php
/**
 * Created by PhpStorm.
 * User: primosz67
 * Date: 23.07.16
 * Time: 12:08
 */

namespace spark\tools\mail;


use spark\utils\ValidatorUtils;

class MailUtils {

    public static function isToValid($to) {
        if (false === is_array($to)) {
            return ValidatorUtils::isMailValid($to);
        }

        if (is_array($to)) {
            foreach ($to as $mail => $name) {
                if (false === ValidatorUtils::isMailValid($mail)) {
                    return false;
                }
            }

            return true;
        } else {
            return false;
        }
    }
}