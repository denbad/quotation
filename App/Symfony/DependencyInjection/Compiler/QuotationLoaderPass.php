<?php

declare(strict_types=1);

namespace App\Symfony\DependencyInjection\Compiler;

use App\Infrastructure\QuotationProvider\QuotationProvider;
use App\Symfony\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

final class QuotationLoaderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $configs = $container->getExtensionConfig('app');
        $config = (new Processor())->processConfiguration(new Configuration(), $configs);

        $defaultLoaderId = 'app.infrastructure.quotation_provider.default_loader';

        if ($container->hasDefinition($defaultLoaderId)) {
            $loaders = $container->findTaggedServiceIds('quotation_loader');

            // Set alias for default loader
            foreach ($loaders as $id => $tags) {
                foreach ($tags as $attributes) {
                    if ($attributes['alias'] === $config['quotation']['loader']) {
                        $container->setAlias($defaultLoaderId, $id);
                        break;
                    }
                }
            }

            // Inject loaders in provider
            if ($loaders && $container->hasDefinition(QuotationProvider::class)) {
                $provider = $container->getDefinition(QuotationProvider::class);
                $provider->addMethodCall('addLoader', ['default', new Reference($defaultLoaderId)]);

                foreach ($loaders as $id => $tags) {
                    foreach ($tags as $attributes) {
                        $provider->addMethodCall('addLoader', [$attributes['alias'], new Reference($id)]);
                    }
                }
            }
        }
    }
}
