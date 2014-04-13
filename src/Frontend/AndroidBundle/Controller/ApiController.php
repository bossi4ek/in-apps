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
        $contents = $this->get("frontend.android.content.api")->showApiAllContent();

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
     * @param integer  $id      the content ID
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getContentAction($id)
    {
        $content = $this->get("content.api")->showApiContent($id);

        return array('content' => $content);
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get content by category",
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
     * @param string  $slug      the category slug
     * @return array
     */
    public function getContentsByCategoryAction($slug)
    {
        $contents = $this->get("content.api")->showApiContentByCategory($slug);

        return array("contents" => $contents);
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get content by developer",
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
     * @param string  $slug      the developer slug
     * @return array
     */
    public function getContentsByDeveloperAction($slug)
    {
        $contents = $this->get("content.api")->showApiContentByDeveloper($slug);

        return array("contents" => $contents);
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get content top",
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
    public function getTopContentAction()
    {
        $contents = $this->get("content.api")->showApiTopContent();

        return array("contents" => $contents);
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get content new",
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
    public function getNewContentAction()
    {
        $contents = $this->get("content.api")->showApiNewContent();

        return array("contents" => $contents);
    }


}
