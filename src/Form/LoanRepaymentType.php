<?php

namespace App\Form;

use App\Entity\LoanRepayment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoanRepaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount')
            ->add('status')
            ->add('payForRepaymentDate')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('loan')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LoanRepayment::class,
        ]);
    }
}
