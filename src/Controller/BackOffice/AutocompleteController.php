<?php

namespace App\Controller\BackOffice;

use App\Entity\City;
use App\Entity\Department;
use App\Entity\PostalCode;
use App\Entity\Region;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class AutocompleteController extends Controller
{

    /**
     * @Route("/autocomplete/department/{regionId}", name="autocomplete_department")
     * @ParamConverter("region", class=Region::class, options={"id" = "regionId"})
     * @Method("GET")
     * @return JsonResponse
     */
    public function autocompleteDepartment(Region $region)
    {

        $data = $this->getDoctrine()->getRepository(Department::class)->findDepartmentsByRegion($region);
        return new JsonResponse($data);
    }

    /**
     * @Route("/autocomplete/city/{departmentId}", name="autocomplete_city")
     * @ParamConverter("department", class=Department::class, options={"id" = "departmentId"})
     * @Method("GET")
     * @return JsonResponse
     */
    public function autocompleteCity(Department $department)
    {

        $data = $this->getDoctrine()->getRepository(City::class)->findCitiesByDepartment($department);

        return new JsonResponse($data);
    }

    /**
     * @Route("/autocomplete/postalcode/{cityId}", name="autocomplete_postalcode")
     * @ParamConverter("city", class=City::class, options={"id" = "cityId"})
     * @Method("GET")
     * @return JsonResponse
     */
    public function autocompletePostalCode(City $city)
    {

        $data = $this->getDoctrine()->getRepository(PostalCode::class)->findPostalCodesByCity($city);

        return new JsonResponse($data);
    }

}