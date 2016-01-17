<?php

namespace HealthstackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $builder->add('hash');
        $builder->add('patient', EntityType::class, [
            'class' => 'HealthstackBundle:Patient',
            'choice_label' => 'lastName',
            'multiple' => false,
            'expanded' => false,
            'attr' => ['class' => 'form-control'],
        ]);
        $builder->add('visitDate', DateType::class);
        $builder->add('activeStatus', ChoiceType::class, [
            'choices' => [
                'Inactive' => false,
                'Active' => true,
            ],
            'attr' => ['class' => 'form-control'],
            'required' => false,
        ]);
        $builder->add('symptomes', TextType::class, [
            'attr' => ['class' => 'form-control'],
            'required' => false,
        ]);
        $builder->add('diagnosis', TextType::class, [
            'attr' => ['class' => 'form-control'],
            'required' => false,
        ]);

        $builder->add('items', CollectionType::class, [
            'entry_type' => TicketItemType::class,
            'allow_add'    => true,
            'allow_delete' => true,
        ]);

    }


    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HealthstackBundle\Entity\Ticket'
        ));
    }
}
