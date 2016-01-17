<?php

namespace HealthstackBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HealthstackBundle\Entity\Ticket;
use HealthstackBundle\Form\TicketType;

/**
 * Ticket controller.
 *
 */
class TicketController extends Controller
{
    /**
     * Lists all Ticket entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tickets = $em->getRepository('HealthstackBundle:Ticket')->findAll();

        return $this->render('HealthstackBundle:Ticket:index.html.twig', array(
            'tickets' => $tickets,
        ));
    }

    /**
     * Creates a new Ticket entity.
     *
     */
    public function newAction(Request $request)
    {
        $ticket = new Ticket();
        $form = $this->createForm('HealthstackBundle\Form\TicketType', $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->flush();

            return $this->redirectToRoute('ticket_show', array('id' => $ticket->getId()));
        }

        return $this->render('HealthstackBundle:Ticket:new.html.twig', array(
            'ticket' => $ticket,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ticket entity.
     *
     */
    public function showAction(Ticket $ticket)
    {
        $deleteForm = $this->createDeleteForm($ticket);

        return $this->render('HealthstackBundle:Ticket:show.html.twig', array(
            'ticket' => $ticket,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ticket entity.
     *
     */
    public function editAction(Request $request, Ticket $ticket)
    {
        $deleteForm = $this->createDeleteForm($ticket);
        $editForm = $this->createForm('HealthstackBundle\Form\TicketType', $ticket);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->flush();

            return $this->redirectToRoute('ticket_edit', array('id' => $ticket->getId()));
        }

        return $this->render('HealthstackBundle:Ticket:edit.html.twig', array(
            'ticket' => $ticket,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Ticket entity.
     *
     */
    public function deleteAction(Request $request, Ticket $ticket)
    {
        $form = $this->createDeleteForm($ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ticket);
            $em->flush();
        }

        return $this->redirectToRoute('ticket_index');
    }

    /**
     * Creates a form to delete a Ticket entity.
     *
     * @param Ticket $ticket The Ticket entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ticket $ticket)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ticket_delete', array('id' => $ticket->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
