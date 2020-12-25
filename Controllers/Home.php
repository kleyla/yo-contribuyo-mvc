<?php

class Home extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function home($params)
    {
        // echo "mensaje desde el controlador";
        $data["tag_name"] = "Home";
        $data["page_title"] = "Pagina principal";
        $data["page_name"] = "home";
        $data["page_content"] = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse exercitationem ratione obcaecati voluptatibus. Quidem minus iste totam id recusandae, sapiente, consequatur at hic eius repudiandae soluta deserunt commodi ab voluptate?";
        $this->views->getView($this, "home", $data);
    }
    public function getDatet()
    {
        $fecha = date('Format String', time());
        echo $fecha;
    }
}
