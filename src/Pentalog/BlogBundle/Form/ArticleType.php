<?php

namespace Pentalog\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Pentalog\BlogBundle\Form\ImageType;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class ArticleType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('date', 'date')
                ->add('title', 'text')
                ->add('author', 'text')
                ->add('content', 'ckeditor')
                ->add('publication', 'checkbox')
                ->add('image', new ImageType())
                ->add('categories', 'entity', array(
                    'class' => 'PentalogBlogBundle:Category',
                    'property' => 'name',
                    'multiple' => true))
        ;

        $factory = $builder->getFormFactory();

        // On ajoute une fonction qui va écouter l'évènement PRE_SET_DATA
        $builder->addEventListener(
                FormEvents::PRE_SET_DATA, // Ici, on définit l'évènement qui nous intéresse
                function(FormEvent $event) use ($factory) { // Ici, on définit une fonction qui sera exécutée lors de l'évènement
                    $article = $event->getData();
                    // Cette condition est importante, on en reparle plus loin
                    if (null === $article) {
                        return; // On sort de la fonction lorsque $article vaut null
                    }
                    // Si l'article n'est pas encore publié, on ajoute le champ publication
                    if (false === $article->getPublication()) {
                        $event->getForm()->add(
                                $factory->createNamed('publication', 'checkbox', null, array('required' => false))
                        );
                    } else { // Sinon, on le supprime
                        $event->getForm()->remove('publication');
                    }
                }
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pentalog\BlogBundle\Entity\Article'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'pentalog_blogbundle_article';
    }

}
