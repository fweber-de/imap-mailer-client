<?php

namespace Mailer\MailBundle\CommandHelper;

use Doctrine\Bundle\DoctrineBundle\Registry;
use SimpleBus\Message\Handler\MessageHandler;
use SimpleBus\Message\Message;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

class AddAccountCommandHelper implements MessageHandler
{
    /**
     * @var Registry
     */
    private $doctrine;

    private $validator;

    public function __construct($doctrine, $validator)
    {
        $this->doctrine = $doctrine;
        $this->validator = $validator;
    }

    public function handle(Message $message)
    {
        $account = $message->account();
        $errors = $this->validator->validate($account);

        if (count($errors) > 0) {
            throw new InvalidArgumentException((string)$errors);
        }

        $em = $this->doctrine->getManager();
        $em->persist($account);
        $em->flush();
    }
}