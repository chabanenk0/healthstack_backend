<?php

namespace HealthstackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, ['attr' => ['class' => 'form-control btnchange-input']])
            ->add('lastName', TextType::class, ['attr' => ['class' => 'form-control btnchange-input']])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control btnchange-input',
                ],
            ])
            ->add('telephone', TextType::class, ['attr' => ['class' => 'form-control btnchange-input']])
//            ->add('avatar', FileType::class, [
//                'required' => false,
//            ])
            ->add('pin', TextType::class, [
                'attr' => [
                    'class' => 'form-control btnchange-input',
                ],
            ])
            ->add('password', PasswordType::class, ['attr' => ['class' => 'form-control btnchange-input']])
            ->add('token', TextType::class, [
                'attr' => [
                    'class' => 'form-control btnchange-input',
                ],
                'required' => false,
            ])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HealthstackBundle\Entity\Patient'
        ));
    }
}
