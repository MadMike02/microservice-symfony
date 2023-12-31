<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/products/{id}/lowest-price', name: 'lowest-price', methods: 'POST')]
    public function lowestPrice(Request $request, int $id):JsonResponse{
        
        if($request->headers->has('force-fail')){
            return new JsonResponse([
                'error' => 'something went wrong'
            ], $request->headers->get('force_fail'));
        }


        return new JsonResponse([
            "quantity" => 5,
            "request_location" => "UK",
            "voucher_code" => "QU812",
            "request_date" => "2022-1-4",
            "product_id" => $id,
            "price" => 100,
            "discounted_price" => 50,
            "promotiond_id" => 3,
            "promotion_name" => 'Black friday half price sale'
        ], 200);
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
