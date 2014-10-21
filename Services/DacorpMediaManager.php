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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\Common\Collections\Criteria;

class DacorpMediaManager
{

    // Some const for flitering medias
    const DEFAULT_MEDIA_ID = 222;

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
     * mediaClass
     */
    protected $mediaClass;

    public function __construct(EntityManager $em, Container $container, FileManager $fileManager, $mediaClass)
    {
        $this->em = $em;
        $this->container = $container;
        $this->fileManager = $fileManager;
        $this->mediaClass = $mediaClass;
        if ($this->container->get('security.context')->getToken() != null) {
            $this->user = $this->container->get('security.context')->getToken()->getUser();
        }
        $this->logger = $this->container->get('logger');
    }

    public function setupDacorpMediaManager($seedId, $mediaId)
    {
        //$type=($salt)?$salt.$type:$type;
        $editId = $this->fileManager->getEditId($seedId, $mediaId);
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
     * @param $parentContent
     * @param $editId
     * @param $newEditId
     * @param $filenames
     * @param string $parentType
     * @deprecated d
     */
    public function manageSimpleDacorpMedias($parentContent, $editId, $newEditId, $filenames, $parentType = 'picture')
    {
        foreach ($filenames as $filename) {
            $this->manageSimpleDacorpMedia($parentContent, $editId, $newEditId, $filename, $parentType);
        }
    }

    public function linkMediaToParent($parentContent, $media, $parentType)
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
     * @deprecated to be remove in next iterations for some projects
     */
    public function manageSimpleDacorpMedia($parentContent, $editId, $newEditId, $filename, $parentType = 'picture')
    {
        echo $editId . ", " . $newEditId;
        $this->logger->info('Managing DacorpMedia');
        if ($filename != null) {
            /* @var $media DacorpMedia */
            $this->em->flush();

            $this->logger->info('add media:' . $filename);

            $dacorpMedia = new $this->mediaClass();
            if ($this->container->get('security.context')->getToken() != null && $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
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

    /**
     * For Entity with OneToOne relation to media
     * @param $parentContent
     * @param $editId
     * @param $itemId
     * @param $userId
     * @param array $newAttachmentList
     */
    public function manageSimpleMediaFor($parentContent, $editId, $itemId, $oneFileName, $userId, $parentType)
    {
        $newEditId = $this->fileManager->generateItemId($userId, $itemId);
        //just take the only attachment, which should be the first
        $this->manageSimpleMedia($parentContent, $editId, $newEditId, $oneFileName, $parentType);
    }

    public function manageSimpleMedia($parentContent, $editId, $newEditId, $oneFileName, $parentType)
    {
        $this->logger->info('Managing Media');

        /* @var $existingMedia DacorpMedia */
        $existingMedia = $this->getMediaFor($parentContent, $parentType);
        if ($existingMedia != null) {
            if ($existingMedia->getFilename() != $oneFileName) {
                //we change it del + add
                $this->deleteMedia($parentContent, $existingMedia, $parentType);
                $newMedia = $this->addMedia($parentContent, $newEditId, $oneFileName, $parentType);
            } else {
                //image is same, do nothing
            }
        } else {
            $newMedia = $this->addMedia($parentContent, $newEditId, $oneFileName, $parentType);
        }

        // ask filemanager to delete deleted files
        $this->fileManager->saveFiles($editId, $newEditId);

    }

    public function manageMultipleMediaFor($parentContent, $editId, $itemId, $oneFileName, $userId, $parentType)
    {
        $newEditId = $this->fileManager->generateItemId($userId, $itemId);
        //just take the only attachment, which should be the first
//        echo  " editId, itemId, newEditId:".$editId.','.$itemId.','.$newEditId;
        $this->manageMultipleMedia($parentContent, $editId, $newEditId, $oneFileName, $parentType);
    }

    public function manageMultipleMedia($parentContent, $editId, $newEditId, array $listOfFileNames, $parentType)
    {
        $this->logger->info('Managing Multiple Medias');

        /* @var $parentContent User */
        $listOfExistingMedia = $this->getMediaFor($parentContent, $parentType);

//        if ($listOfExistingMedia===null) die;
        foreach ($listOfFileNames as $fileName) {
            echo $fileName;
            if ($listOfExistingMedia != null) {
                $criteria = Criteria::create()
                    ->where(Criteria::expr()->eq("originalFilename", $fileName));
                $existingMedia = $listOfExistingMedia->matching($criteria);
                if (!count($existingMedia)) {
                    //we add it
                    $newMedia = $this->addMedia($parentContent, $newEditId, $fileName, $parentType);
                }
            } else {
                echo "<p>we add " . $fileName . "</p>";
                $this->addMedia($parentContent, $newEditId, $fileName, $parentType);
            }
        }
        // remove deleted Media
        $arrayOfExistingMedia = array();
        if ($listOfExistingMedia != null) {
            foreach ($listOfExistingMedia as $existingMedia) {
                /* @var $existingMedia DacorpMedia */
                $arrayOfExistingMedia[] = $existingMedia->getFilename();
            }
        }

        print_r($arrayOfExistingMedia);
        echo "number of listOfExistingMedia:" . count($arrayOfExistingMedia);

        print_r($listOfFileNames);
        echo "number of listOfFileNames:" . count($listOfFileNames);

        foreach (array_diff($arrayOfExistingMedia, $listOfFileNames) as $fileToDelete) {
            $this->deleteMedia($parentContent, $fileToDelete, $parentType);
        }
        // delete deleted files
        $this->fileManager->saveFiles($editId, $newEditId);

    }

    /**
     * Function to be overridden
     * @param $parentContent
     * @return mixed
     */

    public function getMediaFor($parentContent, $mediaType)
    {
        switch ($mediaType) {
            case 'DacorpMedia':
                /* @var $parentContent User */
                $parentContent->getCurrentAvatar();

                break;
        }
    }

    public function addMedia($parentContent, $newEditId, $fileName, $parentType = 'avatar')
    {

        //$className = $this->container->getParameter('dacorp_media_class') . $mediaType;
        /* @var $newMedia DacorpMedia */
        $newMedia = new $this->mediaClass();
        //$newMedia->
        $this->logger->info('add media:' . $fileName);


        $mediaKey = $this->fileManager->getMediaKey($newEditId);

        //store information about the media
        $newMedia->setOriginalFilename($fileName);
        $newMedia->setFilename($fileName);
        $newMedia->setUrl($mediaKey);
        $this->em->persist($newMedia);
        $this->em->flush();
        $this->linkMediaToParent($parentContent, $newMedia, $parentType);

        $this->em->flush();
        return $newMedia;
    }


    public function deleteMedia($parentContent, $fileName, $mediaType)
    {
        $media = $this->em->getRepository('DacorpExtraBundle:' . $mediaType)->findOneBy(array('filename' => $fileName));
        switch ($mediaType) {
            case 'DacorpMedia':
                /* @var $parentContent User */
                $parentContent->removeImage($media);
                break;
        }
        $this->em->remove($media);
        $this->em->flush();
    }
}

