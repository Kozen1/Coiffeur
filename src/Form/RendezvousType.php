<?php

namespace App\Form;

use App\Entity\Rendezvous;
use App\Entity\Prestations;
use App\Form\RendezvousType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Time;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class RendezvousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $userId = $options['user'];
        $builder->add('user', HiddenType::class);
        $builder->add('date', DateType::class, [
            'widget' => 'single_text',
            'constraints' => [
                new GreaterThanOrEqual([
                    'value' => 'today',
                    'message' => 'La date doit être supérieure ou égale à la date actuelle',
                ]),
                new Callback([$this, 'validateNotMondayOrSunday']),
            ],
        ]);

        $builder->add('time', TimeType::class, [
            'widget' => 'choice',
            'minutes' => [0, 15, 30, 45],
            'constraints' => [
                new Callback([$this, 'validateOpeningHours']),
            ],
        ]);

        $builder->add('prestations', EntityType::class, [
            'class' => Prestations::class,
            'choice_label' => function (Prestations $prestations) {
                return $prestations->getNom() . ' - ' . $prestations->getTarif() . '€';
            },
        ])
            ->add('employe');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rendezvous::class,
            'user' => '',
        ]);
    }

    public function validateNotMondayOrSunday($date, ExecutionContextInterface $context)
    {
        $dayOfWeek = $date->format('N'); // N retourne 1 pour lundi, 2 pour mardi, etc.
        if ($dayOfWeek == 1) {
            $context->buildViolation('Il n\'y a pas de rendez-vous le lundi.')
                ->addViolation();
        } elseif ($dayOfWeek == 7) {
            $context->buildViolation('Il n\'y a pas de rendez-vous le dimanche.')
                ->addViolation();
        }
    }

    public function validateOpeningHours($value, ExecutionContextInterface $context)
    {
        $date = $context->getRoot()->get('date')->getData();
        $time = $value->format('H:i');
        $dayOfWeek = $date->format('w'); // w: numéro de jour de la semaine de 0 (dimanche) à 6 (samedi)

        if (
            $dayOfWeek == 2 && (
                ($time >= '00:00' && $time < '09:00') ||
                ($time >= '12:00' && $time < '13:30') ||
                ($time >= '19:30' && $time <= '23:59')
            )
        ) {
            $context->buildViolation('Les rendez-vous le mardi sont disponibles de 9h à 12h et de 13h30 à 19h30.')
                ->addViolation();
        } elseif (
            $dayOfWeek == 3 && (
                ($time >= '00:00' && $time < '09:00') ||
                ($time >= '12:30' && $time < '13:30') ||
                ($time >= '19:30' && $time <= '23:59')
            ) 
        ) {
            $context->buildViolation('Les rendez-vous le mercredi sont disponibles de 9h à 12h30 et de 13h30 à 19h30.')
                ->addViolation();
        } elseif (
            $dayOfWeek == 4 && (
                ($time >= '00:00' && $time < '09:00') ||
                ($time >= '12:00' && $time < '14:00') ||
                ($time >= '18:30' && $time <= '23:59')
            ) 
        ) {
            $context->buildViolation('Les rendez-vous le jeudi sont disponibles de 9h à 12h et de 14h à 18h30.')
                ->addViolation();
        } elseif (
            $dayOfWeek == 5 && (
                ($time >= '00:00' && $time < '09:00') ||
                ($time >= '12:00' && $time < '13:30') ||
                ($time >= '19:30' && $time <= '23:59')
            ) 
        ) {
            $context->buildViolation('Les rendez-vous le vendredi sont disponibles de 9h à 12h et de 13h30 à 19h30.')
                ->addViolation();
        } elseif (
            $dayOfWeek == 6 && (
                ($time >= '00:00' && $time < '09:00') ||
                ($time >= '12:00' && $time < '13:00') ||
                ($time >= '17:30' && $time <= '23:59')
            ) 
        ) {
            $context->buildViolation('Les rendez-vous le samedi sont disponibles de 9h à 12h et de 13h à 17h30.')
                ->addViolation();
        }
    }
}
