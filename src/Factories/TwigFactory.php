<?php
namespace Slender\Module\Twig\Factories;

use Slender\Interfaces\FactoryInterface;

class TwigFactory implements FactoryInterface
{

    public function create(\Slender\App $app)
    {

        // Prepare the template loader
        $loader = new \Twig_Loader_Filesystem();
        $viewPaths = $app['settings']['view-paths'];
        dump($viewPaths);
//        $loader->setPaths()

        // Create twig instance
        $twig = new \Twig_Environment(

        );
    }
}
