<?php

namespace Mailer\MailBundle\Service;

use Mailer\DataBundle\Entity\Account;

class ImapService
{
    /**
     * @var string
     */
    private $imapDebugFolder;

    /**
     * @var PasswordHandlerService
     */
    private $passwordHandler;

    public function __construct($imapDebugFolder, $passwordHandler)
    {
        $this->imapDebugFolder = $imapDebugFolder;
        $this->passwordHandler = $passwordHandler;
    }

    /**
     * @param  Account                     $account
     * @return Horde_Imap_Client_Socket
     * @throws Horde_Imap_Client_Exception
     */
    public function connect(Account $account)
    {
        $client = new Horde_Imap_Client_Socket(
            array(
                'username' => $account->getUsername(),
                'password' => $this->passwordHandler()->decrypt($account->getPassword()),
                'hostspec' => $account->getServer(),
                'port' => $account->getPort(),
                'secure' => $account->getSecure(),
                'debug' => $this->imapDebugFolder,
            )
        );

        return $client;
    }
}
