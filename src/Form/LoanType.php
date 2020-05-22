<?php

namespace App\Form;

use App\Entity\Loan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class LoanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('birthDate')
            ->add('phone')
            ->add('email')
            ->add('address')
            ->add('city')
            ->add('province')
            ->add('monthlyNetIncome', NumberType::class, ['label' => 'Monthly Net Income (USD)'])
            ->add('loanAmount', NumberType::class, ['label' => 'Loan Amount (USD)'])
            ->add('loanTerm', NumberType::class, ['label' => 'Loan Term (months)'])

        ;
        if ($options['show_status_field']) {
            $builder->add('status', ChoiceType::class, ['choices' => Loan::getStatuses()]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Loan::class,
            'show_status_field' => false
        ]);
    }
}
