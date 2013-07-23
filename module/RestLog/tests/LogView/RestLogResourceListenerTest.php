<?php

namespace RestLog\Component;

use PhlyRestfully\Plugin\HalLinks;
use PhlyRestfully\Resource;
use PhlyRestfully\ResourceController;
use PhlyRestfully\View\RestfulJsonModel;
use PhlyRestfully\View\RestfulJsonRenderer;
use PHPUnit_Framework_TestCase as TestCase;
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
    public function setUp()
    {
        $this->setUpRenderer();
        $this->setUpController();
    }

    public function setUpHelpers()
    {
        if (isset($this->helpers)) {
            return;
        }
        $this->setupRouter();

        $urlHelper = new UrlHelper();
        $urlHelper->setRouter($this->router);

        $serverUrlHelper = new ServerUrlHelper();
        $serverUrlHelper->setScheme('http');
        $serverUrlHelper->setHost('restlog');

        $this->linksHelper = $linksHelper = new HalLinks();
        $linksHelper->setUrlHelper($urlHelper);
        $linksHelper->setServerUrlHelper($serverUrlHelper);

        $this->helpers = $helpers = new HelperPluginManager();
        $helpers->setService('url', $urlHelper);
        $helpers->setService('serverUrl', $serverUrlHelper);
        $helpers->setService('halLinks', $linksHelper);
    }

    public function setUpRenderer()
    {
        $this->setupHelpers();
        $this->renderer = $renderer = new RestfulJsonRenderer();
        $renderer->setHelperPluginManager($this->helpers);
    }

    public function setUpRouter()
    {
        if (isset($this->router)) {
            return;
        }

        $this->setUpRequest();

        $routes = array(
            'rest-log' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/v1.0.0/rest-log[/][:id]',
                    'defaults' => array(
                        'controller' => 'RestLog\ApiController'
                    ),
                ),
            ),
        );


        $this->router = $router = new TreeRouteStack();
        $router->addRoutes($routes);

        $matches = $router->match($this->request);
        if (!$matches instanceof RouteMatch) {
            $this->fail('Failed to route!');
        }

        $this->matches = $matches;
    }

    public function setUpCollection()
    {
        $collection = array();
        for ($i = 1; $i <= 10; $i += 1) {
            $collection[] = (object) array(
                'id'   => $i,
                'name' => "$i of 10",
            );
        }

        $collection = new Paginator(new ArrayPaginator($collection));

        return $collection;
    }

    public function setUpListeners()
    {
/*        if (isset($this->listeners)) {
            return;
        }

        $services = $this->getServiceManager();
        $this->listeners = new RestLogResourceListener($services->get('RestLog\Listener\RestLogResourceListener') );*/
    }

    public function setUpController()
    {
        $this->setUpRouter();
        $this->setUpListeners();

        $resource = new Resource();
        $events   = $resource->getEventManager();
        //$events->attach($this->listeners);

        $controller = $this->controller = new ResourceController('Api\ResourceController');
        $controller->setResource($resource);
        $controller->setIdentifierName('id');
        $controller->setPageSize(3);
        $controller->setRoute('rest-log');
        $controller->setEvent($this->getEvent());


        $plugins = new ControllerPluginManager();
        $plugins->setService('HalLinks', $this->linksHelper);
        $controller->setPluginManager($plugins);
    }

    public function setUpRequest()
    {
        if (isset($this->request)) {
            return;
        }

        $uri = Uri\UriFactory::factory('http://restlog/api/v1.0.0/rest-log/?page=2');

        $request = $this->request = new Request();
        $request->setQuery(new Parameters(array(
            'page'  => 2
        )));
        $request->setUri($uri);
        $headers = $request->getHeaders();
        $headers->addHeaderLine('Accept', 'application/json');
        $headers->addHeaderLine('Content-Type', 'application/json');
    }

    public function setUpResponse()
    {
        if (isset($this->response)) {
            return;
        }
        $this->response = new Response();
    }

    public function getEvent()
    {
        $this->setUpResponse();
        $event = new MvcEvent();
        $event->setRequest($this->request);
        $event->setResponse($this->response);
        $event->setRouter($this->router);
        $event->setRouteMatch($this->matches);
        return $event;
    }

