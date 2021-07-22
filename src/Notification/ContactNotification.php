<?php

namespace App\Notification;

use App\Entity\Contact;
use Twig\Environment;
use App\Entity\Users;

class ContactNotification
{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify(Contact $contact)
    {
        $user = new Users();
        //sabbah@sabbah.com
        // ->from(new Address('sabbah@sabbah.com', 'sabbah annonces immobilières'))
        // ->to($user->getEmail())
        $message = (new \Swift_Message('Agence : ' . $contact->getProperty()->getTitle()))
            ->setFrom('sabbah@sabbah.com')
            ->setTo('sabbah@sabbah.com')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->renderer->render('emails/contact.html.twig', [
                'contact' => $contact
            ]), 'text/html');
        $this->mailer->send($message);
    }
}
