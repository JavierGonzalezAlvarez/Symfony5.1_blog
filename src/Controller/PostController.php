<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

//Importamos el formulario y la entidad
use App\Form\PostType;
use App\Entity\Post;
//importar la libreria request
use Symfony\Component\HttpFoundation\Request;


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
        //formulario enviado?
        $form->handleRequest($request);        
        if ($form->isSubmitted() && $form->isValid()) { 
            //he de obtener el valor de user
            $user = $this->getUser();      
            //editar el usuario
            $post->setUser($user); 
            
            
            $form->getData();            
            $grabar = $form->getData();                                       
            //Guardar con Doctrine
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($grabar);
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
}
