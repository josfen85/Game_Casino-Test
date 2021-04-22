<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SearchgameType;

/**
* @Route("/game", name="game.")
*/

class GameController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {

            return $this->render('game/index.html.twig');
    }

     /**
     * @Route("/showresult", name="showResult")
     */
        //public function showResult($gameName): Response
        public function showResult(Request $request)
        {
                $gameName=trim($request->query->get('gameinput'));
                $path = $this->getParameter('kernel.project_dir') . '/data.json';
                $string = file_get_contents($path);
                $json = json_decode($string, true);
                $game = "NOT FOUND";
                foreach ($json as $row){

                    if(trim($row['name'])== $gameName){
                           $game = $row;
                    }
                }
                return $this->render('game/showResult.html.twig',['game' => $game]);
        }

        /**
             * @Route("/mainMenu", name="mainMenu")
             */
                public function mainMenu(Request $request)
                {
                      $form = $this->createForm(SearchgameType::class);

                      $form ->handleRequest($request);
                      if($form->isSubmitted()  && $form->isValid()){
                            //$em = $this->getDoctrine()->getManager();
                                    echo 'submitted';
                                  //dump($post);


                       return $this->redirect($this->generateUrl('game.index'));

                }

                      return $this->render('game/mainMenu.html.twig', ['form'=>$form->createView()]);
                }
        /**
        * @Route("/listgames", name="listgames")
        */
         public function listgames(Request $request)
           {
                    $path = $this->getParameter('kernel.project_dir') . '/data.json';
                    $string = file_get_contents($path);
                    $json = json_decode($string, true);
                    return $this->render('game/listgames.html.twig', ['games'=>$json]);
           }
}
