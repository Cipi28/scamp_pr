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
            ->add('startTime', DateTimeType::class)
            ->add('duration', \Symfony\Component\Form\Extension\Core\Type\DateIntervalType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}