<?php

namespace BaseBundle\Controller;

use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;
use BaseBundle\Entity\Surrounding;
use BaseBundle\Entity\Component;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;


/**
 * Surrounding controller.
 *
 * @Route("surrounding")
 * @Breadcrumb({{ "label" = "Ambientes", "route" = "surrounding_index"}})
 */
class SurroundingController extends Controller
{
    /**
     * Lists all surrounding entities.
     *
     * @Route("/", name="surrounding_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $surroundings = $em->getRepository('BaseBundle:Surrounding')->findBy(array('user'=>$this->getUser()));
        $components = $em->getRepository('BaseBundle:Component')->findBy(array('user'=>$this->getUser()));

        $aux = [];

        #$surroundingName = $components->getSurrounding()->getTitle();
        #echo($surroundingName);

        #$aux = $em->getRepository('BaseBundle:Component')->find($surroundings);
        return $this->render('surrounding/index.html.twig', array(
            'surroundings' => $surroundings,
            'components' => $components,
        ));
    }

    /**
     * Creates a new surrounding entity.
     *
     * @Route("/new", name="surrounding_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $surrounding = new Surrounding();
        $form = $this->createForm('BaseBundle\Form\SurroundingType', $surrounding);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($surrounding);
            $em->flush();

            return $this->redirectToRoute('surrounding_show', array('id' => $surrounding->getId()));
        }

        return $this->render('surrounding/new.html.twig', array(
            'surrounding' => $surrounding,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing surrounding entity.
     *
     * @Route("/{id}/edit", name="surrounding_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Surrounding $surrounding)
    {
        $deleteForm = $this->createDeleteForm($surrounding);
        $editForm = $this->createForm('BaseBundle\Form\SurroundingType', $surrounding, array('csrf_token_id' => $this->getUser()));
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('surrounding_edit', array('id' => $surrounding->getId()));
        }

        return $this->render('surrounding/edit.html.twig', array(
            'surrounding' => $surrounding,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Finds and displays a surrounding entity.
     *
     * @Route("/{id}", name="surrounding_show")
     * @Method("GET")
     */
    public function showAction(Surrounding $surrounding)
    {
        $deleteForm = $this->createDeleteForm($surrounding);

        return $this->render('surrounding/show.html.twig', array(
            'surrounding' => $surrounding,
            'delete_form' => $deleteForm->createView(),
        ));
    }



    /**
     * Deletes a surrounding entity.
     *
     * @Route("/{id}", name="surrounding_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Surrounding $surrounding)
    {
        $form = $this->createDeleteForm($surrounding);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($surrounding);
            $em->flush();
        }

        return $this->redirectToRoute('surrounding_index');
    }

    /**
     * Creates a form to delete a surrounding entity.
     *
     * @param Surrounding $surrounding The surrounding entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Surrounding $surrounding)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('surrounding_delete', array('id' => $surrounding->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
