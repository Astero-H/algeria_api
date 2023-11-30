<?php

namespace App\Controller;

use App\Entity\Specifications;
use App\Repository\SpecificationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class SpecificationsController extends AbstractController
{
    #[Route('/api/specifications', name: 'getSpecs', methods: ['GET'])]
    public function getSpecsList(SpecificationsRepository $specificationsRepository, SerializerInterface $serializer): JsonResponse
    {
        $specsList= $specificationsRepository->findAll();
        $jsonSpecsList = $serializer->serialize($specsList, 'json', ['groups' => 'getSpecifications']);
        return new JsonResponse($jsonSpecsList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/specifications/{id}', name: 'getSpecById', methods: ['GET'])]
    public function getSpecification(Specifications $specs,SerializerInterface $serializer): JsonResponse
    {
        $jsonSpecs = $serializer->serialize($specs, 'json', ['groups' => 'getSpecifications']);
        return new JsonResponse($jsonSpecs, Response::HTTP_OK, [], true);
    }
    
    #[Route('/api/specifications/{id}', name: 'deleteSpec', methods: ['DELETE'])]
    public function deleteSpecification(EntityManagerInterface $em, Specifications $specs): JsonResponse
    {
        $em->remove($specs);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/specifications', name: 'addSpec', methods: ['POST'])]
    public function AddSpecification(Request $request, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator ,SerializerInterface $serializer): JsonResponse
    {
        $spec = $serializer->deserialize($request->getContent(), Specifications::class, 'json');
        $em->persist($spec);
        $em->flush();

        $jsonSpec = $serializer->serialize($spec, 'json', ['groups' => 'getSpecifications']);
        $location = $urlGenerator->generate('addSpec', ['id' => $spec->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
        return new JsonResponse($jsonSpec, Response::HTTP_CREATED, ["Location" => $location ]);
    }

    #[Route('/api/specifications/{id}', name: 'updateSpec', methods: ['PUT'])]
    public function UpdateSpecification(Request $request, EntityManagerInterface $em, Specifications $currentSpec,SerializerInterface $serializer): JsonResponse
    {
        $spec = $serializer->deserialize($request->getContent(), Specifications::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $currentSpec]);
        $em->persist($spec);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
    
}
