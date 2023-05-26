<?php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

final class CommentAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form->add('author')
            ->add('text')
            ->add('createdAt')
            ->add('conference')
            ->add('photoFilename')
            ->add('email')
            ->add('state');        // ... configure $form
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('id')
        ->add('author')
        ->add('text')
        ->add('createdAt')
        ->add('conference')
        ->add('photoFilename')
        ->add('email')
        ->add('state');        
    }
}