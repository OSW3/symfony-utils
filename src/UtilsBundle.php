<?php 
namespace OSW3\Utils;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use OSW3\Utils\DependencyInjection\Configuration;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class UtilsBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $projectDir = $container->getParameter('kernel.project_dir');


        // Generate the YAML bundle configuration file in the project
        // --
        
        (new Configuration)->generateProjectConfig($projectDir);
    }
}