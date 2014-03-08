<?php
namespace Slender\Module\Twig\Factory;

use Slender\Core\DependencyInjector\DependencyInjector;
use Slender\Interfaces\FactoryInterface;

/**
 * Class TwigFactory
 *
 * @package Slender\Module\Twig\Factory
 */
class TwigFactory implements FactoryInterface
{

    /**
     * @param \Slender\App $app
     * @return \Twig_Environment
     */
    public function create(\Slender\App $app)
    {
        /** @var DependencyInjector $di */
        $di = $app['dependency-injector'];

        // App settings
        $settings = $app['settings'];

        // Prepare Twig config
        $conf = array_merge(array(
            'debug' => $settings['debug'],
                'charset' => 'utf-8',
                'cache' => false,
                'strict_variables' => false,

        ),$app['settings']['twig']['environment']);

        // Prepare the template loader
        $loader = $app['twig.loader'] = new \Twig_Loader_Filesystem();
        $loader->setPaths($app['settings']['view-paths']);

        // Create twig instance
        $twig = new \Twig_Environment($loader,$conf);


        // If in debug mode, add in the Twig debug extension
        if($app['settings']['debug']){
            $twig->addExtension( new \Twig_Extension_Debug );
        }

        // Add in any other registered extensions
        $extensions = $app['settings']['twig']['extensions'];
        foreach($extensions as $class){
            $ext = $di->create($class);
            $twig->addExtension($ext);
        }

        return $twig;
    }
}
