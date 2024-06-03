<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\User;
use App\Repository\MovieRepository;
use App\Repository\ReviewRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class ReviewController extends AbstractController
{
    #[Route('/review', name: 'app_review')]
    public function index(ReviewRepository $reviewRepository, UserRepository $userRepository, MovieRepository $movieRepository, ParameterBagInterface $parameterBagInterface, Request $request): Response
    {

        $limitOfReviews = $parameterBagInterface->get('reviews_limit');
        $movies = $movieRepository->findAll();
        $userId = $userRepository->getId();
        $user = $this->getUser();

        $reviewByMovie = [];
        foreach ($movies as $movie) {
            $reviewByMovie[$movie->getId()] = $reviewRepository->findByMovieAndUser($movie->getId(), $user);
        }
        
        
        return $this->render('review/index.html.twig', [
            'reviewByMovie' => $reviewByMovie,
            'user' => $user,
            'movie' => $movie,
        ]);
    }
}
