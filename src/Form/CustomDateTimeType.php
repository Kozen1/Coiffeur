<?php
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomDateTimeType extends AbstractType
{
    public function getParent()
    {
        return DateTimeType::class;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $options['minutes'] = [0, 15, 30, 45];

        parent::buildView($view, $form, $options);
    }
}
