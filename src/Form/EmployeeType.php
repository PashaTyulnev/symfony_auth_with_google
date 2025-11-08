<?php

namespace App\Form;

use App\Entity\Employee;
use App\Entity\Department;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Vorname',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Alexander',
                    'class' => 'w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-slate-500/50 dark:focus:ring-slate-400/50'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nachname',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Schmidt',
                    'class' => 'w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-slate-500/50 dark:focus:ring-slate-400/50'
                ]
            ])
            ->add('birthDate', DateType::class, [
                'label' => 'Geburtsdatum',
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'class' => 'w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-slate-500/50 dark:focus:ring-slate-400/50'
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'Telefon',
                'required' => true,
                'attr' => [
                    'placeholder' => '017685412456',
                    'class' => 'w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-slate-500/50 dark:focus:ring-slate-400/50'
                ]
            ])
            ->add('number', TextType::class, [
                'label' => 'Personalnummer',
                'required' => true,
                'attr' => [
                    'placeholder' => '123456',
                    'class' => 'w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-slate-500/50 dark:focus:ring-slate-400/50'
                ]
            ])
            ->add('department', EntityType::class, [
                'class' => Department::class,
                'choice_label' => 'title',
                'choice_value' => 'shortTitle',
                'label' => 'Abteilung',
                'required' => true,
                'placeholder' => 'Bitte wählen...',
                'query_builder' => function ($er) {
                    return $er->createQueryBuilder('d')
                        ->orderBy('d.position', 'ASC');
                },
                'attr' => [
                    'class' => 'w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-slate-500/50 dark:focus:ring-slate-400/50'
                ]
            ])
            ->add('username', TextType::class, [
                'label' => 'Benutzername',
                'mapped' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'aschmidt',
                    'class' => 'w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-slate-500/50 dark:focus:ring-slate-400/50'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-Mail',
                'mapped' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'max@gmail.com',
                    'class' => 'w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-slate-500/50 dark:focus:ring-slate-400/50'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}

