<?php


namespace Workouse\MailSchedulerPlugin\EventListener;


use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\CustomerInterface;
use Workouse\MailSchedulerPlugin\Service\MailSchedulerService;

class MailSchedulerListener
{
    /** @var MailSchedulerService $mailSchedulerService */
    private $mailSchedulerService;

    public function __construct(MailSchedulerService $mailSchedulerService)
    {
        $this->mailSchedulerService = $mailSchedulerService;
    }

    public function run(ResourceControllerEvent $event)
    {
        /** @var CustomerInterface $customer */
        $customer = $event->getSubject();

        $this->mailSchedulerService->promotionCodeAfterUserRegister($customer);
    }
}
