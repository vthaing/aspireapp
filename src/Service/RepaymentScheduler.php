<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/23/2020
 * Time: 10:52 AM
 */

namespace App\Service;


class RepaymentScheduler
{
    /**
     * @param $loan
     *
     * @return \DateTime
     */
    public function getNextRepaymentDate($loan)
    {
        return new \DateTime();
    }
}