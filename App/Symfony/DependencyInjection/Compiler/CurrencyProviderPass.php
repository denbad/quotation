<?php

declare(strict_types=1);

namespace App\Symfony\DependencyInjection\Compiler;

use App\Symfony\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

final class CurrencyProviderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $configs = $container->getExtensionConfig('app');
        $config = (new Processor())->processConfiguration(new Configuration(), $configs);

        if ($definition = $container->findDefinition('App\Infrastructure\HttpClient\DefaultAdapter')) {
            foreach ($container->findTaggedServiceIds('app.currency_provider') as $id => $tags) {
                foreach ($tags as $attributes) {
                    if ($attributes['alias'] === $config['currency']['provider']) {
                        $container->setAlias($definition->getClass(), $id);
                        break;
                    }
                }
            }
        }
    }
}
