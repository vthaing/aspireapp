<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/23/2020
 * Time: 12:57 PM
 */

namespace App\Service\Repayment;


use App\Entity\Loan;

class WeeklyRepayment extends RepaymentStrategy
{

    public function countNumberOfWeeks(Loan $loan) : int
    {
        $endDate = $this->getEndDate($loan);
        $startDate = $loan->getFirstRepaymentDate();
        $datesDiff = $startDate->diff($endDate)->days;

        $floor = floor($datesDiff/7);
        $mod =$datesDiff % 7;

        if ($mod) {
            return $floor + 1;
        }

        //Always diference 0
        if (!$floor) {
            $floor = 1;
        }

        return $floor;
    }

    /**
     * Get end of loan
     *
     * @param Loan $loan
     * @return \DateTime
     */
    public function getEndDate(Loan $loan) : \DateTime
    {
        $result = clone $loan->getFirstRepaymentDate();
        return $result->modify("+ {$loan->getLoanTerm()} months");
    }

    /**
     * Calculate amount for current week
     *
     * @param Loan $loan
     * @return float
     */
    public function calculateAmount(Loan $loan): float
    {
        $totalLoanRepayments = $this->interestRateService->calculaetTotalLoanRepayment($loan);
        $totalWeeks = $this->countNumberOfWeeks($loan);

        return $totalLoanRepayments/$totalWeeks;
    }

    /**
     * Get next repayment date
     *
     * @param Loan $loan
     * @return \DateTime
     */
    public function getNextRepaymentDate(Loan $loan): \DateTime
    {
        $currentRepaymentDate = clone $loan->getNextRepaymentDate();
        return $currentRepaymentDate->modify("+7 days");
    }




}