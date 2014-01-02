<?php

namespace Pentalog\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    public function indexAction($page) {
        if ($page < 1) {
            // On déclenche une exception NotFoundHttpException
            // Cela va afficher la page d'erreur 404 (on pourra personnaliser cette page plus tard d'ailleurs)
            throw $this->createNotFoundException('Page inexistante (page = ' . $page . ')');
        }
        
        $articles = array(
            array(
                'title' => 'Mon weekend a Phi Phi Island !',
                'id' => 1,
                'author' => 'winzou',
                'content' => 'Ce weekend était trop bien. Blabla…',
                'date' => new \Datetime()),
            array(
                'title' => 'Repetition du National Day de Singapour',
                'id' => 2,
                'author' => 'winzou',
                'content' => 'Bientôt prêt pour le jour J. Blabla…',
                'date' => new \Datetime()),
            array(
                'title' => 'Chiffre d\'affaire en hausse',
                'id' => 3,
                'author' => 'M@teo21',
                'content' => '+500% sur 1 an, fabuleux. Blabla…',
                'date' => new \Datetime())
        );

        return $this->render('PentalogBlogBundle:Blog:index.html.twig', array('articles' => $articles));
    }
    
    public function viewAction($id) {
        $article = array(
            'id'      => 1,
            'title'   => 'Mon weekend a Phi Phi Island !',
            'author'  => 'winzou',
            'content' => 'Ce weekend était trop bien. Blabla…',
            'date'    => new \Datetime()
          );
        return $this->render('PentalogBlogBundle:Blog:view.html.twig', array(
                    'article' => $article,
        ));
    }
    
    public function viewSlugAction($slug, $year, $format) {
        // Ici le content de la méthode
        return new Response("On pourrait afficher l'article correspondant au slug '" . $slug . "', créé en " . $year . " et au format " . $format . ".");
    }
    
    public function addAction() {
        if ($this->get('request')->getMethod() == 'POST') {
            // Ici, on s'occupera de la création et de la gestion du formulaire

            $this->get('session')->getFlashBag()->add('notice', 'Article bien enregistré');

            // Puis on redirige vers la page de visualisation de cet article
            return $this->redirect($this->generateUrl('pentalog_blog_view', array('id' => 5)));
        }
    }
    
    public function editAction() {
        $article = array(
            'id' => 1,
            'title' => 'Mon weekend a Phi Phi Island !',
            'author' => 'winzou',
            'content' => 'Ce weekend était trop bien. Blabla…',
            'date' => new \Datetime()
        );

        // Puis modifiez la ligne du render comme ceci, pour prendre en compte l'article :
        return $this->render('PentalogBlogBundle:Blog:edit.html.twig', array(
                    'article' => $article
        ));
    }
    
    public function deleteAction() {
        return $this->render('PentalogBlogBundle:Blog:delete.html.twig');
    }
    
    public function menuAction($nombre) { // Ici, nouvel argument $nombre, on l'a transmis via le render() depuis la vue
        // On fixe en dur une liste ici, bien entendu par la suite on la récupérera depuis la BDD !
        // On pourra récupérer $nombre articles depuis la BDD,
        // avec $nombre un paramètre qu'on peut changer lorsqu'on appelle cette action
        $list = array(
            array('id' => 2, 'title' => 'Mon dernier weekend !'),
            array('id' => 5, 'title' => 'Sortie de Symfony2.1'),
            array('id' => 9, 'title' => 'Petit test')
        );

        return $this->render('PentalogBlogBundle:Blog:menu.html.twig', array(
                    'articles' => $list // C'est ici tout l'intérêt : le contrôleur passe les variables nécessaires au template !
        ));
    }

}

