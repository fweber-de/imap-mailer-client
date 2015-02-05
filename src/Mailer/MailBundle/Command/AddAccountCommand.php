<?php

namespace Mailer\MailBundle\Command;

use Mailer\UserBundle\Entity\User;
use Mailer\DataBundle\Entity\Account;
use SimpleBus\Message\Type\Command;

class AddAccountCommand implements Command
{
    /**
     * @var Account
     */
    private $account;

    public function __construct($title, $server, $username, $password, $port, $secure, User $user)
    {
        $account = new Account();
        $account->setCreationDate(new \DateTime('now'))
            ->setServer($server)
            ->setTitle($title)
            ->setUsername($username)
            ->setUser($user)
            ->setPassword($password)
            ->setPort($port)
            ->setSecure($secure);

        $this->account = $account;
    }

    /**
     * @return Account
     */
    public function account()
    {
        return $this->account;
    }
}