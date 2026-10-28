<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Post;

final class BlogController extends AbstractController
{
    #[Route('/blog/{page}', name: 'blog', requirements: ['page' => '\d+'])]
    public function index(ManagerRegistry $doctrine, int $page = 1): Response
    {
        $repository = $doctrine->getRepository(Post::class);
        $posts = $repository->findAll($page);
        $recents = $repository->findRecents();
        return $this->render('blog/blog.html.twig', [
            'posts' => $posts,
            'recents' => $recents,
        ]);
    }


    #[Route('/blog/single_post/{slug}', name: 'single_post')]
    public function post(ManagerRegistry $doctrine, $slug): Response
    {
        $repository = $doctrine->getRepository(Post::class);
        $post = $repository->findOneBy(["slug"=>$slug]);

        $recents = $repository->findRecents();
        return $this->render('blog/single_post.html.twig', [
            'post' => $post,
            'recents' => $recents
        ]);
    }

}
