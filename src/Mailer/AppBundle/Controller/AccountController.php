<?php

namespace Mailer\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AccountController extends Controller
{
    public function createAction(Request $request)
    {
        if ($request->get('sent', 0) == 1) {

        }

        return $this->render('Account/create.html.twig');
    }
}
