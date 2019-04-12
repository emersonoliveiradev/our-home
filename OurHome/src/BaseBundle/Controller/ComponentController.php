<?php

namespace BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BaseBundle\Entity\Component;
use BaseBundle\Form\ComponentType;

/**
 * Component controller.
 *
 * @Route("/component")
 */
class ComponentController extends Controller
{
    /**
     * Lists all Component entities.
     *
     * @Route("/", name="component_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $components = $em->getRepository('BaseBundle:Component')->findAll();

        return $this->render('component/index.html.twig', array(
            'components' => $components,
        ));
    }

    /**
     * Creates a new Component entity.
     *
     * @Route("/new", name="component_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $component = new Component();
        $form = $this->createForm('BaseBundle\Form\ComponentType', $component);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($component);
            $em->flush();

            return $this->redirectToRoute('component_show', array('id' => $component->getId()));
        }

        return $this->render('component/new.html.twig', array(
            'component' => $component,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Component entity.
     *
     * @Route("/{id}", name="component_show")
     * @Method("GET")
     */
    public function showAction(Component $component)
    {
        $deleteForm = $this->createDeleteForm($component);

        return $this->render('component/show.html.twig', array(
            'component' => $component,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Component entity.
     *
     * @Route("/{id}/edit", name="component_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Component $component)
    {
        $deleteForm = $this->createDeleteForm($component);
        $editForm = $this->createForm('BaseBundle\Form\ComponentType', $component);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($component);
            $em->flush();

            return $this->redirectToRoute('component_edit', array('id' => $component->getId()));
        }

        return $this->render('component/edit.html.twig', array(
            'component' => $component,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Component entity.
     *
     * @Route("/{id}", name="component_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Component $component)
    {
        $form = $this->createDeleteForm($component);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($component);
            $em->flush();
        }

        return $this->redirectToRoute('component_index');
    }

    /**
     * Creates a form to delete a Component entity.
     *
     * @param Component $component The Component entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Component $component)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('component_delete', array('id' => $component->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
