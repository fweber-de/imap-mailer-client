<?php

namespace Mailer\MailBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Mailer\DataBundle\Entity\Account;
use Mailer\DataBundle\Entity\Mail;

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
     * @param  Account $account
     * @return Horde_Imap_Client_Socket
     * @throws Horde_Imap_Client_Exception
     */
    public function connect(Account $account)
    {
        $client = new \Horde_Imap_Client_Socket(
            array(
                'username' => $account->getUsername(),
                'password' => $this->passwordHandler->decrypt($account->getPassword()),
                'hostspec' => $account->getServer(),
                'port' => $account->getPort(),
                'secure' => $account->getSecurity(),
                'debug' => $this->imapDebugFolder,
            )
        );

        return $client;
    }

    /**
     * @param Horde_Imap_Client_Socket $client
     * @param string $inbox
     * @return ArrayCollection
     */
    public function fetch($client, $inbox)
    {
        $collection = new ArrayCollection();

        //get mails
        /*$uids = $client->search($inbox)['match'];

        foreach ($uids as $uid) {
            $mail = new Mail();
            $mail->setUid($uid);

            $collection->add($mail);
        }*/

        $query = new \Horde_Imap_Client_Fetch_Query();
        $query->structure();

        $results = $client->fetch($inbox, $query);

        var_dump($results);

        /* @var $result \Horde_Imap_Client_Data_Fetch */
        foreach ($results as $uid => $result) {
            //metadaten
            $structrue = $result->getStructure();

            //envelope
            /* @var $envelope \Horde_Imap_Client_Data_Envelope */
            $envelope = $result->getEnvelope();

            $id = $structrue->findBody();
            $body = $structrue->getPart($id);

            $query2 = new \Horde_Imap_Client_Fetch_Query();
            $query2->bodyPart(
                $id,
                array(
                    'decode' => true,
                    'peek' => false
                )
            );

            $list2 = $client->fetch(
                $inbox,
                $query2,
                array(
                    'ids' => $uid
                )
            );

            $message = $list2->first();
            $text = $message->getBodyPart($id);

            $body->setContents($text);
            $text = $body->getContents();

            $mail = new Mail();
            $mail->setUid($uid)
                ->setText($text);

            $collection->add($mail);
        }

        return $collection;
    }
}
