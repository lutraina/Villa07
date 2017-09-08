<?php

namespace Dino\Play;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$start = microtime(true);

require __DIR__.'/../vendor/autoload.php';

$cachedContainer = __DIR__.'/cached_container.php';
if (!file_exists($cachedContainer)) {
    $container = new ContainerBuilder();
    $container->setParameter('root_dir', __DIR__);

    $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/config'));
    $loader->load('services.yml');

    $container->compile();
    $dumper = new PhpDumper($container);
    file_put_contents(__DIR__ . '/cached_container.php', $dumper->dump());
}
require $cachedContainer;
$container = new \ProjectServiceContainer();

runApp($container);

$elapsed = round((microtime(true) - $start) * 1000);
$container->get('logger')->debug('Elapsed Time: '.$elapsed.'ms');

function runApp(ContainerInterface $container)
{
    $container->get('logger')->info('ROOOOAR');
}
