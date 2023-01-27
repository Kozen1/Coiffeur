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
        $builder    
        ->add('user', HiddenType::class)
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
