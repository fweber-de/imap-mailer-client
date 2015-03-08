<?php

namespace Mailer\MailBundle\Service;

use Coreproc\CryptoGuard\CryptoGuard;

class PasswordHandlerService
{
    /**
     * @var CryptoGuard
     */
    private $cryptoGuard;

    public function __construct($secret)
    {
        $this->cryptoGuard = new CryptoGuard($secret);
    }

    /**
     * @param  string $password
     * @return string
     */
    public function encrypt($password)
    {
        return $this->cryptoGuard->encrypt($password);
    }

    /**
     * @param  string $password
     * @return string
     */
    public function decrypt($password)
    {
        return $this->cryptoGuard->decrypt($password);
    }
}
