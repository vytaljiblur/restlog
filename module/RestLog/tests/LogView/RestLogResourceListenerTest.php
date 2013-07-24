<?php

namespace RestLog\Component;

use PhlyRestfully\Plugin\HalLinks;
use PhlyRestfully\Resource;
use PhlyRestfully\ResourceController;
use PhlyRestfully\View\RestfulJsonModel;
use PhlyRestfully\View\RestfulJsonRenderer;
use PHPUnit_Framework_TestCase as TestCase;
use RestLog\Bootstrap;
use RestLog\DAO\impl\RsRestapicallhistoryDaoImpl;
use RestLog\Listener\RestLogResourceListener;
use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\ControllerManager;
use Zend\Mvc\Controller\PluginManager as ControllerPluginManager;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Http\TreeRouteStack;
use Zend\Mvc\Router\RouteMatch;
use Zend\Paginator\Adapter\ArrayAdapter as ArrayPaginator;
use Zend\Paginator\Paginator;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Parameters;
use Zend\Uri;
use Zend\View\HelperPluginManager;
use Zend\View\Helper\ServerUrl as ServerUrlHelper;
use Zend\View\Helper\Url as UrlHelper;

class RestLogResourceListenerTest extends TestCase
{
    public function getServiceManager()
    {
        $service = Bootstrap::getServiceManager();
        return $service;
    }

    public function testRESTResourceIsWorking()
    {
        $services = $this->getServiceManager();

        $controller = $services->get('ControllerLoader')->get('RestLog\ApiController');

        $routeMatch = new RouteMatch(array('controller' => 'index'));
        $event      = new MvcEvent();
        $event->setRouteMatch($routeMatch);
        $controller->setEvent($event);

        $result = $controller->dispatch(new Request());

        $response = $controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());


    }



}
