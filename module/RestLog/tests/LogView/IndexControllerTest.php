<?php

namespace RestLog\Component;

use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use PHPUnit_Framework_TestCase;
use RestLog\Component\IndexController;
use RestLog\DAO\impl\RsRestapicallhistoryDaoImpl;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use RestLog\Logic\impl\RsRestapicallhistoryLogicImpl;

class RestLogControllerTest extends PHPUnit_Framework_TestCase
{
    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;

    public function setUp()
    {
        $serviceManager = new ServiceManager(new ServiceManagerConfig());
        $serviceManager = new ServiceManager(new ServiceManagerConfig());
        $serviceManager->setService('RsRestapicallhistoryLogic', $this->getMock('RestLog\Logic\impl\RsRestapicallhistoryLogicImpl') );

        $this->controller = new IndexController();
        $this->controller->setServiceLocator($serviceManager);
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'index'));
        $this->event      = new MvcEvent();
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
    }


    public function testIndexActionCanBeAccessed()
    {
        $this->routeMatch->setParam('action', 'index');

        $result   = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
    }

    public function testItemActionCanBeAccessed()
    {
        $this->routeMatch->setParam('action', 'item');

        $result   = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
    }

    



}
