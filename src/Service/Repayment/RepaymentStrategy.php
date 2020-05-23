<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/23/2020
 * Time: 12:54 PM
 */

namespace App\Service\Repayment;


use App\Entity\Loan;
use App\Model\LoanRepaidSummary;
use App\Service\InterestRate\InterestRateService;

abstract class RepaymentStrategy
{

    /**
     * @var InterestRateService
     */
    protected $interestRateService;

    public function __construct(InterestRateService $interestRateService)
    {
        $this->interestRateService = $interestRateService;
    }

    /**
     * @param Loan $loan
     *
     * @return float
     */
    public abstract function calculateAmount(Loan $loan) : float;

    /**
     * @param Loan $loan
     *
     * @return \DateTime
     */
    public abstract function getNextRepaymentDate(Loan $loan) :\DateTime;



    public function getPaidSuccess(Loan $loan) : float
    {
        $result = 0;

        foreach ($loan->getLoanRepayments() as $repayment) {
            if ($repayment->isSuccess()) {
                $result += $repayment->getAmount();
            }
        }

        return $result;
    }


    /**
     * @param Loan $loan
     * @return LoanRepaidSummary
     */
    public function getLoanRepaidSummary(Loan $loan): LoanRepaidSummary
    {
        $summary = new LoanRepaidSummary();
        $summary->setInterestRate($loan->getInterestRate());
        $summary->setLoanAmount($loan->getLoanAmount());
        $summary->setLoanTerm($loan->getLoanTerm());
        $summary->setTotalInterestPaid($this->interestRateService->calculateInterestRate($loan));
        $summary->setPaidSucces($this->getPaidSuccess($loan));
        $summary->setTotalLoanRepayments($this->interestRateService->calculaetTotalLoanRepayment($loan));

        return $summary;
    }
}