<?php

namespace App\Services;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class Sendmail
{
    private MailerInterface $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmailCommande($emails,$panier,$personne)
    {
        $message = (new TemplatedEmail())
            ->from(new Address('amshopnow@allagence.com', 'commande'))
            ->to($emails)
            ->subject('Facture de commande amshopnow ')
            ->htmlTemplate('mail/soumission_commande.html.twig')
            ->context([
                'panier' => $panier,
                'personne'=>$personne,

            ]);

        $this->mailer->send($message);
    }


}
