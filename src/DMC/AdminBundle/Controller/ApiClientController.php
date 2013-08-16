<?php

namespace DMC\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DMC\ApiBundle\Entity\ApiClient;
use DMC\AdminBundle\Form\ApiClientType;

use DMC\ApiBundle\Entity\ApiClientKey;
use DMC\AdminBundle\Utility\StringUtil;

/**
 * ApiClient controller.
 *
 * @Route("/admin/apiclient")
 */
class ApiClientController extends Controller {

    /**
     * Lists all ApiClient entities.
     *
     * @Route("/", name="admin_apiclient")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DMCApiBundle:ApiClient')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new ApiClient entity.
     *
     * @Route("/", name="admin_apiclient_create")
     * @Method("POST")
     * @Template("DMCApiBundle:ApiClient:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new ApiClient();
        $form = $this->createForm(new ApiClientType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            //create new ApiClientKey for this client
            $apiClientKey = new ApiClientKey();
            $apiClientKey->setApiKey(StringUtil::generateRandomString());            
            $apiClientKey->setApiSecret(StringUtil::generateRandomString());
            
            $entity->addKey($apiClientKey);            
                        
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_apiclient_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new ApiClient entity.
     *
     * @Route("/new", name="admin_apiclient_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new ApiClient();
        $form = $this->createForm(new ApiClientType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a ApiClient entity.
     *
     * @Route("/{id}", name="admin_apiclient_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DMCApiBundle:ApiClient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ApiClient entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ApiClient entity.
     *
     * @Route("/{id}/edit", name="admin_apiclient_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DMCApiBundle:ApiClient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ApiClient entity.');
        }

        $editForm = $this->createForm(new ApiClientType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing ApiClient entity.
     *
     * @Route("/{id}", name="admin_apiclient_update")
     * @Method("PUT")
     * @Template("DMCApiBundle:ApiClient:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DMCApiBundle:ApiClient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ApiClient entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ApiClientType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_apiclient_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ApiClient entity.
     *
     * @Route("/{id}", name="admin_apiclient_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DMCApiBundle:ApiClient')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ApiClient entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_apiclient'));
    }

    /**
     * Creates a form to delete a ApiClient entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     * 
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

    
    
    
    /**
     * Creates a new ApiKey for the indicated client.
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param type $id
     * 
     * @Route("/{id}/key", name="admin_apiclient_key_create")
     * @Method("POST")
     * 
     */
    public function generateApiKeyAction(Request $request, $id) {
        
        //validate ApiClient id
        $em = $this->getDoctrine()->getManager();
        $apiClient = $em->getRepository('DMCApiBundle:ApiClient')->find($id);
        if (!$apiClient) {
            throw $this->createNotFoundException('Unable to find ApiClient entity.');
        }
        
        //create new Key
        $apiClientKey = new ApiClientKey();
        $apiClientKey->setApiKey(StringUtil::generateRandomString());
        $apiClientKey->setApiSecret(StringUtil::generateRandomString());
        $apiClient->addKey($apiClientKey);
        $em->persist($apiClient);
        $em->flush();
        
        return $this->redirect($this->generateUrl('admin_apiclient_show', array('id' => $apiClient->getId())));
        
    }
    
    
    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param type $id
     * 
     * @Route("/{id}/key/{keyid}", name="admin_apiclient_key_delete")
     * @Method("DELETE")
     */
    public function removeApiKeyAction(Request $request, $id, $keyid) {
        
        //validate ApiClient id
        $em = $this->getDoctrine()->getManager();
        $apiClient = $em->getRepository('DMCApiBundle:ApiClient')->find($id);
        if (!$apiClient) {
            throw $this->createNotFoundException('Unable to find ApiClient entity.');
        }
        
        $apiClientKey = $em->getRepository('DMCApiBundle:ApiClientKey')->find($keyid);
        if (!$apiClientKey) {
            throw $this->createNotFoundException('Unable to find ApiClientKey entity.');
        }
     
        //remove key from client
        $apiClient->removeKey($apiClientKey);
        $em->persist($apiClient);
        
        //delete key
        $em->remove($apiClientKey);
        
        $em->flush();
        
        return $this->redirect($this->generateUrl('admin_apiclient_show', array('id' => $apiClient->getId())));
        
    }
    
    
}
