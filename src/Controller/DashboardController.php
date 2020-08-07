<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
//para importar los datos de la entidad
use App\Entity\Post;
//use App\Entity\User;
use App\Entity\Comentarios;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index()
    {        
        $user = $this->getUser();  //OBTENGO AL USUARIO ACTUALMENTE LOGUEADO
        //le digo que id queiro consultar
        //$id = $this->setId = 2;
        
        //traer los post de la base de datos
        $entityManager = $this->getDoctrine()->getManager();                
        $consulta = $entityManager
            ->getRepository(Post::class)
            //->findAll();
            ->BuscartodosLosPost();
            //->find($id);            
        
        return $this->render('dashboard/index.html.twig', [
            //pasar todo
            'post' => $consulta,                        

            //pasar un registro seleccionado
                //'id' => $id,
                //'titulo' => $consulta->getTitulo()
                                  
        ]);
    }
}
