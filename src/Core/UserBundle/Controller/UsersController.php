<?php

namespace Core\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Core\UserBundle\Entity\users;
use Core\UserBundle\Services\CreateAction;

class UsersController extends Controller {

    private $email;
    
    

    public function registerAction(Request $formRequest) {

        $em = $this->getDoctrine()->getEntityManager();
        $country_array = array();

        $users = new users();
        $countryEm = $em->getRepository('CoreUserBundle:country');
        $create_action = $this->get(CreateAction::class);//core_user.create_action
        for ($i = 0; $i < sizeof($countryEm->findAll()); $i++) {
            $country_array[$countryEm->findAll()[$i]->getName()] = $countryEm->findAll()[$i]->getId();
        }

        $form = $this->createFormBuilder($users)
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

        if ($formRequest->request->get('form')['save']) {

            $this->email = $formRequest->request->get('form')['email'];
            $validate = $this->validatorEmailAction();
            
            if (0 !== count($validate)) {
                return $this->render('CoreUserBundle:Users:register.html.twig', [
                            'form' => $form->createView(),
                            'errors' => $validate,
                ]);
            }
            
            
            $createUser = $create_action->createAction($formRequest->request->get('form'));
        }

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

    public function validatorEmailAction() {
        $email = $this->email;
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
        $emailConstraint = new Assert\Email();
        // all constraint "options" can be set this way
        $emailConstraint->message = 'Invalid email address';

        // use the validator to validate the value
        $errors = $validator->validate(
                $email, $emailConstraint
        );

        return $errors;
    }

}
