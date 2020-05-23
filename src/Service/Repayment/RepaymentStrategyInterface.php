<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/23/2020
 * Time: 12:54 PM
 */

namespace App\Service\Repayment;


use App\Entity\Loan;

interface RepaymentStrategyInterface
{
    /**
     * @param Loan $loan
     *
     * @return float
     */
    public function calculateAmount(Loan $loan) : float;

    /**
     * @param Loan $loan
     *
     * @return \DateTime
     */
    public function getNextRepaymentDate(Loan $loan) :\DateTime;
}