<?php

namespace Mailer\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InboxController extends Controller
{
    public function unifiedInboxAction()
    {
        return $this->render("Inbox/unified.html.twig");
    }
}
