<?php

# https://symfony.com/doc/3.4/reference/forms/types/entity.html
# Alterar modo de enviar label entity

namespace BaseBundle\Form;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class ComponentType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        #print_r($options['csrf_token_id']->getId());
        $currentUser = $options['csrf_token_id'];

        $builder
            ->add('title', TextType::class, array('label' => 'Título', 'attr' => array('autofocus' => true )))
            ->add('description',TextareaType::class, array('label' => 'Descrição'))
            ->add('status',CheckboxType::class, array('label' => 'Status', 'attr' => array('s' => '50px' )))
            ->add('surrounding',EntityType::class,[
                'label' => 'Ambiente',
                'placeholder' => 'Selecione um ambiente',
                'class' => 'BaseBundle\Entity\Surrounding',
                'choice_label' => 'title',
            ]);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array('data_class' => 'BaseBundle\Entity\Component'));
    }
}

/*
->add('user',EntityType::class,[
    'label' => 'Nome do usuário',
    'placeholder' => 'Selecione o usuário',
    'class' => 'BaseBundle\Entity\User',
    'choice_label' => 'username',
    'query_builder' => function (EntityRepository $er) {
        return $er->createQueryBuilder('u')
            ->where('u.id = :id')
            ->setParameter(':id', 1);
    },
])