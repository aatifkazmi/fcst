<?php
namespace User\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use User\Controller\CoursesController;
use Zend\View\Renderer\RendererInterface;

/**
 * This is the factory for CoursesController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class CoursesControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $authService = $container->get(\Zend\Authentication\AuthenticationService::class);

        $tcpdf = $container->get(\TCPDF::class);
        $renderer = $container->get(RendererInterface::class);
        // Instantiate the controller and inject dependencies
        return new CoursesController($entityManager,$authService,$tcpdf, $renderer);
    }
}