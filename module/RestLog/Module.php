<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace RestLog;

use RestLog\DAO\impl\RsRestapicallhistoryDaoImpl;
use RestLog\Listener\RestLogResourceListener;
use RestLog\Logic\impl\RsRestapicallhistoryLogicImpl;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $em = $e->getApplication()->getServiceManager()->get('Doctrine\ORM\EntityManager');
        $platform = $em->getConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'RsRestapicallhistoryDao' => function ($sm) {
                    return new RsRestapicallhistoryDaoImpl($sm);
                },
                'RsRestapicallhistoryLogic' => function ($sm) {
                    return new RsRestapicallhistoryLogicImpl($sm);
                },
                'RestLog\Listener\RestLogResourceListener' => function ($services) {
                    $persistence = $services->get('RsRestapicallhistoryDao');
                    return new RestLogResourceListener($persistence);
                },
            ),
        );
    }
}