/*    public function testCollectionLinksIncludeFullQueryString()
    {


        $result = $this->controller->dispatch($this->request);
        $this->assertInstanceOf('PhlyRestfully\View\RestfulJsonModel', $result);

        $json = $this->renderer->render($result);
        $payload = json_decode($json, true);
        $this->assertArrayHasKey('_links', $payload);
        $links = $payload['_links'];
        foreach ($links as $name => $link) {
            $this->assertArrayHasKey('href', $link);
            if ('first' !== $name) {
                $this->assertContains('page=', $link['href'], "Link $name ('{$link['href']}') is missing page query param");
            }
            $this->assertContains('query=foo', $link['href'], "Link $name ('{$link['href']}') is missing query query param");
        }
    }*/

    public function getServiceManager()
    {
        $controllers = new ControllerManager();
        $controllers->addAbstractFactory('PhlyRestfully\Factory\ResourceControllerFactory');

        $services    = new ServiceManager();
        $services->setService('Zend\ServiceManager\ServiceLocatorInterface', $services);
        $services->setService('ControllerLoader', $controllers);
        $services->setService('RsRestapicallhistoryDao', $this->getMock('RestLog\DAO\impl\RsRestapicallhistoryDaoImpl') );
        $services->setService('Config', array(
            'phlyrestfully' => array(
                'resources' => array(
                    'RestLog\ApiController' => array(
                        'identifier' => 'RestLog',
                        'listener' => 'RestLog\Listener\RestLogResourceListener2',
                        'resource_identifiers' => array('RestLogResource'),
                        'collection_http_options' => array('get', 'post'),
                        'collection_name' => 'rest-log',
                        'page_size' => 2,
                        /*                'resource_http_options' => array('get', ''),*/
                        'route_name' => 'rest-log',
                    ),
                ),
            ),
        ));
        $services->setInvokableClass('SharedEventManager', 'Zend\EventManager\SharedEventManager');
        $services->setInvokableClass('CollectionIntegrationListener', 'PhlyRestfullyTest\TestAsset\CollectionIntegrationListener');

        $services->setFactory('EventManager', 'Zend\Mvc\Service\EventManagerFactory');
        $services->setFactory('ControllerPluginManager', 'Zend\Mvc\Service\ControllerPluginManagerFactory');
        $services->setShared('EventManager', false);



        $collection = $this->setUpCollection();
/*        $services->addInitializer(function ($instance, $services) use ($collection) {
            if (!$instance instanceof TestAsset\CollectionIntegrationListener) {
                return;
            }
            $instance->setCollection($collection);
        });*/

        $controllers->setServiceLocator($services);

        $plugins = $services->get('ControllerPluginManager');
        $plugins->setService('HalLinks', $this->linksHelper);

        return $services;
    }

    public function testFactoryEnabledListenerCreatesQueryStringWhitelist()
    {
        $services = $this->getServiceManager();
        $controller = $services->get('ControllerLoader')->get('RestLog\ApiController');
        $controller->setEvent($this->getEvent());

        $result = $controller->dispatch($this->request);
        $this->assertInstanceOf('PhlyRestfully\View\RestfulJsonModel', $result);

        $json = $this->renderer->render($result);
        $payload = json_decode($json, true);
        $this->assertArrayHasKey('_links', $payload);
        $links = $payload['_links'];
        foreach ($links as $name => $link) {
            $this->assertArrayHasKey('href', $link);
            if ('first' !== $name) {
                $this->assertContains('page=', $link['href'], "Link $name ('{$link['href']}') is missing page query param");
            }
            $this->assertContains('query=foo', $link['href'], "Link $name ('{$link['href']}') is missing query query param");
        }
    }


    



}
