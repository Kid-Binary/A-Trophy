<?php
// src/ATrophy/Bundle/MeatBundle/Twig/AssetExistsExtension.php
namespace ATrophy\Bundle\MeatBundle\Twig;

use Symfony\Component\HttpKernel\KernelInterface;

class AssetExistsExtension extends \Twig_Extension
{
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function getFunctions()
    {
        return array(
            'asset_exists' => new \Twig_Function_Method($this, 'asset_exists'),
        );
    }

    public function asset_exists($path)
    {
        $webRoot = realpath(WEB_DIRECTORY);
        $toCheck = realpath(
            str_replace(['/', '\\'], DIRECTORY_SEPARATOR, "{$webRoot}/{$path}")
        );

        // check if the file exists
        if (!is_file($toCheck))
        {
            return false;
        }

        // check if file is well contained in web/ directory (prevents ../ in paths)
        if (strncmp($webRoot, $toCheck, strlen($webRoot)) !== 0)
        {
            return false;
        }

        return true;
    }

    public function getName()
    {
        return 'asset_exists';
    }
}