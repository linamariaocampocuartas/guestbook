<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

final class ConferenceAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('city', TextType::class, [
                'label' => 'City',
                'required' => true,
            ])
            ->add('year', TextType::class, [
                'label' => 'Year',
                'required' => true,
            ])
            ->add('isInternational', CheckboxType::class, [
                'label' => 'Is International?',
                'required' => false,
            ])
            ->add('slug', TextType::class, [
                'label' => 'Slug',
                'required' => true,
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('city')
            ->add('year')
            ->add('isInternational')
            ->add('slug');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id')
            ->add('city')
            ->add('year')
            ->add('isInternational')
            ->add('slug')
            ->add('comments', FieldDescriptionInterface::TYPE_ARRAY, [
                'inline' => false,
                'display' => 'values'
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('city')
            ->add('year')
            ->add('isInternational')
            ->add('slug')
            ->add('comments');
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->remove('delete');
    }
}
