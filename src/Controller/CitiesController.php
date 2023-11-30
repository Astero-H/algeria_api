<?php

namespace App\Controller;

use App\Entity\Cities;
use App\Repository\CitiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class CitiesController extends AbstractController
{
    #[Route('/api/cities', name: 'app_cities', methods: ['GET'])]
    public function getCitiesList(CitiesRepository $citiesRepository, SerializerInterface $serializer): JsonResponse
    {
        $citiesList= $citiesRepository->findAll();
        $jsonCitiesList = $serializer->serialize($citiesList, 'json', ['groups' => 'getCities']);

        return new JsonResponse($jsonCitiesList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/cities/{id}', name: 'app_city', methods: ['GET'])]
    public function getCity(Cities $city,SerializerInterface $serializer): JsonResponse
    {
        $jsonCity = $serializer->serialize($city, 'json', ['groups' => 'getCities']);
        return new JsonResponse($jsonCity, Response::HTTP_OK, [], true);
    }

    #[Route('/api/cities/{id}', name: 'deleteCity', methods: ['DELETE'])]
    public function deleteCity(Cities $city, EntityManagerInterface $em ): JsonResponse
    {
        $em->remove($city);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/cities', name: 'addCity', methods: ['POST'])]
    public function createCity(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator): JsonResponse
    {
        $city = $serializer->deserialize($request->getContent(), Cities::class,'json');
        $em->persist($city);
        $em->flush();

        $jsonCity = $serializer->serialize($city, 'json', ['groups' => 'getCities']);
        $location = $urlGenerator->generate('addCity', ['id' => $city->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonCity, Response::HTTP_CREATED, ["Location" => $location ]);
    }

    #[Route('/api/cities/{id}', name: 'updateCity', methods: ['PUT'])]
    public function updateCity(Cities $currentCity,Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {     
        $updateCity = $serializer->deserialize($request->getContent(), Cities::class,'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $currentCity]);        
        $em->persist($updateCity);
        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}









































































































































