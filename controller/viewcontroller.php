<?php

namespace College\Ddcollege\Controller;

use College\Ddcollege\Components\components;

class viewcontroller
{
    private $component;

    public function __construct()
    {
        $this->component = new components();
    }

    public function rendersidebar()
    {
        $this->component->SideBar();
    }

    public function script($title)
    {
        $this->component->script($title);
    }

    public function topbar()
    {
        $this->component->Topbar();
    }

    public function OtherJavaScript()
    {
        //down script
        $this->component->OtherJavaScript();
    }
}