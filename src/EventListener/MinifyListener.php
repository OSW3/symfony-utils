<?php 
namespace OSW3\Utils\EventListener;

// use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Response;
use OSW3\Utils\DependencyInjection\Configuration;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

class MinifyListener
{

    /**
     * Bundle Configuration
     *
     * @var array
     */
    private array $config;

    /**
     * Kernel Environment
     */
    private $environment;

    public function __construct(
        #[Autowire(service: 'service_container')] 
        private ContainerInterface $container,
        private KernelInterface $kernel
    ){
        $this->environment = $kernel->getEnvironment();
        $this->config = $container->getParameter(Configuration::NAME)['minify'];
    }

    #[AsEventListener]
    public function proceed(ResponseEvent $event): void
    {
        // dd($this->config['env']);
        if ($this->environment !== $this->config['env']) return;
        
        $content = preg_replace(
            array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),
            array('',' '),
            str_replace(array("\n","\r","\t"),'',
            $event->getResponse()->getContent())
        );

        $event->setResponse(new Response($content));
    }
}
