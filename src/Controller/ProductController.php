<?php

namespace App\Controller;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotion;
use App\Service\Serializer\DTOSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Filter\PromotionsFilterInterface;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProductController extends AbstractController
{

    public function __construct(
        private ProductRepository $repository,
        private EntityManagerInterface $entityManger
    )
    {
        
    }

    #[Route('/products/{id}/lowest-price', name: 'lowest-price', methods: 'POST')]
    public function lowestPrice(
        Request $request, 
        int $id, 
        DTOSerializer $serializer, 
        PromotionsFilterInterface $promotionFilter
    ): Response
    {

        if ($request->headers->has('force-fail')) {
            return new JsonResponse([
                'error' => 'something went wrong'
            ], $request->headers->get('force_fail'));
        }

        /** @var LowestPriceEnquiry $lowestPriceEnquiry */
        //serialize coming input from postmand request to desired entity fields
        $lowestPriceEnquiry = $serializer->deserialize(
            $request->getContent(), LowestPriceEnquiry::class, 'json'
        );

        $product = $this->repository->find($id);
        
        $lowestPriceEnquiry->setProduct($product);

        $promotions = $this->entityManger->getRepository(Promotion::class)->findValidForProduct($product, date_create_immutable($lowestPriceEnquiry->getRequestDate()));

        // dd($promotions);
        $modifiesEnquiry = $promotionFilter->apply($lowestPriceEnquiry, ...$promotions);

        //send back the deserialized object again as serialized json object
        $responseContent = $serializer->serialize($modifiesEnquiry, 'json');

        return new Response($responseContent, 200, ['Content-Type' => 'application/json']);
    }

    #[Route('/products/{id}/promotions', name: 'promotions', methods: 'GET')]
    public function promotions(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ProductController.php',
        ]);
    }
}
