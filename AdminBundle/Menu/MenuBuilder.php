<?php

namespace AdminBundle\Menu;

class MenuBuilder
{
    /**
     * @var \Knp\Menu\FactoryInterface
     */
    public $factory;

    /**
     * @var \Symfony\Component\Security\Core\SecurityContext
     */
    public $security;

    /**
     * Menu builder
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function createMenu()
    {
        $menu = $this->factory->createItem('menu');
        
        $menu->addChild('home', [
            'label' => 'nav.admin_panel',
            'route' => 'admin_homepage',
        ]);

        $menu->addChild('manage_events', [
            'label' => 'nav.manage_events',
            'route' => 'admin_registration_events_list',
        ]);
        
        $menu->addChild('logout', [
            'route' => 'admin_logout',
            'label' => 'admin.logout',
        ]);
        
        return $menu;
    }
}