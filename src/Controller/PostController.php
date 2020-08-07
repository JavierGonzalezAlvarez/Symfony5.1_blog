<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

//Importamos el formulario y la entidad
use App\Form\PostType;
use App\Entity\Post;
//importar la libreria request
use Symfony\Component\HttpFoundation\Request;
//importar clases para FILE
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\AsciiSlugger;

class PostController extends AbstractController
{
    /**
     * @Route("/post_nuevo", name="postnuevo")
     */
    public function index(Request $request)
    {
        //Creamos un objeto
        $post = new Post;
        $form = $this->createForm(PostType::class, $post);                

        //$form->getData();            
        //$grabar = $form->getData();                                       

        //formulario enviado?
        $form->handleRequest($request);        
        if ($form->isSubmitted() && $form->isValid()) { 
            
            /** @var UploadedFile $file */
            $file = $form->get('foto')->getData();
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL

                $slugger = new AsciiSlugger();

                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

                // Move the file to the directory where files are stored
                try {
                    $file->move(
                        $this->getParameter('directorio_fotos'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                    throw new \Exception(message, 'ha sucedido un error');
                }
                // updates the 'Filename' property to store the PDF file name
                // instead of its contents
                $post->setFoto($newFilename);
}

            //he de obtener el valor de user
            $user = $this->getUser();      
            //editar el usuario
            $post->setUser($user); 
                        
            
            //Guardar con Doctrine
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            //$entityManager->persist($grabar);
            $entityManager->flush();            

            //mejor meterlo en una constante
            $this->addFlash('mensaje', Post::REGISTRO_EXITOSO);
            
            //Esta ruta está en Dashboardcontrollert.php
            return $this->redirectToRoute('dashboard');        
        }
        
        return $this->render('post/index.html.twig', [
            //'form' => 'form_post',
            //'controller_name' => 'Nuevo post',
            'formulario_post' => $form->createview()
        ]);
    }


    //Ver 1 post de un usuario

    /**
     * @Route("/ver_post/{id}", name="verpost")
     */
    public function ver_post($id)
    {
        //recojo el usuario
        $user = $this->getUser();                      

        $em = $this->getDoctrine()->getManager();
        $post = $em
            ->getRepository(Post::class)
            ->find($id);

        return $this->render('post/ver_post.html.twig', [                        
            'post' => $post, 
            'id' => $id,
            'titulo' => $post->getTitulo(),     
            'contenido' => $post->getContenido()     
        ]);                         
    }

    //Ver todos los post de un usuario
      /**
     * @Route("/ver_todos_post/", name="vertodospost")
     */
    public function ver_todos_post()
    {
        //recojo el usuario
        $user = $this->getUser();                      

        $em = $this->getDoctrine()->getManager();
        $post = $em
            ->getRepository(Post::class)
            ->findBy(['user'=>$user]);

        return $this->render('post/ver_todos_post.html.twig', [                        
            'post' => $post             
        ]);                         
    }




}
