<?php

namespace Frontend\AndroidBundle\Controller;

use Frontend\AndroidBundle\Entity\Content;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get all contents",
     *  filters={
     *      {"name"="a-filter", "dataType"="integer"},
     *      {"name"="another-filter", "dataType"="string", "pattern"="(foo|bar) ASC|DESC"}
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      403="Returned when the user is not authorized to say hello",
     *      404={
     *        "Returned when the user is not found",
     *        "Returned when something else is not found"
     *      }
     *  }
     * )
     *
     * @return array
     */
    public function getContentsAction()
    {
        $contents = $this->get("content.api")->showApiAllContent();

        return array("contents" => $contents);
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get content by ID",
     *  statusCodes={
     *      200="Returned when successful",
     *      403="Returned when the user is not authorized to say hello",
     *      404={
     *        "Returned when the user is not found",
     *        "Returned when something else is not found"
     *      }
     *  }
     * )
     *
     * @param $id
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getContentAction($id)
    {
        $content = $this->get("content.api")->showApiContent($id);

//        if (!$content instanceof Content) {
//            throw new NotFoundHttpException('Content not found');
//        }

        return array('content' => $content);
    }
}
