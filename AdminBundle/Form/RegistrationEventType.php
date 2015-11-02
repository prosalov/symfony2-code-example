<?php

namespace AdminBundle\Form;

use AppBundle\Entity\RegistrationEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use AppBundle\Entity\Repository\StateRepository;
use AppBundle\Entity\Repository\CityRepository;

class RegistrationEventType extends AbstractType
{
    /**
     * @var array
     */
    protected $domains;

    /**
     * @param string $domains
     */
    public function __construct($domains)
    {
        $this->domains = $domains;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('venue', 'text', [
                'label' => 'admin.registration_event.field.venue',
            ])
            ->add('address', 'text', [
                'label' => 'admin.registration_event.field.address',
            ])
            ->add('country', 'entity', [
                'label'         => 'admin.registration_event.field.country',
                'class'         => 'AppBundle\Entity\Country',
                'property'      => 'name',
                'required'      => true,
                'empty_value'   => 'admin.form.select_empty_value',
                'query_builder' => function($repository) {
                    return $repository->createQueryBuilder('c')->add('orderBy', 's.name ASC');
                },
            ])
            ->add('postalCode', 'text', [
                'label' => 'admin.registration_event.field.postal_code',
            ])
            ->add('date', 'date', [
                'label'  => 'admin.registration_event.field.date',
                'widget' => 'single_text',
            ])
            ->add('domain', 'choice', [
                'label'   => 'admin.registration_event.field.domain',
                'choices' => $this->domains,
            ])
            ->add('time_groups', 'collection', [
                'label'              => 'admin.registration_event.field.time_groups',
                'type'               => 'admin_time_group',
                'allow_add'          => true,
                'allow_delete'       => true,
                'by_reference'       => false,
            ])
            ;

        $factory = $builder->getFormFactory();
        
        $refreshStates = function ($form, $country) use ($factory)
        {
            $stateAttr = ($country) ? [] : ['disabled' => 'disabled'];
            
            $form->add($factory->createNamed('state', 'entity', null, [
                'label'           => 'admin.registration_event.field.state',
                'class'           => 'AppBundle\Entity\State',
                'property'        => 'name',
                'required'        => true,
                'empty_value'     => 'admin.form.select_empty_value',
                'auto_initialize' => false,
                'attr'            => $stateAttr,
                'query_builder'   => function (StateRepository $repository) use ($country) {
                    return $repository->createQueryBuilder('s')
                        ->add('orderBy', 's.name ASC')
                        ->add('where', 's.country = :country')
                        ->setParameter('country', $country); 
                }
            ]));
        };
        
        $refreshCities = function ($form, $state) use ($factory)
        {
            $cityAttr = ($state) ? [] : ['disabled' => 'disabled'];
            
            $form->add($factory->createNamed('city', 'entity', null, [
                'label'           => 'admin.registration_event.field.city',
                'class'           => 'AppBundle\Entity\City',
                'property'        => 'name',
                'required'        => true,
                'empty_value'     => 'admin.form.select_empty_value',
                'auto_initialize' => false,
                'attr'            => $cityAttr,
                'query_builder'   => function (CityRepository $repository) use ($state) {
                    return $repository->createQueryBuilder('cT')
                        ->add('orderBy', 'cT.name ASC')
                        ->add('where', 'cT.state = :state')
                        ->setParameter('state', $state); 
                }
            ]));
        };

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($refreshStates, $refreshCities) {
            $form = $event->getForm();
            $data = $event->getData();

            if ($data instanceof RegistrationEvent) {
                $refreshStates($form, ($data->getId()) ? $data->getCountry() : null);
                $refreshCities($form, ($data->getId()) ? $data->getState() : null);
            }
        });

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($refreshStates, $refreshCities) {
            $form = $event->getForm();
            $data = $event->getData();

            $refreshStates($form, array_key_exists('country', $data) ? $data['country'] : null);
            $refreshCities($form, array_key_exists('state', $data) ? $data['state'] : null);
        });
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => 'AppBundle\Entity\RegistrationEvent',
            'cascade_validation' => true,
        ]);
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_registration_event';
    }
}
