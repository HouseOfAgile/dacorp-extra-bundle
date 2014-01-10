<?php

/*
 * This file is part of the Dacorp Extra Bundle
 *
 * (c) Jean-Christophe Meillaud
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Dacorp\ExtraBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\HttpFoundation\Session\Session;

class FileManager
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
    private $fileUploader;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->logger = $this->container->get('logger');
        $this->fileUploader = $this->container->get('punk_ave.file_uploader');
    }

    public function getEditId($userId, $mediaId)
    {
        $editId = $this->container->get('request')->get('editId');
        if (!preg_match('/^\d+$/', $editId)) {
            $editId = $this->generateItemId($userId,$mediaId);
        }
        return $editId;
    }

    public function feedFiles($editId)
    {
        $this->fileUploader->syncFiles(
            array('from_folder' => 'attachments/' . $this->getMediaKey($editId),
                'to_folder' => 'tmp/attachments/' . $editId,
                'create_to_folder' => true));
    }

    public function saveFiles($editId, $newEditId)
    {
        $this->fileUploader->syncFiles(
            array('from_folder' => 'tmp/attachments/' . $editId,
                'to_folder' => 'attachments/' . $this->getMediaKey($newEditId),
                'remove_from_folder' => false,
                'create_to_folder' => true));
        //$this->fileUploader->removeFiles(array('folder' => 'tmp/attachments/' . $editId));
    }

    public function generateItemId($id, $mediaId)
    {
        return sha1($id . $mediaId);
    }

    public function generateMediaKey($userId, $mediaId)
    {
        $editId = $this->generateItemId($userId ,$mediaId);
        return substr($editId, 2, 3) . '/' . substr($editId, 6, 3) . '/' . substr($editId, 12, 3);
    }

    public function getMediaKey($editId)
    {
        return substr($editId, 2, 3) . '/' . substr($editId, 6, 3) . '/' . substr($editId, 12, 3);
    }

    public function getExistingFiles($editId)
    {
        $existingFiles = $this->fileUploader->getFiles(array('folder' => 'attachments/' . $this->getMediaKey($editId)));
        return $existingFiles;
    }

}