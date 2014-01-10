<?php

/*
 * This file is part of the Dacorp Extra Bundle
 *
 * (c) Jean-Christophe Meillaud
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Dacorp\ExtraBundle\Twig;

use Twig_Extension;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Twig_Filter_Method;

class DacorpMediaExtension extends Twig_Extension
{

    /**
     * Logger
     * @var type 
     */
    protected $logger;

    /**
     * Container
     * @var type 
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->logger = $this->container->get('logger');
    }

    public function getFilters()
    {
        return array(
            'generateMediaUrl' => new Twig_Filter_Method($this, 'mediaFilter'),
            'getAttachmentImage' => new Twig_Filter_Method($this, 'getAttachmentImageFilter'),
        );
    }

    public function mediaFilter($mediaKey, $filename, $size = 'thumbnails')
    {

        $format = trim(strtolower(substr($filename, strrpos($filename, '.') + 1)));
        if ($size != 'originals') {
            switch ($format) {
                case 'pdf':
                case 'xls':
                case 'doc':
                    $pathFile = "/bundles/dacorpcore/images/default-attachments/" . $format . ".png";
                    break;
                case 'png':
                case 'jpg':
                case 'jpeg':
                case 'gif':
                    $pathFile = '/uploads/attachments/' . $mediaKey . '/' . $size . '/' . $filename;
                    break;
                default:
                    return 'html';
                    break;
            }
        } else {
            $pathFile = '/uploads/attachments/' . $mediaKey . '/' . $size . '/' . $filename;
        }
        return $this->container->get('request')->getBasePath(). $pathFile;
    }

    public function getName()
    {
        return 'dacorpmedia_extension';
    }

}