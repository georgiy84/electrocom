<?php

namespace Core\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Core\UserBundle\Entity\users;

class UsersController extends Controller {

    public function registerAction(Request $form) {
        // creates a task and gives it some dummy data for this example
        $users = new users();
        //$users->setTask('Write a blog post');
        //$task->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($users)
                ->add('name', TextType::class)
                ->add('email', TextType::class)
                ->add('save', SubmitType::class, ['label' => 'Create Task'])
                ->getForm();

        return $this->render('CoreUserBundle:Users:register.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

}
