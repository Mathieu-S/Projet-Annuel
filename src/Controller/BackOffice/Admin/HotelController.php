<?php

namespace App\Controller\BackOffice\Admin;

use App\Entity\City;
use App\Entity\Department;
use App\Entity\Hotel;
use App\Entity\Region;
use App\Form\HotelType;
use App\Repository\PostalCodeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/hotels")
 */
class HotelController extends Controller
{

    /**
     * @Route("/", name="adminHotels")
     */
    public function HotelsAction()
    {
        $hotels = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('App:Hotel')
            ->findAll();

        return $this->render('backoffice/admin/hotels/hotels.html.twig', [
            'hotels' => $hotels
        ]);
    }

    /**
     * @param Request $request
     * @Route("/create", name="adminCreateHotels")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createHotelAction(Request $request) {

        $hotel = new Hotel();
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $hotel->setCreatedAt(new \DateTime());
            $hotel->setOwner($this->getUser());
            $em->persist($hotel);
            $em->flush();
            return $this->redirectToRoute('adminHotels');

        }
        return $this->render('backoffice/admin/hotels/form.html.twig', [
           'hotelForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="adminEditHotels")
     */
    public function EditHotelAction(Request $request, Hotel $hotel)
    {
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('adminHotels');
        }
        return $this->render('backoffice/admin/hotels/form.html.twig', [
            'hotelForm' => $form->createView()
        ]);
    }
    /**
     * @Route("/delete/{id}", name="adminDeleteHotels")
     */
    public function DeleteHotelAction(Hotel $hotel)
    {
        if ($hotel === null) {
            return $this->redirectToRoute('adminHotels');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($hotel);
        $em->flush();
        return $this->redirectToRoute('adminHotels');
    }

    /**
     * @Route("/autocomplete-hotel/department/{regionId}", name="autocomplete_department")
     * @ParamConverter("region", class=Region::class, options={"id" = "regionId"})
     * @Method("GET")
     * @return JsonResponse
     */
    public function autocompleteDepartment(Region $region)
    {

        $data = $this->getDoctrine()->getRepository(Department::class)->findDepartmentsFromRegion($region->getId());

        return new JsonResponse($data);
    }

    /**
     * @Route("/autocomplete-hotel/city/{departmentId}", name="autocomplete_city")
     * @ParamConverter("department", class=Department::class, options={"id" = "departmentId"})
     * @Method("GET")
     * @return JsonResponse
     */
    public function autocompleteCity(Department $department)
    {

        $data = $this->getDoctrine()->getRepository(City::class)->findCitiesFromDepartment($department->getId());

        return new JsonResponse($data);
    }
}