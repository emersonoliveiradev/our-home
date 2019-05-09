<?php

namespace BaseBundle\Controller;

use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;
use function GuzzleHttp\Promise\all;
use function GuzzleHttp\Psr7\str;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BaseBundle\Entity\Component;
use BaseBundle\Form\ComponentType;
use Symfony\Component\HttpFoundation\Response;



/**
 * Component controller.
 * @Route("/component")
 * @Breadcrumb({{ "label" = "Início", "route" = "default_index"}})
 */
class ComponentController extends Controller
{

    /**
     * Lists all Component entities.
     * @Route("/", name="component_index")
     * @Method("GET")
     * @Breadcrumb({{ "label" = "Componentes"}})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $components = $em->getRepository('BaseBundle:Component')->findAll();
        return $this->render('component/index.html.twig', array('components' => $components,));
    }


    /**
     * Creates a new Component entity.
     * @Route("/new", name="component_new")
     * @Method({"GET", "POST"})
     * @Breadcrumb({{ "label" = "Componentes", "route" = "component_index"}, { "label" = "Adicionar"}})
     */
    public function newAction(Request $request)
    {
        $component = new Component();
        #Tem que mudar esse csrf_token_id para currentUser

        $form = $this->createForm('BaseBundle\Form\ComponentType', $component, array('csrf_token_id' => $this->getUser()));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData()->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($component);
            $em->flush();
            return $this->redirectToRoute('component_index', array('component' => $component));
        }
        return $this->render('component/new.html.twig', array('component' => $component, 'form' => $form->createView(),));
    }

    /**
     * Displays a form to edit an existing Component entity.
     * @Route("/{id}/edit", name="component_edit")
     * @Method({"GET", "POST"})
     * @Breadcrumb({{ "label" = "Componentes", "route" = "component_index"}, { "label" = "Editar"}})
     */
    public function editAction(Request $request, Component $component)
    {
        $deleteForm = $this->createDeleteForm($component);
        $editForm = $this->createForm('BaseBundle\Form\ComponentType', $component, array('csrf_token_id' => $this->getUser()));
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($component);
            $em->flush();
            return $this->redirectToRoute('component_edit', array('id' => $component->getId()));
        }
        return $this->render('component/edit.html.twig', array('component' => $component, 'edit_form' => $editForm->createView(), 'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Deletes a Component entity.
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
        return $this->createFormBuilder()->setAction($this->generateUrl('component_delete', array('id' => $component->getId())))->setMethod('DELETE')->getForm();
    }


    /**
     * Get status of Component.
     * @Route("/api/{id}/get", name="component_get")
     * @Method("POST")
     */
    public function getAction($id)
    {
        return new JsonResponse(['msg' => 'Serie Symfony 3.4 API', 'number' => $id]);
    }

    /**
     * Switch status of Component.
     * @Route("/{id}/switch", name="component_switch")
     *
     */
    public function switchAction($id)
    {
        $client = new \GuzzleHttp\Client();
        $http = $this->getParameter('uri_api_teste');
        $response = $client->request('POST', "{$http}/{$id}/get");
        die($response);

        return new Response($response->getBody(), $response->getStatusCode());
    }


    /**
     * @Route("/{id}/state", name="api_state")
     */
    public function apiAction($id, Request $request) {
        # consultar bd
        # resgatar pino
        # enviar na requisição
        $client = new \GuzzleHttp\Client();
        $http = $this->getParameter('uri_api_reaspberry');
        $response = $client->request('GET', "{$http}/{$id}/state");

        if($response->getStatusCode() == 200){
            die("Foi");
            $dec = json_decode($response->getBody(), false);
            $status = $dec->item->status;
            $device = $dec->item->device;
            #echo(gettype($dec->User->Nome));
            echo($status);
            echo($device);
        } elseif ($response->getStatusCode() == 400) {
            die("Por algum motivo ");
            return $response;
        }

        #dump($dec->statusCode);
        #$ab = json_encode($dec->User->Nome);
        #echo($ab);
        return new Response(null);
    }

    #$client = new \GuzzleHttp\Client();
    #$response = $client->request('GET', 'https://api.github.com/repos/guzzle/guzzle');
    #echo $response->getStatusCode(); # 200
    #echo $response->getHeaderLine('content-type'); # 'application/json; charset=utf8'
    #echo $response->getBody(); # '{"id": 1420053, "name": "guzzle", ...}'


    /**
     * Finds and displays a Component entity.
     * @Route("/{id}", name="component_show")
     * @Method("GET")
     */
    public function showAction(Component $component)
    {
        $deleteForm = $this->createDeleteForm($component);
        return $this->render('component/show.html.twig', array('component' => $component, 'delete_form' => $deleteForm->createView(),));
    }

}
