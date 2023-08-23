<?php

namespace App\Tests\Service;

use App\Service\EmailService;
use App\Service\Invoice;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InvoiceTest extends KernelTestCase
{
    public function testInvoiceProcess()
    {
        $emailService = $this->createMock(EmailService::class);
        
        $emailService->expects($this->once())
            ->method('send')
            ->willReturn(true);
        
        $invoice = new Invoice($emailService);
        
        $this->assertTrue($invoice->process('customer@example.com', 100.0));
    }
}