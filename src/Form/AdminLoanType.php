<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/23/2020
 * Time: 8:08 AM
 */

namespace App\Form;


use App\Entity\Loan;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class AdminLoanType extends LoanType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('nextRepaymentDate');
        $builder->add('status', ChoiceType::class, ['choices' => Loan::getStatuses()]);
    }

}