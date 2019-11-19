<?php


namespace Workouse\MailSchedulerPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;

Interface SchedulerInterface extends ResourceInterface
{
    public function getCustomer();

    public function setCustomer($customer);

    public function getSubject(): string;

    public function setSubject(string $subject): void;
}
