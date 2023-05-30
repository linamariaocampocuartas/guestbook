<?php

namespace App\Admin;

use App\Entity\Comment;
use App\Entity\Conference;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

final class CommentAdmin extends AbstractAdmin
{

    public function toString(object $object): string
    {
        return $object instanceof Comment
            ? $object->getAuthor() . ' - ' . $object->getConference()
            : 'Comment'; // shown in the breadcrumb on the create view
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->tab('General')
                ->with('Author', ['class' => 'col-md-6'])
                    ->add('author')
                    ->add('email')
                ->end()
                ->with('Speaking of...', ['class' => 'col-md-6'])
                    ->add('conference')
                ->end()            
                ->with('Comment')
                    ->add('photoFilename')
                    ->add('text', TextareaType::class, [
                        'attr' => ['class' => 'tinymce'],
                        'help' => 'Give us your objective opinion.',
                        'label' => 'How did you like the conference?',
                        'row_attr' => ['class' => 'text-editor'],
                    ])
                ->end()
            ->end()
            ->tab('Tracking')
                ->with('Tracking information')
                    ->add('createdAt')
                    ->add('state', ChoiceType::class, [
                        'choices' => [
                            'submitted' => 'submitted',
                            'ham' => 'ham',
                            'potential_spam' => 'potential_spam',
                            'spam' => 'spam',
                            'rejected' => 'rejected',
                            'ready' => 'ready',
                            'published' => 'published',
                        ],
                    ]) 
                ->end()
            ->end();
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('id')
            ->add('conference.slug')
            ->add('author')
            ->add('text', FieldDescriptionInterface::TYPE_HTML)            
            ->add('createdAt')
            ->add('conference')
            ->add('photoFilename')
            ->add('email')
            ->add('state');
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('conference.slug')
            ->add('author')
            ->add('category', null, [
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => Conference::class,
                    'choice_label' => 'slug',
                ],
            ]);
    }    


    protected function configureShowFields(ShowMapper $show): void
    {
        $show
        ->tab('General')
            ->with('Author', ['class' => 'col-md-6'])
                ->add('id')
                ->add('author')
                ->add('email')
            ->end()
            ->with('Speaking of...', ['class' => 'col-md-6'])
                ->add('conference')
            ->end()            
            ->with('Comment')
                ->add('photoFilename')
                ->add('text')
            ->end()
        ->end()
        ->tab('Tracking')
            ->with('Tracking information')
                ->add('createdAt')
                ->add('state')
            ->end()
        ->end();
    }

    protected function configureExportFields(): array
    {
        return ['email', 'author', 'conference.city', 'text'];
    }    


    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        if ($this->isChild()) {
            return;
        }
    }

    
}
