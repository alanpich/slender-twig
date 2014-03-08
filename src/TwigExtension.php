<?php
namespace Slender\Module\Twig;

use Slender\Core\DependencyInjector\Annotation as Slender;
use Slim\Interfaces\Http\RequestInterface;

/**
 * Class TwigExtension
 *
 * @package Slender\Module\Twig
 */
class TwigExtension extends \Twig_Extension
{
    /**
     * @var \Twig_Environment
     * @Slender\Inject
     */
    protected $twig;

    /**
     * @Slender\Inject
     */
    protected $request;

    /**
     * @Slender\Inject
     */
    protected $router;

    /**
     * @return string
     */
    public function getName()
    {
        return 'slender-twig';
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('urlFor', array($this, 'urlFor')),
            new \Twig_SimpleFunction('url', array($this, 'urlFor')),
            new \Twig_SimpleFunction('baseUrl', array($this, 'base')),
            new \Twig_SimpleFunction('siteUrl', array($this, 'site')),
        );
    }

    /**
     * @param        $name
     * @param array  $params
     * @param string $appName
     * @return string
     */
    public function urlFor($name, $params = array(), $appName = 'default')
    {
        return $this->request->getScriptName() . $this->router->urlFor($name, $params);
    }

    /**
     * @param        $url
     * @param bool   $withUri
     * @param string $appName
     * @return string
     */
    public function site($url, $withUri = true, $appName = 'default')
    {
        return $this->base($withUri, $appName) . '/' . ltrim($url, '/');
    }

    /**
     * @param bool   $withUri
     * @param string $appName
     * @return string
     */
    public function base($withUri = true, $appName = 'default')
    {
        $uri = $this->request->getUrl();

        if ($withUri) {
            $uri .= $this->request->getRootUri();
        }

        return $uri;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $router
     */
    public function setRouter($router)
    {
        $this->router = $router;
    }

    /**
     * @return mixed
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @param \Twig_Environment $twig
     */
    public function setTwig($twig)
    {
        $this->twig = $twig;
    }

    /**
     * @return \Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }




}
