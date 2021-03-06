<?php

namespace HealthstackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedicineType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['attr' => ['class' => 'form-control btnchange-input']])
            ->add('vendor', TextType::class, ['attr' => ['class' => 'form-control btnchange-input']])
            ->add('group', TextType::class, ['attr' => ['class' => 'form-control btnchange-input']])
            ->add('code', TextType::class, ['attr' => ['class' => 'form-control btnchange-input']])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HealthstackBundle\Entity\Medicine'
        ));
    }
}
