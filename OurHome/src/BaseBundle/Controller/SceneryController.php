<?php

namespace BaseBundle\Controller;

use BaseBundle\Entity\Scenery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Scenery controller.
 *
 * @Route("scenery")
 */
class SceneryController extends Controller
{
    /**
     * Lists all scenery entities.
     *
     * @Route("/", name="scenery_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sceneries = $em->getRepository('BaseBundle:Scenery')->findAll();

        return $this->render('scenery/index.html.twig', array(
            'sceneries' => $sceneries,
        ));
    }

    /**
     * Creates a new scenery entity.
     *
     * @Route("/new", name="scenery_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $scenery = new Scenery();
        $form = $this->createForm('BaseBundle\Form\SceneryType', $scenery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($scenery);
            $em->flush();

            return $this->redirectToRoute('scenery_show', array('id' => $scenery->getId()));
        }

        return $this->render('scenery/new.html.twig', array(
            'scenery' => $scenery,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a scenery entity.
     *
     * @Route("/{id}", name="scenery_show")
     * @Method("GET")
     */
    public function showAction(Scenery $scenery)
    {
        $deleteForm = $this->createDeleteForm($scenery);

        return $this->render('scenery/show.html.twig', array(
            'scenery' => $scenery,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing scenery entity.
     *
     * @Route("/{id}/edit", name="scenery_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Scenery $scenery)
    {
        $deleteForm = $this->createDeleteForm($scenery);
        $editForm = $this->createForm('BaseBundle\Form\SceneryType', $scenery);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('scenery_edit', array('id' => $scenery->getId()));
        }

        return $this->render('scenery/edit.html.twig', array(
            'scenery' => $scenery,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a scenery entity.
     *
     * @Route("/{id}", name="scenery_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Scenery $scenery)
    {
        $form = $this->createDeleteForm($scenery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($scenery);
            $em->flush();
        }

        return $this->redirectToRoute('scenery_index');
    }

    /**
     * Creates a form to delete a scenery entity.
     *
     * @param Scenery $scenery The scenery entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Scenery $scenery)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('scenery_delete', array('id' => $scenery->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
