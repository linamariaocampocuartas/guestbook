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
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;

final class ConferenceAdmin extends AbstractAdmin
{
    public function configure(): void{
        $pool = $this->getConfigurationPool();
        $this->addChild($pool->getAdminByAdminCode('admin.comment'));
    }

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

    protected function configureTabMenu(MenuItemInterface $menu, string $action, ?AdminInterface $childAdmin = null): void
    {
        if (!$childAdmin && !in_array($action, ['edit', 'show'])) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');

        $menu->addChild('View Conference', $admin->generateMenuUrl('show', ['id' => $id]));

        if ($this->isGranted('EDIT')) {
            $menu->addChild('Edit Conference', $admin->generateMenuUrl('edit', ['id' => $id]));
        }

        if ($this->isGranted('LIST')) {
            $menu->addChild('Manage Comments', $admin->generateMenuUrl('admin.comment.list', ['id' => $id]));
        }
    }    
}
