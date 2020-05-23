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
use App\Service\Repayment\RepaymentService;


class LoanRepaymentFactory
{
    /**
     * @var RepaymentService
     */
    private $repaymentService;


    public function __construct(RepaymentService $repaymentService)
    {
        $this->repaymentService = $repaymentService;
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

        $amount = $this->repaymentService->calculateAmount($loan);
        $repayment->setAmount($amount);


        return $repayment;
    }

}