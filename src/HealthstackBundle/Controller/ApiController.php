<?php

namespace HealthstackBundle\Controller;

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
}
