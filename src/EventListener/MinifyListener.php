<?php 
namespace OSW3\Utils\EventListener;

// use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use OSW3\UtilsBundle\DependencyInjection\Configuration;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

class MinifyListener
{
    /**
     * Container Interface
     *
     * @var ContainerInterface
     */
    protected $container;

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

    public function __construct(ContainerInterface $container, KernelInterface $kernel)
    {
        $this->container = $container;
        $this->environment = $kernel->getEnvironment();
        
        // $this->config = $this->container->getParameter(Configuration::NAME)['minify'];
    }

    #[AsEventListener]
    public function proceed(ResponseEvent $event): void
    {
        // dd($this->config['if']);
        // if ($this->environment !== $this->config['if']) return;
        
        $content = preg_replace(
            array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),
            array('',' '),
            str_replace(array("\n","\r","\t"),'',
            $event->getResponse()->getContent())
        );

        $event->setResponse(new Response($content));
    }
}
