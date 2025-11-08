<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('street', TextType::class, [
                'label' => 'Straße',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Musterstraße 123',
                    'class' => 'w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-slate-500/50 dark:focus:ring-slate-400/50'
                ]
            ])
            ->add('zip', TextType::class, [
                'label' => 'PLZ',
                'required' => true,
                'attr' => [
                    'placeholder' => '01234',
                    'class' => 'w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-slate-500/50 dark:focus:ring-slate-400/50'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Stadt',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Dresden',
                    'class' => 'w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-slate-500/50 dark:focus:ring-slate-400/50'
                ]
            ])
            ->add('country', TextType::class, [
                'label' => 'Land',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Deutschland',
                    'class' => 'w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-slate-500/50 dark:focus:ring-slate-400/50'
                ],
                'data' => 'Deutschland'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}

