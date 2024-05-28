<?php

namespace App\Controller;

use App\Entity\Tuto;
use App\Repository\TutoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TutoController extends AbstractController
{
    #[Route('/tuto/{id}', name: 'app_tuto')]
    public function index(TutoRepository $tutoRepository, $id): Response
    {
        $tuto = $tutoRepository->findOneById($id);
        
        if(!$tuto) {
            throw $this->createNotFoundException('Le tuto n\'existe pas');
        }


        return $this->render('tuto/index.html.twig', [
            'name' =>$tuto->getName(),
        ]);
    }

    #[Route('/add-tuto', name: 'create_tuto')]
    public function createProduct(EntityManagerInterface $entityManager): Response
    {
        $product = new Tuto();
        $product->setName('Tuto 1');
        $product->setSlug('tuto-1');
        $product->setSubtitle('Un projet pour mettre en pratique les flexbox');
        $product->setDescription('Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam excepturi corrupti quidem.');
        $product->setImage('https://mycloud.barpat.fun/public/assets/compagnon_de_code/projet_1_html_css/flexbox_practice.png');
        $product->setVideo('https://www.youtube.com/watch?v=ZmXLqBWwiLo');
        $product->setLink('https://www.compagnondecode.fr/projects/9');

        // on sauvegarde pour la DB
        $entityManager->persist($product);
        // on execute la requete sql
        $entityManager->flush();

        return new Response('Saved new product with id ' . $product->getId());
    }
}
