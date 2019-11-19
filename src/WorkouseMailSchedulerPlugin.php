<?php

declare(strict_types=1);

namespace Workouse\MailSchedulerPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class WorkouseMailSchedulerPlugin extends Bundle
{
    use SyliusPluginTrait;
}
