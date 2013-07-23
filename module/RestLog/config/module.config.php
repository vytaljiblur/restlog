<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(

            'all_items' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'RestLog\Component\Index',
                        'action' => 'index',
                    ),
                ),
            ),

            'add' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/add',
                    'defaults' => array(
                        'controller' => 'RestLog\Component\Index',
                        'action' => 'item',
                    ),
                ),
            ),

            'edit' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/edit',
                    'defaults' => array(
                        'controller' => 'RestLog\Component\Index',
                        'action' => 'item',
                    ),
                ),
            ),

            'remove' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/remove',
                    'defaults' => array(
                        'controller' => 'RestLog\Component\Index',
                        'action' => 'remove',
                    ),
                ),
            ),

            'rest-log' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/v1.0.0/rest-log[/][:id]',
                    'defaults' => array(
                        'controller' => 'RestLog\ApiController'
                    ),
                ),
            ),
/*            'rest-log' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/api/v1.0.0/rest-log',
                    'controller' => 'RestLog\ApiController', // for the web UI
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'api' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:id]',
                            'controller' => 'RestLog\ApiController',
                        ),
                    ),
                ),
            ),*/


        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        )
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'RestLog\Component\Index' => 'RestLog\Component\IndexController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'restlog/index/index' => __DIR__ . '/../view/restlog/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),


    'doctrine' => array(
        'driver' => array(
            'DB_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/RestLog/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'RestLog\Entity' => 'DB_driver'
                ),
            ),
        ),
    ),

    'phlyrestfully' => array(
        'resources' => array(
            'RestLog\ApiController' => array(
                'identifier' => 'RestLog',
                'listener' => 'RestLog\Listener\RestLogResourceListener',
                'resource_identifiers' => array('RestLogResource'),
                'collection_http_options' => array('get', 'post'),
                'collection_name' => 'rest-log',
                'page_size' => 2,
/*                'resource_http_options' => array('get', ''),*/
                'route_name' => 'rest-log',
            ),
        ),
    ),


);

