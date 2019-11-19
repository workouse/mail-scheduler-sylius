<?php


namespace Workouse\MailSchedulerPlugin\Service;

use GuzzleHttp\Client;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Mailer\Provider\EmailProviderInterface;
use Sylius\Component\Mailer\Renderer\Adapter\AdapterInterface as RendererAdapterInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Workouse\Esenlik;
use Workouse\MailgunContent;
use Workouse\MailSchedule;
use Workouse\MailSchedulerPlugin\Entity\SchedulerInterface;

class MailSchedulerService
{
    /** @var Esenlik $esenlik */
    private $esenlik;

    /** @var FactoryInterface $schedulerFactory */
    private $schedulerFactory;

    /** @var EmailProviderInterface $emailProvider */
    private $emailProvider;

    /** @var RendererAdapterInterface */
    private $rendererAdapter;

    public function __construct(
        FactoryInterface $schedulerFactory,
        EmailProviderInterface $emailProvider,
        RendererAdapterInterface $rendererAdapter

    )
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8080'
        ]);

        $this->esenlik = new Esenlik($client);
        $this->schedulerFactory = $schedulerFactory;
        $this->emailProvider = $emailProvider;
        $this->rendererAdapter = $rendererAdapter;
    }

    public function promotionCodeAfterUserRegister(CustomerInterface $customer)
    {
        $email = $this->emailProvider->getEmail('user_registration');
        if (!$email->isEnabled()) {
            return;
        }

        $mailSchedule = new MailSchedule();

        $renderedEmail = $this->rendererAdapter->render($email, ['user' => ['username' => 'omer']]);

        $mailSchedule
            ->setSubject($email->getSubject())
            ->setReceiverEmail($customer->getEmail())
            ->setProvider(MailSchedule::PROVIDER_SWIFT)
            ->setContent($renderedEmail->getBody())
            ->setContentType(MailSchedule::CONTENT_TYPE_HTML)
            ->setSendAt((new \DateTime())->modify('-2 days '));

        $result = $this->esenlik->create($mailSchedule);

        dd($result);

        /** @var SchedulerInterface $scheduler */
        $scheduler = $this->schedulerFactory->createNew();
        $scheduler->setSubject($scheduler->getSubject());
        $scheduler->setCustomer($customer);


    }
}
