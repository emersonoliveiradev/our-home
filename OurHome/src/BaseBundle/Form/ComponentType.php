<?php

namespace BaseBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ComponentType extends AbstractType {
    
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', null, array('label' => 'Nome'))
            ->add('description',null, array('label' => 'Descrição'))
            ->add('status',null, array('label' => 'Status'))
            ->add('user',null, array('label' => 'Usuário'))
            ->add('surrounding',null, array('label' => 'Ambiente'));
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array('data_class' => 'BaseBundle\Entity\Component'));
    }
}
