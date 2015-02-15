<?php

namespace Mailer\MailBundle\Command;

use SimpleBus\Message\Type\Command;

class FetchEmailFromMailboxCommand implements Command
{
    public function __construct()
    {
    }
}
