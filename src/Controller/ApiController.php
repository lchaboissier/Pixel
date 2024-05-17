<?php 

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class ApiController extends AbstractController
{
    #[Route('/game.{_format}', defaults:['_format' => 'json'])]
    public function game(GameRepository $gameRepository, SerializerInterface $serializer, string $_format, Request $request): Response
    {
        $search = $request->get('s', '');

        $entities = $gameRepository->findData(search: $search);

        /*foreach ($entities as $entity) {
            var_dump(serialize($entity));
        }*/

        // return new JsonResponse($entities);

        return new Response(
            $serializer->serialize($entities, $_format, ['json_encode_options' => \JSON_PRETTY_PRINT]),
            Response::HTTP_OK,
            ['content-type' => 'text/'.$_format]
        );
    }
}