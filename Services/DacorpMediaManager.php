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

use Dacorp\ExtraBundle\Entity\DacorpMedia;
use Dacorp\ExtraBundle\Entity\Item;
use Dacorp\ExtraBundle\Entity\User;
use Dacorp\ExtraBundle\Services\FileManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;

class DacorpMediaManager
{

    // Some const for flitering medias
    const PARTNER_MEDIA_ID = 222;

    /**
     * Holds the Doctrine entity manager for database interaction
     * @var EntityManager
     */
    protected $em;
    /**
     * Container
     * @var type
     */
    protected $container;
    /**
     * User
     * @var User
     */
    protected $user;
    /**
     * FileManager
     * @var FileManager
     */
    protected $fileManager;
    /**
     * @var Logger
     */
    protected $logger;
    /**
     * editId
     */
    protected $editId;
    /**
     * existingFiles
     */
    protected $existingFiles;
    /**
     * existingFiles
     */
    protected $mediaClass;

    public function __construct(EntityManager $em, Container $container, FileManager $fileManager, $mediaClass)
    {
        $this->em = $em;
        $this->container = $container;
        $this->fileManager = $fileManager;
        $this->mediaClass = $mediaClass;
        if ($this->container->get('security.context')->getToken()!=null) {
            $this->user = $this->container->get('security.context')->getToken()->getUser();
        }
        $this->logger = $this->container->get('logger');
    }

    public function setupDacorpMediaManager($userId, $mediaId)
    {
        //$type=($salt)?$salt.$type:$type;
        $editId = $this->fileManager->getEditId($userId, $mediaId);
        $existingFiles = $this->fileManager->getExistingFiles($editId);
        return array(
            'editId' => $editId,
            'existingFiles' => $existingFiles);
    }

    public function feedFiles($editId)
    {
        $this->fileManager->feedFiles($editId);
    }

    /**
     * For Entity with OneToOne relation to media
     * @param $parentContent
     * @param $editId
     * @param $itemId
     * @param $userId
     * @param array $newAttachmentList
     */
    public function manageSimpleDacorpMediaForPicture($parentContent, $editId, $itemId, array $attachmentList, $userId)
    {
        $newEditId = $this->fileManager->generateItemId($itemId, $userId);
        //just take the only attachment, which should be the first
//        echo  " editId, itemId, newEditId:".$editId.','.$itemId.','.$newEditId;
        $this->manageSimpleDacorpMedia($parentContent, $editId, $newEditId, $attachmentList[0], 'picture');
    }

    public function manageSimpleDacorpMediaForUser(User $user, $editId, $itemId, array $newAttachmentList = array())
    {
        $newEditId = $this->fileManager->generateItemId($itemId, $user->getId());
        $this->manageSimpleDacorpMedia($user, $editId, $newEditId, $newAttachmentList[0], 'avatar');
    }

    public function manageSimpleDacorpMedias($parentContent, $editId, $newEditId, $filenames, $parentType = 'picture')
    {
        foreach ($filenames as $filename) {
            $this->manageSimpleDacorpMedia($parentContent, $editId, $newEditId, $filename, $parentType);
        }
    }

    public function linkMediaToParent($parentContent, $media, $parentType = 'picture')
    {
        switch ($parentType) {
            case 'picture':
                $parentContent->setMedia($media);
                $parentContent->setPicHash($this->daEncode($media->getMediaId()));
                break;
            case 'avatar':
                $parentContent->setCurrentAvatar($media);
                break;
            default:
                break;
        }
    }

    /**
     * manageDacorpMediasForContent : manage (create and remove) dacorpmedias for a $parentContent of type Content
     * @param mixed $parentContent
     * @param type $editId
     * @param array $newAttachmentList
     */
    public function manageSimpleDacorpMedia($parentContent, $editId, $newEditId, $filename, $parentType = 'picture')
    {
        $this->logger->info('Managing DacorpMedia');
        echo $filename;
        if ($filename != null) {
            /* @var $media DacorpMedia */
            $this->em->flush();

            $this->logger->info('add media:' . $filename);

            $dacorpMedia = new $this->mediaClass();
            if ($this->container->get('security.context')->getToken()!=null && $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
                $dacorpMedia->setUser($this->user);
            }
            $mediaKey = $this->fileManager->getMediaKey($newEditId);
            //store information about the media
            $dacorpMedia->setOriginalFilename($filename);
            $dacorpMedia->setFilename($filename);
            $dacorpMedia->setUrl($mediaKey);
            $this->em->persist($dacorpMedia);
            $this->em->flush();

            $this->linkMediaToParent($parentContent, $dacorpMedia, $parentType);

            $this->em->flush();
        } else {
            exit;
        }
        $this->fileManager->saveFiles($editId, $newEditId);
    }


    protected function daEncode($data)
    {
        return substr(base64_encode(pack("l", (16807 * $data) % 2147483647)), 0, 6);
    }

}

