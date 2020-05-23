<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/23/2020
 * Time: 8:36 AM
 */

namespace App\Factory;


use App\Entity\Loan;
use App\Service\Repayment\RepaymentService;
use Symfony\Component\Security\Core\Security;

class LoanFactory
{
    /**
     * @var Security
     */
    private $security;
    /**
     * @var RepaymentService
     */
    private $repaymentService;

    public function __construct(Security $security, RepaymentService $repaymentService)
    {
        $this->security = $security;
        $this->repaymentService = $repaymentService;
    }

    /**
     * Create default loan
     *
     * @return Loan
     */
    public function createDefaultLoan()
    {
        $loan = new Loan();
        $loan->setUser($this->security->getUser());
        $loan->setStatus(Loan::LOAN_STATUS_NEW);
        $loan->setRepaymentFrequency(Loan::REPAYMENT_WEEKLY);

        return $loan;
    }

    /**
     * Handle business when a loan is approved
     *
     * @param Loan $loan
     */
    public function handleApproveLoan(Loan $loan)
    {
        //Do nothing when application is not approved
        if (!$loan->isApproved()) {
            return;
        }

        //Assign firstRepaymentDate for nextRepaymentDate
        if (!$loan->getNextRepaymentDate()) {
            $loan->setNextRepaymentDate($loan->getFirstRepaymentDate());
            return;
        }
    }


    /**
     * Change next payment date
     *
     * @param Loan $loan
     *
     * @return Loan
     */
    public function changeNextRepaymentDate(Loan $loan)
    {
        $nextRepaymentDate = $this->repaymentService->getNextRepaymentDate($loan);
        $loan->setNextRepaymentDate($nextRepaymentDate);

        return $loan;
    }
}