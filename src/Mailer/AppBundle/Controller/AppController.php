<?php

namespace Mailer\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AppController extends Controller
{
    public function unifiedInboxAction()
    {
        $user = $this->getUser();

        $accounts = $this->getDoctrine()->getRepository('MailerDataBundle:Account')->findByUser($user);
        $mails = null;

        foreach ($accounts as $account) {
            $_mails = $this->get('mailer.imap')->fetch($this->get('mailer.imap')->connect($account), 'INBOX');

            foreach ($_mails as $m) {
                $mails[] = $m;
            }
        }

        return $this->render(
            'App/unified.html.twig',
            array(
                'mails' => $mails,
                'accounts' => $accounts
            )
        );
    }

    public function settingsAction()
    {
        return $this->render('App/settings.html.twig');
    }

    public function sidebarAction($accountId = null)
    {
        if (!$accountId) {
            $user = $this->getUser();

            $accounts = $this->getDoctrine()->getRepository('MailerDataBundle:Account')->findByUser($user);

            return $this->render(
                '_sidebar.html.twig',
                array(
                    'accounts' => $accounts
                )
            );
        }

        $account = $this->getDoctrine()->getRepository('MailerDataBundle:Account')->findOneById($accountId);

        if (!$account) {
            throw $this->createNotFoundException(sprintf('No Account with ID %s was found!', $accountId));
        }

        return $this->render(
            '_sidebar.html.twig',
            array(
                'account' => $account
            )
        );
    }
}
