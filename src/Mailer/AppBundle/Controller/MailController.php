<?php

namespace Mailer\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MailController extends Controller
{

    public function showAction(Request $request, $mailId)
    {
        $mail = $this->getDoctrine()->getRepository('MailerDataBundle:Mail')->findOneById($mailId);

        return $this->render(
            'Mail/show.html.twig',
            array(
                'mail' => $mail
            )
        );
    }

    /**
     * @return bool
     */
    public function fetchAllAccountsAction($inbox)
    {
        $user = $this->getUser();
        $accounts = $this->getDoctrine()->getRepository('MailerDataBundle:Account')->findByUser($user);

        //delete saved mails
        $em = $this->getDoctrine()->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()
            ->delete('MailerDataBundle:Mail', 'm')
            ->where('m.inbox = :inbox')
            ->setParameter('inbox', $inbox);
        $queryBuilder->getQuery()->execute();

        /* @var $account \Mailer\DataBundle\Entity\Account */
        foreach ($accounts as $account) {
            $mails = $this->get('mailer.imap')->fetch($account, 'INBOX', 'ALL');

            foreach ($mails as $mail) {
                $account->addMail($mail);
            }

            $em->flush();
        }

        $response = new Response(json_encode(array('success' => true)));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
