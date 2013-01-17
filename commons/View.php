<?php

namespace commons;

class View extends \PHPTAL {

    public function __construct() {
        parent::__construct();
        $this->setEncoding("UTF-8");
        $this->set("title", "Principal");
        $this->set("mainNavItem", "Principal");
        $this->set("base", SITE_URL);
    }

    public function render($template) {
        parent::setTemplate(VIEW_PATH . "/" . $template . ".xhtml");
        echo parent::execute();
        exit;
    }

}