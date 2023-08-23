<?php

namespace App\Service;

class Invoice
{
    private EmailService $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function process(string $recipientEmail, float $amount): bool
    {
        $message = "Votre commande d'un montant de {$amount}€ est confirmée";
        
        return $this->emailService->send($recipientEmail, $message);
    }
}