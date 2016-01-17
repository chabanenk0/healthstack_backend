<?php

namespace HealthstackBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HealthstackBundle\Entity\Medicine;
use HealthstackBundle\Form\MedicineType;

/**
 * Medicine controller.
 *
 */
class MedicineController extends Controller
{
    /**
     * Lists all Medicine entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM HealthstackBundle:Medicine a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('HealthstackBundle:Medicine:index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Creates a new Medicine entity.
     *
     */
    public function newAction(Request $request)
    {
        $medicine = new Medicine();
        $form = $this->createForm('HealthstackBundle\Form\MedicineType', $medicine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($medicine);
            $em->flush();

            return $this->redirectToRoute('medicine_show', array('id' => $medicine->getId()));
        }

        return $this->render('HealthstackBundle:Medicine:new.html.twig', array(
            'medicine' => $medicine,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Medicine entity.
     *
     */
    public function showAction(Medicine $medicine)
    {
        $deleteForm = $this->createDeleteForm($medicine);

        return $this->render('HealthstackBundle:Medicine:show.html.twig', array(
            'medicine' => $medicine,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Medicine entity.
     *
     */
    public function editAction(Request $request, Medicine $medicine)
    {
        $deleteForm = $this->createDeleteForm($medicine);
        $editForm = $this->createForm('HealthstackBundle\Form\MedicineType', $medicine);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($medicine);
            $em->flush();

            return $this->redirectToRoute('medicine_edit', array('id' => $medicine->getId()));
        }

        return $this->render('HealthstackBundle:Medicine:edit.html.twig', array(
            'medicine' => $medicine,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Medicine entity.
     *
     */
    public function deleteAction(Request $request, Medicine $medicine)
    {
        $form = $this->createDeleteForm($medicine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($medicine);
            $em->flush();
        }

        return $this->redirectToRoute('medicine_index');
    }

    /**
     * Creates a form to delete a Medicine entity.
     *
     * @param Medicine $medicine The Medicine entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Medicine $medicine)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('medicine_delete', array('id' => $medicine->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
