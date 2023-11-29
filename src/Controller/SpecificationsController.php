<?php

namespace App\Controller;

use App\Entity\Specifications;
use App\Repository\SpecificationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SpecificationsController extends AbstractController
{
    #[Route('/api/specifications', name: 'app_specs', methods: ['GET'])]
    public function getSpecsList(SpecificationsRepository $specificationsRepository, SerializerInterface $serializer): JsonResponse
    {
        $specsList= $specificationsRepository->findAll();
        $jsonSpecsList = $serializer->serialize($specsList, 'json', ['groups' => 'getSpecifications']);

        return new JsonResponse($jsonSpecsList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/specifications/{id}', name: 'app_spec_id', methods: ['GET'])]
    public function getSpecification(Specifications $specs,SerializerInterface $serializer): JsonResponse
    {
        $jsonSpecs = $serializer->serialize($specs, 'json', ['groups' => 'getSpecifications']);
        return new JsonResponse($jsonSpecs, Response::HTTP_OK, [], true);
    }

}
