<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorFormType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function appIndex(): Response
    {
        return $this->redirectToRoute("list_author");
    }
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route("/showauthor/{name}", name:'show_author')]
    public function showAuthor($name): Response 
        {
            return $this->render('author/showAuthor.html.twig',[
                'name'=>$name
            ]);

        }
        #[Route("/author/list", name:'list_author')]
        public function listAuthor(AuthorRepository $authorRepo, ManagerRegistry $doctrine,Request $request, EntityManagerInterface $em): Response 
            {
                // $authors = array(
                //     array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
                //     'victor.hugo@gmail.com ', 'nb_books' => 100),
                //     array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
                //     ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
                //     array('id' => 3, 'picture' => '/images/Taha-Hussein.jpg','username' => 'Taha Hussein', 'email' =>
                //     'taha.hussein@gmail.com', 'nb_books' => 300),
                //     );
                 $authorRepo =$doctrine->getRepository(Author::class);
                 $authors = $authorRepo->findAll();
                 
                 $newAuthor = new Author;
                 $form = $this->createForm(AuthorFormType::class, $newAuthor);
                 
                 $form->handleRequest($request);
                        if($form->isSubmitted() && $form->isValid()){
                            $em->persist($newAuthor);
                            $em->flush();
                            return $this->redirectToRoute("list_author");
                        }
                return $this->render('author/listAuthor.html.twig',[
                    'authors'=>$authors, 
                    'form'=>$form->createView(),
                    
                ]);
    
            }

            #[Route("/auhtorDetails/{id}", name:'auhtor_details')]
            public function auhtorDetails($id, AuthorRepository $authorRepo, BookRepository $bookrepo): Response 
                {
                    // $authors = array(
                    //     array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
                    //     'victor.hugo@gmail.com ', 'nb_books' => 100),
                    //     array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
                    //     ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
                    //     array('id' => 3, 'picture' => '/images/Taha-Hussein.jpg','username' => 'Taha Hussein', 'email' =>
                    //     'taha.hussein@gmail.com', 'nb_books' => 300),
                    //     );
                        $foundAuthor = $authorRepo->find($id);
                        $authorBooks = $bookrepo->findBy(['Author'=>$id]);
                        return $this->render('author/auhtorDetails.html.twig', 
                        [
                            'author' => $foundAuthor,
                            'authorBooks' => $authorBooks,
                        ]);
                }
            #[Route("/author/addAuthor", name:'add_author')]
            public function addAuthor(ManagerRegistry  $doc) : Response 
            {
                $author  = new Author;
                $em = $doc->getManager();
                $author->setUsername('test by func');
                $author->setEmail('test@esprit.tn');
                $em->persist($author);
                $em->flush();
               return new Response ("Author added");
            }
            #[Route("/author/deleteAuthor/{id}", name:'delete_author')] 
            public function deleteAuthor($id, ManagerRegistry $doctrine) : Response
            {
                $em=$doctrine->getManager();
                $repo= $doctrine->getRepository(Author::class);
                $author=$repo->find($id);
                $em->remove($author);
                $em->flush();
                return $this->redirectToRoute("list_author");
            }

            #[Route("/author/addAuthorByForm", name:'add_author_by_form')]
            public function addAuthorByForm(Request $request, EntityManagerInterface $em): Response 
                {
                    $author = new Author();
                    $form = $this->createForm(AuthorFormType::class, $author);
                    $form->handleRequest($request); 
                    if($form->isSubmitted() && $form->isValid()){
                        $em->persist($author);
                        $em->flush();
                        return $this->redirectToRoute("list_author");
                    }
                    return $this->render('author/ajouterAuthor.html.twig',['form' => $form->createView()]);
        
                }
                #[Route("/author/editAuthor/{id}", name:'edit_author')]
                public function editAuthor(Request $request, $id, EntityManagerInterface $em, AuthorRepository $authorRepo): Response 
                    {
                        $foundAuthor = $authorRepo->find($id);
                        $form = $this->createForm(AuthorFormType::class, $foundAuthor);
                        $form->handleRequest($request); 
                        if($form->isSubmitted() && $form->isValid()){
                            $em->persist($foundAuthor);
                            $em->flush();
                            return $this->redirectToRoute("list_author");
                        }
                        return $this->render('author/editAuthor.html.twig',['form' => $form->createView()]);
            
                    }
}
