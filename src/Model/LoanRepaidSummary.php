<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/23/2020
 * Time: 9:13 PM
 */

namespace App\Model;


class LoanRepaidSummary
{
    /**
     * @var float
     */
    private $loanAmount;

    /**
     * @var int
     */
    private $loanTerm;
    /**
     * @var float
     */
    private $interestRate;
    /**
     * @var float
     */
    private $totalLoanRepayments;
    /**
     * @var float
     */
    private $totalInterestPaid;
    /**
     * @var float
     */
    private $paidSucces;

    /**
     * @return float
     */
    public function getLoanAmount(): float
    {
        return $this->loanAmount;
    }

    /**
     * @param float $loanAmount
     */
    public function setLoanAmount(float $loanAmount): void
    {
        $this->loanAmount = $loanAmount;
    }

    /**
     * @return float
     */
    public function getInterestRate(): float
    {
        return $this->interestRate;
    }

    /**
     * @param float $interestRate
     */
    public function setInterestRate(float $interestRate): void
    {
        $this->interestRate = $interestRate;
    }

    /**
     * @return float
     */
    public function getTotalLoanRepayments(): float
    {
        return $this->totalLoanRepayments;
    }

    /**
     * @param float $totalLoanRepayments
     */
    public function setTotalLoanRepayments(float $totalLoanRepayments): void
    {
        $this->totalLoanRepayments = $totalLoanRepayments;
    }

    /**
     * @return float
     */
    public function getTotalInterestPaid(): float
    {
        return $this->totalInterestPaid;
    }

    /**
     * @param float $totalInterestPaid
     */
    public function setTotalInterestPaid(float $totalInterestPaid): void
    {
        $this->totalInterestPaid = $totalInterestPaid;
    }

    /**
     * @return float
     */
    public function getPaidSucces(): float
    {
        return $this->paidSucces;
    }

    /**
     * @param float $paidSucces
     */
    public function setPaidSucces(float $paidSucces): void
    {
        $this->paidSucces = $paidSucces;
    }

    /**
     * @return int
     */
    public function getLoanTerm(): int
    {
        return $this->loanTerm;
    }

    /**
     * @param int $loanTerm
     */
    public function setLoanTerm(int $loanTerm): void
    {
        $this->loanTerm = $loanTerm;
    }





}