<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use AppBundle\Entity\Groups;
use AppBundle\Form\GroupsType;

class GroupsController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Get("/groups")
     */
    public function getGroupssAction(Request $request)
    {
        $groupss = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Groups')
            ->findAll();
        /* @var $groupss Groups[] */

        return $groupss;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/groupss/{groups_id}")
     */
    public function getGroupsAction(Request $request)
    {
        $groups = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Groups')
            ->find($request->get('groups_id'));
        /* @var $groups Groups */

        if (empty($groups)) {
            return new JsonResponse(['message' => 'Groups not found'], Response::HTTP_NOT_FOUND);
        }

        return $groups;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/groupss")
     */
    public function postGroupssAction(Request $request)
    {
        $groups = new Groups();
        $form = $this->createForm(GroupsType::class, $groups);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($groups);
            $em->flush();
            return $groups;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View()
     * @Rest\Put("/groupss/{id}")
     */
    public function updateGroupsAction(Request $request)
    {
        $groups = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Groups')
            ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $groups Groups */

        if (empty($groups)) {
            return new JsonResponse(['message' => 'Groups not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(GroupsType::class, $groups);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            // l'entité vient de la base, donc le merge n'est pas nécessaire.
            // il est utilisé juste par soucis de clarté
            $em->merge($groups);
            $em->flush();
            return $groups;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View()
     * @Rest\Patch("/groupss/{id}")
     */
    public function patchGroupsAction(Request $request)
    {
        $groups = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Groups')
            ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $groups Groups */

        if (empty($groups)) {
            return new JsonResponse(['message' => 'Groups not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(GroupsType::class, $groups);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            // l'entité vient de la base, donc le merge n'est pas nécessaire.
            // il est utilisé juste par soucis de clarté
            $em->merge($groups);
            $em->flush();
            return $groups;
        } else {
            return $form;
        }
    }



}