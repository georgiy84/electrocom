<?php

namespace Core\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Core\UserBundle\Entity\users;

class UsersController extends Controller {

    public function registerAction(Request $formRequest) {

        if ($formRequest->request->get('form')['save']) {
            $createUser = $this->createAction($formRequest->request->get('form'));
        }
        $em = $this->getDoctrine()->getEntityManager();
        $country_array = array();

        $users = new users();
        $countryEm = $em->getRepository('CoreUserBundle:country');

        for ($i = 0; $i < sizeof($countryEm->findAll()); $i++) {
            $country_array[$countryEm->findAll()[$i]->getName()] = $countryEm->findAll()[$i]->getId();
        }

        $form = $this->createFormBuilder($users)
                ->add('name', TextType::class)
                ->add('email', TextType::class)
                ->add('password', PasswordType::class)
                ->add('gender', ChoiceType::class, ['choices' => array(
                        'Masculino' => '1',
                        'Femenino' => '2',
            )])
                ->add('country', ChoiceType::class, ['choices' => array(
                        $country_array
            )])
                ->add('save', SubmitType::class, ['label' => 'Create Usuario', 'attr' => ['value' => '1']])
                ->getForm();

        if (isset($createUser) && $createUser == 1) {
            return $this->render('CoreUserBundle:Users:register_finish.html.twig', [
                        'createUser' => 1,
            ]);
        } else if (isset($createUser) && $createUser == 0) {
            return $this->render('CoreUserBundle:Users:register_finish.html.twig', [
                        'createUser' => 0,
            ]);
        } else {
            return $this->render('CoreUserBundle:Users:register.html.twig', [
                        'form' => $form->createView(),
            ]);
        }
    }

    public function createAction($formRequest) {

        $dateNow = new \DateTime("now");

        $em = $this->getDoctrine()->getEntityManager();
        $Country = $em->getRepository('Core\UserBundle\Entity\country')->find($formRequest['country']);
        $entityManager = $this->getDoctrine()->getManager();


        $users = new users();
        $users->setName($formRequest['name']);
        $users->setEmail($formRequest['email']);
        $users->setPassword($formRequest['password']);
        $users->setCountry($Country);
        $users->setGender($formRequest['gender']);
        $users->setDateUp($dateNow);
        $users->setDateEdit($dateNow);
        $users->setDateAccess($dateNow);

        $entityManager->persist($users);

        $entityManager->flush();
        return 1;
    }

}
