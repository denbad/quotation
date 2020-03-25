<?php

declare(strict_types=1);

namespace App\Symfony\DependencyInjection\Compiler;

use App\Symfony\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

final class QuotationLoaderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $configs = $container->getExtensionConfig('app');
        $config = (new Processor())->processConfiguration(new Configuration(), $configs);

        if ($definition = $container->findDefinition('App\Infrastructure\QuotationProvider\DefaultLoader')) {
            foreach ($container->findTaggedServiceIds('quotation_loader') as $id => $tags) {
                foreach ($tags as $attributes) {
                    if ($attributes['alias'] === $config['quotation']['loader']) {
                        $container->setAlias($definition->getClass(), $id);
                        break;
                    }
                }
            }
        }
    }
}
