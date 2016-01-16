<?php

namespace HealthstackBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use HealthstackBundle\Entity\Patient;
use HealthstackBundle\Form\PatientType;

/**
 * Patient controller.
 *
 */
class PatientController extends Controller
{
    /**
     * Lists all Patient entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $patients = $em->getRepository('HealthstackBundle:Patient')->findAll();

        return $this->render('HealthstackBundle:Patient:index.html.twig', array(
            'patients' => $patients,
        ));
    }

    /**
     * Creates a new Patient entity.
     *
     */
    public function newAction(Request $request)
    {
        $patient = new Patient();
        $form = $this->createForm('HealthstackBundle\Form\PatientType', $patient);
        $form->add('avatar', FileType::class, [
            'required' => false,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $patient->getAvatar();

            if ($file) {
                // Generate a unique name for the file before saving it
                $fileName = md5(uniqid()).'.'.$file->guessExtension();

                // Move the file to the directory where brochures are stored
                $avatarsDir = $this->container->getParameter('kernel.root_dir').'/../web/avatars';
                $file->move($avatarsDir, $fileName);

                // Update the 'brochure' property to store the PDF file name
                // instead of its contents
                $patient->setAvatar($fileName);
            } else {
                $patient->setAvatar(null);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($patient);
            $em->flush();

            return $this->redirectToRoute('patient_show', array('id' => $patient->getId()));
        }

        return $this->render('HealthstackBundle:Patient:new.html.twig', array(
            'patient' => $patient,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Patient entity.
     *
     */
    public function showAction(Patient $patient)
    {
        $deleteForm = $this->createDeleteForm($patient);

        return $this->render('HealthstackBundle:Patient:show.html.twig', array(
            'patient' => $patient,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Patient entity.
     *
     */
    public function editAction(Request $request, Patient $patient)
    {
        $deleteForm = $this->createDeleteForm($patient);
        $editForm = $this->createForm('HealthstackBundle\Form\PatientType', $patient);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($patient);
            $em->flush();

            return $this->redirectToRoute('patient_edit', array('id' => $patient->getId()));
        }

        return $this->render('HealthstackBundle:Patient:edit.html.twig', array(
            'patient' => $patient,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Patient entity.
     *
     */
    public function deleteAction(Request $request, Patient $patient)
    {
        $form = $this->createDeleteForm($patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($patient);
            $em->flush();
        }

        return $this->redirectToRoute('patient_index');
    }

    /**
     * Creates a form to delete a Patient entity.
     *
     * @param Patient $patient The Patient entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Patient $patient)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('patient_delete', array('id' => $patient->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
