<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/23/2020
 * Time: 12:46 PM
 */

namespace App\Service\Repayment;


use App\Entity\Loan;
use App\Model\LoanRepaidSummary;

class RepaymentService
{
    private $repaymentStrategies = [];

    public function __construct($repaymentStrategies)
    {
        $this->repaymentStrategies = $repaymentStrategies;
    }

    protected function getStrategy(Loan $loan) : RepaymentStrategy
    {
        foreach ($this->repaymentStrategies as $frequencyId => $strategy) {
            if ($frequencyId === $loan->getRepaymentFrequency()) {
                return $strategy;
            }
        }

        throw new \InvalidArgumentException("System does not support for repayment frequency id {$loan->getRepaymentFrequency()}");
    }

    /**
     * @param Loan $loan
     *
     * @return float
     */
    public function calculateAmount(Loan $loan)
    {
        $repaymentStrategy = $this->getStrategy($loan);
        return $repaymentStrategy->calculateAmount($loan);
    }

    /**
     * @param Loan $loan
     * @return \DateTime
     */
    public function getNextRepaymentDate(Loan $loan)
    {
        $repaymentStrategy = $this->getStrategy($loan);
        return $repaymentStrategy->getNextRepaymentDate($loan);
    }

    public function getPaidSuccess(Loan $loan) : float
    {
        $repaymentStrategy = $this->getStrategy($loan);
        return $repaymentStrategy->getPaidSuccess($loan);
    }

    /**
     * @param Loan $loan
     * @return LoanRepaidSummary
     */
    public function getLoanRepaidSummary(Loan $loan): LoanRepaidSummary
    {
        $repaymentStrategy = $this->getStrategy($loan);
        return $repaymentStrategy->getLoanRepaidSummary($loan);
    }
}