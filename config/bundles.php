<?php

return [
    App\Symfony\AppBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    SimpleBus\SymfonyBridge\SimpleBusCommandBusBundle::class => ['all' => true],
    SimpleBus\SymfonyBridge\SimpleBusEventBusBundle::class => ['all' => true],
    SimpleBus\SymfonyBridge\DoctrineOrmBridgeBundle::class => ['all' => true],
];
