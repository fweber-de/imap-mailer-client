<?php
namespace Mailer\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MailerUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
