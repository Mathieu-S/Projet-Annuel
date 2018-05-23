<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\BedRoom;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function IndexAction()
    {
        return $this->render('home/index.html.twig', []);
    }

    /**
     * @Route("/api/bedRoomOptions", name="apiBedRoomOptions")
     */
    public function BedRoomOptionsAction()
    {
        $bedRooms = $this->getDoctrine()
            ->getManager()
            ->getRepository('App:OptionalEquipment')
            ->findAll();

        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(['bedRooms']);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $encoder = new JsonEncoder();
        $serializer = new Serializer([$normalizer], [$encoder]);

        return new Response(
            $serializer->serialize($bedRooms, 'json'),
            Response::HTTP_OK,
            array('content-type' => 'application/json')
        );
    }

    /**
     * @Route("/api/bedRooms", name="apiBedRooms")
     */
    public function BedRoomsAction()
    {
        $bedRooms = $this->getDoctrine()
            ->getManager()
            ->getRepository('App:BedRoom')
            ->findAvailableBedRoom();

        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(['bedRooms', 'owner']);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $encoder = new JsonEncoder();
        $serializer = new Serializer([$normalizer], [$encoder]);

        return new Response(
            $serializer->serialize($bedRooms, 'json'),
            Response::HTTP_OK,
            array('content-type' => 'application/json')
        );
    }

    /**
     * @Route("/api/bedRooms/{id}", name="apiBedRoom")
     */
    public function BedRoomAction(BedRoom $bedRoom)
    {
        // $hotels = $this->getDoctrine()
        //     ->getManager()
        //     ->getRepository('App:BedRoom')
        //     ->find();

        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(['bedRooms', 'owner']);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $encoder = new JsonEncoder();
        $serializer = new Serializer([$normalizer], [$encoder]);

        return new Response(
            $serializer->serialize($bedRoom, 'json'),
            Response::HTTP_OK,
            array('content-type' => 'application/json')
        );
    }
}