<?php

class AssetDefault extends TemplateManager {

    public function __construct($layout = NULL, $directory = NULL, $javascriptPosition = NULL, $stylesheetPosition = NULL) {
        parent::__construct($layout, $directory, $javascriptPosition, $stylesheetPosition);

        //SET JAVASCRIPT
        $this->setJavascript(array(
            base_url() . 'assets/js/jquery-1.10.2.js',
            base_url() . 'assets/js/bootstrap.min.js',
            base_url() . 'assets/js/ripples.min.js',
            base_url() . 'assets/js/material.min.js',
            base_url() . 'assets/js/masonry.pkgd.min.js',
            base_url() . 'assets/js/custom.js',
        ));

        //SET STYLESHEET
        $this->setStylesheet(array(
            base_url() . 'assets/css/bootstrap.min.css',
            base_url() . 'assets/css/roboto.min.css',
            base_url() . 'assets/css/material.min.css',
            base_url() . 'assets/css/ripples.min.css',
            base_url() . 'assets/css/material-fullpalette.css',
            base_url() . 'assets/css/custom.css',
        ));
    }

}
