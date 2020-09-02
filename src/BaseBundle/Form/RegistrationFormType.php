<?php

namespace BaseBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Coruja\BaseBundle\Form\Subscriber\UserSubscriber;



class RegistrationFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('username', null, array('label' => 'Nome de acesso'))
            ->add('email', 'Symfony\Component\Form\Extension\Core\Type\EmailType', array('label' => 'E-mail', 'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', 'Symfony\Component\Form\Extension\Core\Type\RepeatedType', array(
                'type' => 'Symfony\Component\Form\Extension\Core\Type\PasswordType',
                'first_options' => array('label' => 'Senha'),
                'second_options' => array('label' => 'Confirme a senha'),
                'invalid_message' => 'As senhas precisam ser iguais.',
            ))
        ;
    }
    
    public function getParent() {
        return BaseRegistrationFormType::class;
    }
}