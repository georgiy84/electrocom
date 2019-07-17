<?php

namespace Core\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Core\UserBundle\Entity\users;

class UsersController extends Controller {

    public function registerAction(Request $request) {
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
