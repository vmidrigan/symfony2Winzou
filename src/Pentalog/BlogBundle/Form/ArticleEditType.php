<?php

namespace Pentalog\BlogBundle\Form;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleEditType extends ArticleType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        $builder->remove('date');
    }

    /**
     * @return string
     */
    public function getName() {
        return 'pentalog_blogbundle_article_edit';
    }

}
