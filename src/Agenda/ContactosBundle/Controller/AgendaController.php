<?php

namespace Agenda\ContactosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Agenda\ContactosBundle\Entity\Agenda;
use Agenda\ContactosBundle\Form\AgendaType;

/**
 * Agenda controller.
 *
 */
class AgendaController extends Controller
{
    /**
     * Lists all Agenda entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('ContactosBundle:Agenda')->findAll();

        return $this->render('ContactosBundle:Agenda:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Agenda entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ContactosBundle:Agenda')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Agenda entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ContactosBundle:Agenda:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Agenda entity.
     *
     */
    public function newAction()
    {
        $entity = new Agenda();
        $form   = $this->createForm(new AgendaType(), $entity);

        return $this->render('ContactosBundle:Agenda:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Agenda entity.
     *
     */
    public function createAction()
    {
        $entity  = new Agenda();
        $request = $this->getRequest();
        $form    = $this->createForm(new AgendaType(), $entity);
        $form->bindRequest($request);
          //  var_dump($form->getData()->getNumeros());exit;
        if ($form->isValid()) {
            $usuario = $this->get('security.context')->getToken()->getUser();
            $em = $this->getDoctrine()->getEntityManager();
            foreach($form->getData()->getNumeros() as $numero)
            {
                $numero->setAgenda($entity);
            }
            $entity->setUsuario($usuario);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contacto_show', array('id' => $entity->getId())));
            
        }

        return $this->render('ContactosBundle:Agenda:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Agenda entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ContactosBundle:Agenda')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Agenda entity.');
        }

        $editForm = $this->createForm(new AgendaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ContactosBundle:Agenda:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Agenda entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('ContactosBundle:Agenda')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Agenda entity.');
        }
// Se crea una matriz de los objetos numeros actuales en la base de datos
    foreach ($entity->getNumeros() as $numero) 
        $originalNumeros[] = $numero;
         
        $editForm   = $this->createForm(new AgendaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        $request = $this->getRequest();
        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            // filtra $originalNumeros para que contenga los numeros que no estan presente
            foreach ($editForm->getData()->getNumeros() as $numero) {
                if($numero->getId()===NULL)
                    $numerosNuevos[]=$numero;
                else
                    foreach ($originalNumeros as $key => $toDel) {
                        if ($toDel->getId() === $numero->getId()) {
                            unset($originalNumeros[$key]);
                        }
                    }//fin foreach
            }//fin foreach            
           // Elimina la relación entre la etiqueta y la Tarea
            if(!empty($originalNumeros))
                foreach ($originalNumeros as $num){
                    //Se elimina los numeros que ya no estan relacionados con la entidad
                    $em->remove($num);
                } //fin foreach              
            if(!empty($numerosNuevos))
                foreach($numerosNuevos as $numero)
                {   
                    $entity->addNumero($numero);
                    //$numero->setAgenda($entity);
                }
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contacto_edit', array('id' => $id)));
        }

        return $this->render('ContactosBundle:Agenda:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Agenda entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('ContactosBundle:Agenda')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Agenda entity.');
            }

            //Eliminando los numeros asignados a este contacto
           /* foreach($entity->getNumeros() as $numero)
                $em->remove ($numero);
            */
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('contacto'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
