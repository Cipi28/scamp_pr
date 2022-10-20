<?php

namespace App\Form;

use App\Entity\Booking;
use Doctrine\DBAL\Types\TextType;
use Doctrine\DBAL\Types\TimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use \Symfony\Component\Form\Extension\Core\Type\DateTimeType;




class BookingForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startTime', DateTimeType::class,['years' =>range('2022', '2050')] )
            ->add('duration', \Symfony\Component\Form\Extension\Core\Type\DateIntervalType::class, [
                'with_years'  => false,
                'with_months' => false,
                'with_days'   => false,
                'with_hours'  => true,
                'with_minutes'  => true,

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}