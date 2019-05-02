<?php

# https://symfony.com/doc/3.4/reference/forms/types/entity.html
# Alterar modo de enviar label entity

namespace BaseBundle\Form;
use Doctrine\ORM\EntityRepository;
use http\Client\Curl\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


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
