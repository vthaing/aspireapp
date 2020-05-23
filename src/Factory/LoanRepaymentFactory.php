<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/23/2020
 * Time: 10:22 AM
 */

namespace App\Factory;


use App\Entity\Loan;
use App\Entity\LoanRepayment;
use App\Service\RepaymentAmountCalculator\RepaymentAmountCalculator;


class LoanRepaymentFactory
{
    /**
     * @var RepaymentAmountCalculator
     */
    private $repaymentAmountCalculator;


    public function __construct(RepaymentAmountCalculator $repaymentAmountCalculator)
    {
        $this->repaymentAmountCalculator = $repaymentAmountCalculator;
    }

    /**
     * @param Loan $loan
     * @return LoanRepayment
     */
    public function createFromLoan(Loan $loan)
    {
        $repayment = new LoanRepayment();
        $repayment->setLoan($loan);
        $repayment->setUser($loan->getUser());
        $repayment->setStatus(LoanRepayment::STATUS_NEW);
        $repayment->setPayForRepaymentDate($loan->getNextRepaymentDate());

        $amount = $this->repaymentAmountCalculator->calculate($loan);
        $repayment->setAmount($amount);


        return $repayment;
    }

}