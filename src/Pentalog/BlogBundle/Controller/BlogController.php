<?php

namespace Pentalog\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Pentalog\BlogBundle\Entity\Article;
use Pentalog\BlogBundle\Entity\Image;
use Pentalog\BlogBundle\Form\ArticleType;
use Pentalog\BlogBundle\Form\ArticleEditType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sdz\BlogBundle\Bigbrother\BigbrotherEvents;
use Sdz\BlogBundle\Bigbrother\MessagePostEvent;

class BlogController extends Controller {

    public function indexAction($page) {
        if ($page < 1) {
            // On déclenche une exception NotFoundHttpException
            // Cela va afficher la page d'erreur 404 (on pourra personnaliser cette page plus tard d'ailleurs)
            throw $this->createNotFoundException('Page inexistante (page = ' . $page . ')');
        }

        $articles = $this->getDoctrine()->getManager()->getRepository('PentalogBlogBundle:Article')->getArticles(3, $page);

        return $this->render('PentalogBlogBundle:Blog:index.html.twig', array(
                    'articles' => $articles,
                    'page' => $page,
                    'pageNumber' => ceil(count($articles) / 1)
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

    /**
     * @Secure(roles="ROLE_AUTHOR")
     * @return type
     */
    public function addAction() {

        $article = new Article();
        $form = $this->createForm(new ArticleType, $article);

        // On récupère la requête
        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                // On crée l'évènement avec ses 2 arguments
//                $event = new MessagePostEvent($article->getContent(), $article->getUser());
//
//                // On déclenche l'évènement
//                $this->get('event_dispatcher')
//                        ->dispatch(BigbrotherEvents::onMessagePost, $event);
//
//                // On récupère ce qui a été modifié par le ou les listeners, ici le message
//                $article->setContent($event->getMessage());
                // On l'enregistre notre objet $article dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                $this->get('session')->getFlashBag()->add('notice', 'Article bien enregistré');

                // On redirige vers la page de visualisation de l'article nouvellement créé
                return $this->redirect($this->generateUrl('pentalog_blog_view', array('slug' => $article->getSlug())));
            }
        }
        return $this->render('PentalogBlogBundle:Blog:add.html.twig', array(
                    'form' => $form->createView()
                ));
    }

    public function editAction(Article $article) {

        $form = $this->createForm(new ArticleEditType(), $article);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                // On l'enregistre notre objet $article dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                $this->get('session')->getFlashBag()->add('notice', 'Article bien enregistré');

                // On redirige vers la page de visualisation de l'article nouvellement créé
                return $this->redirect($this->generateUrl('pentalog_blog_view', array('slug' => $article->getSlug())));
            }
        }

        // Puis modifiez la ligne du render comme ceci, pour prendre en compte l'article :
        return $this->render('PentalogBlogBundle:Blog:edit.html.twig', array(
                    'article' => $article,
                    'form' => $form->createView()
                ));
    }

    public function deleteAction(Article $article) {
        $form = $this->createFormBuilder()->getForm();
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($article);
                $em->flush();

                $this->get('session')->getFlashBag()->add('notice', 'Article successfully removed');
                return $this->redirect($this->generateUrl('pentalog_blog_homepage'));
            }
        }
        return $this->render('PentalogBlogBundle:Blog:delete.html.twig', array('form' => $form->createView(), 'article' => $article));
    }

    public function menuAction($number) {

        $list = $this->getDoctrine()->getManager()->getRepository('PentalogBlogBundle:Article')->findBy(
                array(), array('date' => 'DESC'), $number, 0);

        return $this->render('PentalogBlogBundle:Blog:menu.html.twig', array(
                    'articles' => $list // C'est ici tout l'intérêt : le contrôleur passe les variables nécessaires au template !
                ));
    }

    public function translateAction($name) {
        return $this->render('PentalogBlogBundle:Blog:translate.html.twig', array(
                    'name' => $name
                ));
    }

}
