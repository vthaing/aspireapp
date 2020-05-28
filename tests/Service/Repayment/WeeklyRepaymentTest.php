<?php

namespace App\Tests\Service\Repayment;

use App\Entity\Loan;
use App\Service\InterestRate\InterestRateService;
use App\Service\Repayment\WeeklyRepayment;
use DateTime;
use PHPUnit\Framework\TestCase;

class WeeklyRepaymentTest extends TestCase
{
    /**
     * @dataProvider loans
     */
    public function testGetEndDate(Loan $loan, $date)
    {
        $service = new WeeklyRepayment(new InterestRateService);
        $this->assertEquals($service->getEndDate($loan), new DateTime($date));
    }

    public function loans()
    {
        $loan1 = new Loan;
        $loan1->setLoanTerm(1);
        $loan1->setFirstRepaymentDate(new DateTime('2020-06-15'));

        $loan2 = new Loan;
        $loan2->setLoanTerm(1);
        $loan2->setFirstRepaymentDate(new DateTime('2020-08-31'));

        return [
            // judging by the code, this should be passing:
            [$loan1, '2020-07-15'],
            [$loan2, '2020-09-30'],

            // judging by the name WeeklyRepayment, probably this should be the implementation:
//            [$loan1, '2020-06-22'],
//            [$loan2, '2020-09-07'],
        ];
    }
}
