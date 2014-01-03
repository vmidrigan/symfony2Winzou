<?php

namespace Pentalog\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Pentalog\BlogBundle\Entity\Article;
use Pentalog\BlogBundle\Entity\Image;

class BlogController extends Controller {

    public function indexAction($page) {
        if ($page < 1) {
            // On déclenche une exception NotFoundHttpException
            // Cela va afficher la page d'erreur 404 (on pourra personnaliser cette page plus tard d'ailleurs)
            throw $this->createNotFoundException('Page inexistante (page = ' . $page . ')');
        }

        $articles = $this->getDoctrine()->getManager()->getRepository('PentalogBlogBundle:Article')->getArticles(1, $page);

        return $this->render('PentalogBlogBundle:Blog:index.html.twig', array(
            'articles' => $articles,
            'page'       => $page,
            'pageNumber' => ceil(count($articles)/1)
            ));
    }

    public function viewAction(Article $article) {
        $em = $this->getDoctrine()
                ->getManager();

        // On récupère les articleCompetence pour l'article $article
        $compList = $em->getRepository('PentalogBlogBundle:ArticleCompetence')
                ->findByArticle($article->getId());

        return $this->render('PentalogBlogBundle:Blog:view.html.twig', array(
                    'article' => $article,
                    'competences' => $compList
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
            return $this->redirect($this->generateUrl('pentalog_blog_view', array('id' => $article->getId())));
        }
        return $this->render('PentalogBlogBundle:Blog:add.html.twig');
    }

    public function editAction(Article $article) {

        // Puis modifiez la ligne du render comme ceci, pour prendre en compte l'article :
        return $this->render('PentalogBlogBundle:Blog:edit.html.twig', array(
                    'article' => $article
        ));
    }

    public function deleteAction(Article $article) {
        
        $em = $this->getDoctrine()->getManager();
        
        if ($this->get('request')->getMethod() == 'POST') {
            $em->remove($article);

            $this->get('session')->getFlashBag()->add('notice', 'Article successfully removed');
            return $this->redirect($this->generateUrl('pentalog_blog_homepage'));
        }
        
        return $this->redirect('PentalogBlogBundle:Blog:delete.html.twig', array('article' => $article));
    }

    public function menuAction($number) {
        
        $list = $this->getDoctrine()->getManager()->getRepository('PentalogBlogBundle:Article')->findBy(
                array(),
                array('date' => 'DESC'),
                $number,
                0);

        return $this->render('PentalogBlogBundle:Blog:menu.html.twig', array(
                    'articles' => $list // C'est ici tout l'intérêt : le contrôleur passe les variables nécessaires au template !
        ));
    }

}
