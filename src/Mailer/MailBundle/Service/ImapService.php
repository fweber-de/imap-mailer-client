<?php

namespace Mailer\MailBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Mailer\DataBundle\Entity\Account;
use Mailer\DataBundle\Entity\Mail;

class ImapService
{
    /**
     * @var PasswordHandlerService
     */
    private $passwordHandler;

    public function __construct($passwordHandler)
    {
        $this->passwordHandler = $passwordHandler;
    }

    /**
     * @param Account $account
     * @param string  $inbox
     *
     * @return resource
     */
    private function connect($account, $inbox)
    {
        $hostname = sprintf(
            '{%s:%s/imap/%s}%s',
            $account->getServer(),
            $account->getPort(),
            $account->getSecurity(),
            $inbox
        );

        $imapHandle = imap_open(
            $hostname,
            $account->getUsername(),
            $this->passwordHandler->decrypt($account->getPassword())
        );

        return $imapHandle;
    }

    /**
     * @param Account $account
     * @param string  $inbox
     * @param string  $query
     *
     * @return ArrayCollection
     */
    public function fetch($account, $inbox, $query = 'ALL')
    {
        $connection = $this->connect($account, $inbox);
        $emails = \imap_search($connection, $query, SE_UID);

        $collection = new ArrayCollection();

        if ($emails) {
            rsort($emails);

            foreach ($emails as $uid) {
                $overview = imap_fetch_overview($connection, $uid, FT_UID);

                //get mail text
                $text = trim(
                    utf8_encode(
                        quoted_printable_decode(
                            imap_fetchbody($connection, $uid, 1, FT_UID)
                        )
                    )
                );

                //prepare subject
                $subject = (stripos($overview[0]->subject, '?UTF-8?B?') != false)
                    ? base64_decode(str_replace('?=', '', str_replace('?UTF-8?B?', '', $overview[0]->subject)))
                    : $overview[0]->subject;

                $mail = new Mail();
                $mail->setSubject($subject)
                    ->setUid($uid)
                    ->setReceiveDate(new \DateTime($overview[0]->date))
                    ->setSender($overview[0]->from)
                    ->setText($text)
                    ->setAccount($account)
                    ->setInbox($inbox);

                $collection->add($mail);
            }
        }

        imap_close($connection);

        return $collection;
    }
}
