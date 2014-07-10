<?php

namespace Dacorp\ExtraBundle\Controller;


use Dacorp\ExtraBundle\Form\Type\DacorpMediaType;
use Dacorp\ExtraBundle\Services\DacorpMediaManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PictureController extends Controller
{

    /**
     * Simple action for form Upload rendering
     * @param Request $request
     * @return array
     * @Template("DacorpExtraBundle:Form:pictureUploadForm.html.twig")
     */
    public function uploadFormAction(Request $request)
    {
        // create task object and form
        $userId = ($this->getUser() != null) ? $this->getUser()->getId() : rand();
        $partner = ($this->getUser() != null) ? $this->getUser()->getPartner() : null;

        /* @var $picture Picture */
        $smDatas = $this->get('dacorp.manager.dacorp_media')->setupDacorpMediaManager($userId, DacorpMediaManager::PARTNER_MEDIA_ID);
        if ($this->getRequest()->getMethod() != 'POST') {
            // $this->get('justmoov.manager.media')->feedFiles($smDatas['editId']);
        }

        $pictureForm = $this->createForm(new DacorpMediaType(), $partner, array('editId' => $smDatas['editId'], 'existingFiles' => json_encode($smDatas['existingFiles'])));

        //Template: JustmoovFrontBundle:Form:pictureUploadForm.html.twig

        return array(
            'pictureFormView' => $pictureForm->createView(),
            'pictureForm' => $pictureForm->createView(),
            'smDatas' => $smDatas
        );
    }

}
