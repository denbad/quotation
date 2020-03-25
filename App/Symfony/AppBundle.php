<?php

declare(strict_types=1);

namespace App\Symfony;

use App\Symfony\DependencyInjection\Compiler\QuotationLoaderPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class AppBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new QuotationLoaderPass());
    }
}
