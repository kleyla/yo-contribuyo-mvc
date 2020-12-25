<?php

class Views
{
    public function getView($controller, $view, $data="")
    {
        $controller = get_class($controller);
        if ($controller == "Home") {
            $view = VIEWS . $view . ".php";
        } else {
            $view = VIEWS . strtolower($controller) . "/" . $view . ".php";
        }
        // echo $view;
        require_once($view);
    }
}
