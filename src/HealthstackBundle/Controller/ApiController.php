<?php

namespace HealthstackBundle\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use HealthstackBundle\Entity\Patient;

/**
 * Patient controller.
 *
 */
class ApiController extends Controller
{
    public function authAction(Request $request)
    {
        try {
            $requestArray = json_decode($request->getContent(), true);
        } catch (Exception $e) {
            return $e;
        }
        if (empty($requestArray)) {
            return new BadRequestHttpException();
        }

        if (array_key_exists('phone', $requestArray)) {
            $telephone = $requestArray['phone'];
            $pass = $requestArray['pass'];

            $em = $this->getDoctrine()->getManager();

            $patient = $em->getRepository('HealthstackBundle:Patient')->findOneBy(['telephone' => $telephone]);
            if ($patient && $pass == $patient->getPassword()) {
                $patient->setToken(base64_encode(openssl_random_pseudo_bytes(3 * (32 >> 2))));
                $em->flush();
                return new JsonResponse($this->serializePatient($patient), 200);
            } else {
                return new JsonResponse('{"error": "User not found"}', 401);
            }

        }
    }

    private function serializePatient($patient)
    {
        return [
            'id' => $patient->getId(),
            'firstName' => $patient->getFirstName(),
            'lastName' => $patient->getLastName(),
            'birthday' => $patient->getBirthday()->format('Y-m-d'),
            'telephone' => $patient->getTelephone(),
            'avatar' => $avatarsDir = $this->container->getParameter('kernel.root_dir').'/../web/avatars/' . $patient->getAvatar(),
            'pin' => $patient->getPin(),
            'token' => $patient->getToken(),
        ];
    }

    public function ticketsAction(Request $request)
    {
        $headers = $request->server->getHeaders();

        if (!array_key_exists('TOKEN', $headers)) {
            return new JsonResponse('{"error": "No token provided"}', 401);
        }
        $token = $headers['TOKEN'];
        $timestamp = $request->get('timestamp');

        $em = $this->getDoctrine()->getManager();

        $patient = $em->getRepository('HealthstackBundle:Patient')->findOneBy(['token' => $token]);

        if (!$patient) {
            return new JsonResponse('{"error": "User not found"}', 401);
        }
        $timestampObject = new \DateTime();
        $timestampObject->setTimestamp($timestamp);

        if ($timestamp) {
            $qb = $em->createQueryBuilder();

            $q  = $qb->select('t')
                ->from('HealthstackBundle:Ticket', 't')
                ->where('t.visitDate > :date_from')
                ->andWhere('t.patient = :patient')
                ->setParameter('date_from', $timestampObject)
                ->setParameter('patient', $patient)
                ->getQuery();

            $tickets = $q->getResult();
        } else {
            $tickets = $em->getRepository('HealthstackBundle:Ticket')->findBy([
                'patient' => $patient,
            ]);
        }
        $ticketsArray = [];
        foreach ($tickets as $ticket) {
            $ticketsArray[] = $this->serializeTicket($ticket);
        }

        return new JsonResponse($ticketsArray, 200);
    }

    private function serializeTicket($ticket)
    {
        return [
            'id' => $ticket->getId(),
            'patient_id' => $ticket->getPatient()->getId(),
            'patient_name' => $ticket->getPatient()->getFirstName() . $ticket->getPatient()->getLastName(),
            'hash' => $ticket->getHash(),
            'created' => $ticket->getVisitDate()->getTimestamp(),
            'symptomes' => $ticket->getSymptomes(),
            'diagnosis' => $ticket->getDiagnosis(),
            'items' => $this->serializeTicketItems($ticket->getItems()),
        ];
    }
    private function serializeTicketItems($ticketItems)
    {
        $items = [];
        foreach($ticketItems as $item) {
            $items[] = [
                'id' => $item->getId(),
                'medicine_id' => $item->getMedicine()->getId(),
                'medicine_name' => $item->getMedicine()->getName(),
                'count_per_day' => $item->getCountPerDay(),
                'total_days' => $item->getTotalDays(),
                'dose' => $item->getDose(),
                'dose_amount' => $item->getDoseAmount(),
                'take_time1' => $item->getTakeTime1()->format('H') * 60 + $item->getTakeTime1()->format('i'),
                'take_time2' => $item->getTakeTime2()->format('H') * 60 + $item->getTakeTime2()->format('i'),
                'take_time3' => $item->getTakeTime3()->format('H') * 60 + $item->getTakeTime3()->format('i'),
            ];
        }

        return $items;
    }

    public function medicinesAction(Request $request)
    {
        $headers = $request->server->getHeaders();

        if (!array_key_exists('TOKEN', $headers)) {
            return new JsonResponse('{"error": "No token provided"}', 401);
        }
        $token = $headers['TOKEN'];
        $timestamp = $request->get('timestamp');

        $em = $this->getDoctrine()->getManager();

        $patient = $em->getRepository('HealthstackBundle:Patient')->findOneBy(['token' => $token]);

        if (!$patient) {
            return new JsonResponse('{"error": "User not found"}', 401);
        }
        $timestampObject = new \DateTime();
        $timestampObject->setTimestamp($timestamp);

        if ($timestamp) {
            $qb = $em->createQueryBuilder();

            $q  = $qb->select('t')
                ->from('HealthstackBundle:Ticket', 't')
                ->where('t.visitDate > :date_from')
                ->andWhere('t.patient = :patient')
                ->andWhere('t.activeStatus = true')
                ->setParameter('date_from', $timestampObject)
                ->setParameter('patient', $patient)
                ->getQuery();

            $tickets = $q->getResult();
        } else {
            $tickets = $em->getRepository('HealthstackBundle:Ticket')->findBy([
                'patient' => $patient,
                'activeStatus' => true,
            ]);
        }
        $medicines = [];
        foreach ($tickets as $ticket) {
            $medicines = array_merge($medicines, $this->serializeTicketItems($ticket->getItems()));
        }

        return new JsonResponse($medicines, 200);
    }
}
