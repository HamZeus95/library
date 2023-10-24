<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/book/create-book', name: 'create_book')]
    public function index(Request $request, EntityManagerInterface $emi): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->add('Author', EntityType::class, [
                           'class' => Author::class,
                           'choice_label' => 'username',   
                           'multiple' => false,
                           'expanded' => false
                         ])
                    ->add('ajouter',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { 
            $author = $book->getAuthor();
            $author->setNbBooks($author->getNbBooks() + 1); 
            $book->setIsPublished(true); 
            $emi->persist($book);
            $emi->flush();

            return $this->redirectToRoute('list_books');  
        }
        return $this->render('book/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route("/book/list", name:'list_books')]
    public function listAuthor(BookRepository $bookRepo, ManagerRegistry $doctrine): Response 
        {
             $bookRepo =$doctrine->getRepository(Book::class); 
             $books = $bookRepo->findAll();
             
 
            return $this->render('book/listBooks.html.twig',[
                'books'=>$books,  
                
            ]);

        }
        #[Route("/book/editBook/{ref}", name:'edit_book')]
        public function editBook(Request $request, $ref, EntityManagerInterface $em, BookRepository $bookRepo): Response 
            {
                $foundBook = $bookRepo->find($ref);
                $form = $this->createForm(BookType::class, $foundBook);
                $form->add('isPublished')
                     ->add('Author', EntityType::class, [
                           'class' => Author::class,
                           'choice_label' => 'username',   
                           'multiple' => false,
                           'expanded' => false
                         ])
                    ->add('modifier',SubmitType::class);
                $form->handleRequest($request); 
                
                if($form->isSubmitted() && $form->isValid()){
                    $em->persist($foundBook);
                    $em->flush();
                    return $this->redirectToRoute("list_books");
                }
                return $this->render('book/editBook.html.twig',['form' => $form->createView()]);
    
            }
            #[Route("/book/deleteBook/{ref}", name:'delete_book')] 
            public function deleteAuthor($ref, ManagerRegistry $doctrine) : Response
            {
                $em=$doctrine->getManager();
                $repo= $doctrine->getRepository(Book::class);
                $book=$repo->find($ref);
                $em->remove($book);
                $em->flush();
                $author = $book->getAuthor();
                $author->setNbBooks($author->getNbBooks() - 1); 
                
                if ($author->getNbBooks() == 0 || $author->getNbBooks()==NULL){ 
                    $repo= $doctrine->getRepository(Author::class);
                    $author=$repo->find($author->getId());
                    $em->remove($author);
                    $em->flush();
                }
                return $this->redirectToRoute("list_books");
            }

            #[Route("/bookDetails/{ref}", name:'book_details')]
            public function bookDetails($ref, BookRepository $bookRepo): Response 
                {
 
                        $foundBook = $bookRepo->find($ref);
                        return $this->render('book/bookDetails.html.twig', ['foundBook' => $foundBook]);
                }
}
