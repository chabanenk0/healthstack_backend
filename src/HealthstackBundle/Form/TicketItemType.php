<?php

namespace HealthstackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TicketItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('medicine', EntityType::class, [
            'class' => 'HealthstackBundle:Medicine',
            'choice_label' => 'name',
            'multiple' => false,
            'expanded' => false,
            'attr' => ['class' => 'form-control btnchange-input'],
        ]);
        $builder->add('countPerDay', IntegerType::class, ['attr' => ['class' => 'form-control btnchange-input']]);
        $builder->add('totalDays', IntegerType::class, ['attr' => ['class' => 'form-control btnchange-input']]);
        $builder->add('dose', TextType::class, [
            'attr' => ['class' => 'form-control btnchange-input'],
        ]);
        $builder->add('doseAmount', IntegerType::class, ['attr' => ['class' => 'form-control btnchange-input'], 'label' => 'Amount to buy']);
        $builder->add('takeTime1', TimeType::class, ['attr' => ['class' => 'form-control btnchange-input']]);
        $builder->add('takeTime2', TimeType::class, ['attr' => ['class' => 'form-control btnchange-input']]);
        $builder->add('takeTime3', TimeType::class, ['attr' => ['class' => 'form-control btnchange-input']]);
    }


    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HealthstackBundle\Entity\TicketItem'
        ));
    }
}
