<?php

namespace Dino\Play;

//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$start = microtime(true);

require __DIR__.'/../vendor/autoload.php';//we cans now acces dependency injection and libraries like //monolog

$cachedContainer = __DIR__.'/cached_container.php';
if (!file_exists($cachedContainer)) {


    $container = new ContainerBuilder();
    $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/config'));
    $loader->load('services.yml');


    $container->setParameter('root_dir', __DIR__);
    $container->setParameter('logger_startup_message', 'Logger just got started!!!');


    //$getCompilerPass = $container->getCompilerPassConfig();
    //dump($getCompilerPass);
    //$getCompiler = $container->getCompiler();
    //dump($getCompiler);

    $container->compile();
    $dumper = new PhpDumper($container);
    file_put_contents(__DIR__ . '/cached_container.php', $dumper->dump());
}
    require $cachedContainer;
    $container = new \ProjectServiceContainer();

    $services = $container->getServiceIds();
    runAppssssssss($container);


function runAppssssssss(ContainerInterface $container)
{
    //dump($various);
    $container->get('logger')->info('ROARRRR');
}
$elapsed = round((microtime(true) - $start) * 1000);
$container->get('logger')->debug('Elapsed Time: '.$elapsed.'ms');


//$handler = new StreamHandler(__DIR__.'/dino.log');
//$container->set('logger.stream_handler', $handler);

/*
$loggerDefinition = new Definition('Monolog\Logger');
$loggerDefinition->setArguments(array(
    'main',
    array(new Reference('logger.stream_handlerffff'))
));


//$loggerDefinition->addMethodCall('getHandlers');



$loggerDefinition->addMethodCall('pushHandler', array(
    new Reference('logger.std_out_handler')
));
$loggerDefinition->addMethodCall('debug', array(
    'Logger just got started'
));
*/

//$container->setDefinition('logger', $loggerDefinition);
/*
$handlerDefinition = new Definition('Monolog\Handler\StreamHandler');
$handlerDefinition->setArguments(array(
    __DIR__.'/dino.log'
));
$container->setDefinition('logger.stream_handler', $handlerDefinition);
*/
/*$handlerOutDefinition = new Definition('Monolog\Handler\StreamHandler');
$handlerOutDefinition->setArguments(array(
    'php://stdout'
));
$container->setDefinition('logger.std_out_handler', $handlerOutDefinition);
*/





//$container->set('logger', $logger);





//$logger->debug('ROOAARR');

//$cachedContainer = __DIR__.'/cached_container.php';
//if (!file_exists($cachedContainer)) {


/*  $container->setParameter('root_dir', __DIR__);

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
*/





