<?php

/*
 * This file is part of the Dacorp Extra Bundle
 *
 * (c) Jean-Christophe Meillaud
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Dacorp\ExtraBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Ajax controller.
 *
 * @author jmeyo Jean-Christophe Meillaud
 */
class AjaxController extends Controller
{
    public function uploadAction(Request $request)
    {
        $editId = $request->get('editId');
        // @TODO, check its a editId of the form defined in FileManager
        $this->get('dacorp.file_uploader')->handleFileUpload(array('folder' => 'tmp/attachments/' . $editId));
    }

    public function rateAction(Request $request)
    {
        $this->get('dacorp.stats_manager')->updateStat($request->get('id'), 'rate', $request->get('score'));
        return $this->returnJsonResponse('success', $this->get('translator')->trans('flash.message.rating-done'));
    }

    public function voteAction(Request $request)
    {
        $this->get('dacorp.stats_manager')->updateStat($request->get('id'), $request>get('type'));
        return $this->returnJsonResponse('success', $this->get('translator')->trans('flash.message.voting-done'));
    }


    protected function returnJsonResponse($status, $flashmsg, $content = null)
    {
        $response = new Response(json_encode(array('error' => $status, 'flashmsg' => $flashmsg, 'content' => json_encode($content))));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
