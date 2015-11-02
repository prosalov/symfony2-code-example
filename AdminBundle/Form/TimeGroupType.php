<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TimeGroupType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('time', 'time', [
                'label'        => false,
                'widget'       => "single_text",
                'with_seconds' => false,
            ])
            ->add('capacity', 'text', [
                'label' => false,
            ])
            ->add('amount', 'genemu_plain', [
                'label' => false,
            ])
            ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\TimeGroup'
        ]);
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_time_group';
    }
}
