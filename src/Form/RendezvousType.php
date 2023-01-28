<?php

namespace App\Form;

use App\Entity\Rendezvous;
use App\Entity\Prestations;
use App\Form\RendezvousType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class RendezvousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $userId = $options['user'];
        $options = array();
        $options['hours'] = [
            [
                'day' => 2,
                'hours' => [9,10,11,12,13,14,15,16,17,18]
            ],
            [
                'day' => 3,
                'hours' => [9,10,11,12,13,14,15]
            ],
            [
                'day' => 4,
                'hours' => [9,10,11,12,13,14,15,16,17]
            ],
            [
                'day' => 5,
                'hours' => [9,10,11,12,13,14,15,16,17,18,19,20]
            ],
        ];
        $hours = array();
        foreach ($options['hours'] as $day) {
            foreach($day['hours'] as $hour){
                $hours[] = $hour;
            }
        }
        $builder    
        ->add('user', HiddenType::class)
        ->add('rendezvous', DateTimeType::class, [
            'date_widget' => 'single_text',
            'days' => [2,3,4,5],
            'hours' => $hours,
        ])
        ->add('prestations', EntityType::class, [
            'class' => Prestations::class,
            'choice_label' => function (Prestations $prestations) {
                return $prestations->getNom() . ' - ' . $prestations->getTarif().'€';
            },
        ])
        ->add('employe')   
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rendezvous::class,
            'user' => '',
        ]);
    }

    public function validateDate($date, ExecutionContextInterface $context)
    {
        $dayOfWeek = date('N', $date->getTimestamp());
        if ($dayOfWeek == 1 || $dayOfWeek == 7) {
            $context->buildViolation('La date sélectionnée ne peut pas être un lundi ou un dimanche')
                ->atPath('rendezvous')
                ->addViolation();
        }
    }
}
