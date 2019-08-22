<?php

namespace Core\UserBundle\Services;

use Doctrine\ORM\EntityManagerInterface;
use Core\UserBundle\Entity\users;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CreateAction {

    private $em;
    private $users;
    private $container;
    private $encoded;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoder $encoded) {
        $this->em = $em;
        $this->users = new users();
        $this->container = new Container();
        $this->encoded = $encoded;
    }

    public function createAction($formRequest) {

        $dateNow = new \DateTime("now");

        $Country = $this->em->getRepository('Core\UserBundle\Entity\country')->find($formRequest['country']);
        
        $encodedPasswrd = $this->encoded->encodePassword($this->users, $formRequest['password']['first']);
        
        $this->users->setName($formRequest['name']);
        $this->users->setEmail($formRequest['email']);
        $this->users->setPassword($encodedPasswrd);
        $this->users->setCountry($Country);
        $this->users->setGender($formRequest['gender']);
        $this->users->setDateUp($dateNow);
        $this->users->setDateEdit($dateNow);
        $this->users->setDateAccess($dateNow);

        $this->em->persist($this->users);

        $this->em->flush();
        return 1;
    }

    public function createFormUsers() {
        $country_array = array();
        $countryEm = $this->em->getRepository('CoreUserBundle:country');
        for ($i = 0; $i < sizeof($countryEm->findAll()); $i++) {
            $country_array[$countryEm->findAll()[$i]->getName()] = $countryEm->findAll()[$i]->getId();
        }
        $form = $this->container->get('form.factory')->createBuilder('form')
        //$this->createFormBuilder($this->users)
                ->add('name', TextType::class)
                ->add('email', TextType::class)
                ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'invalid_message' => 'Password en ambos campos deben ser iguales.',
                    'options' => ['attr' => ['class' => 'password-field']],
                    'required' => true,
                    'first_options' => ['label' => 'Password'],
                    'second_options' => ['label' => 'Confirme Password'],
                ])
                ->add('gender', ChoiceType::class, ['choices' => array(
                        'Masculino' => '1',
                        'Femenino' => '2',
            )])
                ->add('country', ChoiceType::class, ['choices' => array(
                        $country_array
            )])
                ->add('save', SubmitType::class, ['label' => 'Create Usuario', 'attr' => ['value' => '1']])
                ->getForm();
        return $form;
    }

}
