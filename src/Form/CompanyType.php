<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('company', TextType::class, [
                'label' => 'Firmenname',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Musterfirma GmbH',
                    'class' => 'w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-slate-500/50 dark:focus:ring-slate-400/50'
                ]
            ])
            ->add('number', TextType::class, [
                'label' => 'Nummer',
                'required' => true,
                'attr' => [
                    'placeholder' => 'CD43/53',
                    'class' => 'w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-slate-500/50 dark:focus:ring-slate-400/50'
                ]
            ])
            ->add('logoLink', TextType::class, [
                'label' => 'Logo URL',
                'required' => false,
                'attr' => [
                    'placeholder' => 'https://example.com/logo.png',
                    'class' => 'w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-slate-500/50 dark:focus:ring-slate-400/50'
                ]
            ])
            ->add('address', AddressType::class, [
                'label' => false,
                'required' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}

