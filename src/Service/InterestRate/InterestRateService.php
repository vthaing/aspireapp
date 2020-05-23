<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/23/2020
 * Time: 1:35 PM
 */

namespace App\Service\InterestRate;


use App\Entity\Loan;

class InterestRateService
{
    public function calculateInterestRate(Loan $loan) : float
    {
        return ($loan->getLoanAmount() * ($loan->getLoanTerm() * $loan->getInterestRate()))/100;
    }

    public function calculaetTotalLoanRepayment(Loan $loan) : float
    {
        $interestRate = $this->calculateInterestRate($loan);
        return $interestRate + $loan->getLoanAmount();
    }
}