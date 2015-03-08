<?php

namespace Mailer\AppBundle\Controller;

use Mailer\DataBundle\Entity\Account;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AccountController extends Controller
{
    public function createAction(Request $request)
    {
        if ($request->get('sent', 0) == 1) {
            $account = new Account();
            $account->setCreationDate(new \DateTime('now'))
                ->setServer($request->get('server'))
                ->setEmail($request->get('email'))
                ->setUsername($request->get('username'))
                ->setUser($this->getUser())
                ->setPassword(
                    $this->get('mailer.password_handler')->encrypt($request->get('password'))
                )
                ->setPort($request->get('port'))
                ->setSecurity($request->get('security'));

            $errors = $this->get('validator')->validate($account);

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $this->addFlash('error', $error);
                }

                return $this->render('Account/create.html.twig');
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($account);
            $em->flush();

            return $this->redirectToRoute('unified_inbox');
        }

        return $this->render('Account/create.html.twig');
    }
}
