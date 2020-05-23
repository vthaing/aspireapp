<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/23/2020
 * Time: 10:49 AM
 */

namespace App\Service\RepaymentAmountCalculator;


use App\Entity\Loan;

class RepaymentAmountCalculator
{
    /**
     * @param Loan $loan
     * @return float
     */
    public function calculate(Loan $loan)
    {
        //@TODO: add business here
        return 100.1;
    }
}