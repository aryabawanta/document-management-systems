<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TemplateManager {

    const POSITION_HEAD = 'HEAD';
    const POSITION_BODY = 'BODY';

    private $title;
    private $layout;
    private $javascript;
    private $stylesheet;
    private $javascriptPosition;
    private $stylesheetPosition;
    private $content;
    private $script;
    private $directory;

    public function __construct($layout = NULL, $directory = NULL, $javascriptPosition = NULL, $stylesheetPosition = NULL) {
        $this->setDirectory(empty($directory) ? 'asset/default/' : $directory);
        $this->setLayout(empty($layout) ? 'layout/default' : $layout);
        $this->setJavascriptPosition(empty($javascriptPosition) ? self::POSITION_BODY : $javascriptPosition);
        $this->setStylesheetPosition(empty($stylesheetPosition) ? self::POSITION_HEAD : $stylesheetPosition);
    }

    public function setDirectory($directory) {
        $this->directory = $directory;
    }

    public function getDirectory() {
        return $this->directory;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getContent() {
        return $this->content;
    }

    public function setLayout($layout) {
        $this->layout = $layout;
    }

    public function getLayout() {
        return $this->layout;
    }

    public function setJavascript($javascript, $position = NULL) {
        if (empty($position)) {
            $position = $this->javascriptPosition;
        }

        if (is_string($javascript)) {
            $this->javascript[$position][] = $javascript;
        } elseif (is_array($javascript)) {
            $this->javascript[$position] = $javascript;
        }
    }

    public function getJavascript($position = NULL) {
        if (empty($position)) {
            $position = $this->javascriptPosition;
        }

        return isset($this->javascript[$position]) ? $this->javascript[$position] : array();
    }

    public function setStylesheet($stylesheet) {
        if (is_string($stylesheet)) {
            $this->stylesheet[] = $stylesheet;
        } elseif (is_array($stylesheet)) {
            $this->stylesheet = $stylesheet;
        }
    }

    public function getStylesheet() {
        return $this->stylesheet;
    }

    public function setJavascriptPosition($javascriptPosition) {
        $this->javascriptPosition = $javascriptPosition;
    }

    public function getJavascriptPosition() {
        return $this->javascriptPosition;
    }

    public function setStylesheetPosition($stylesheetPosition) {
        $this->stylesheetPosition = $stylesheetPosition;
    }

    public function getStylesheetPosition() {
        return $this->stylesheetPosition;
    }

    public function setScript($script, $position = NULL) {
        if (empty($position)) {
            $position = $this->javascriptPosition;
        }

        $this->script[$position][] = $script;
    }

    public function getScript($position = NULL) {
        if (empty($position)) {
            $position = $this->javascriptPosition;
        }

        return $this->script[$position];
    }

    public function buildJavascript($position = NULL) {
        $output = array();
        if (empty($position)) {
            $position = $this->javascriptPosition;
        }

        $javascript = $this->getJavascript($position);
        foreach ($javascript as $js) {
            $output[] = Html::js($js);
        }
        return implode(PHP_EOL, $output);
    }

    public function buildStylesheet() {
        $output = array();
        $stylesheet = $this->getStylesheet();
        foreach ($stylesheet as $css) {
            $output[] = Html::css($css);
        }
        return implode(PHP_EOL, $output);
    }

    public function buildScript($position = NULL) {
        if (empty($position)) {
            $position = $this->javascriptPosition;
        }

        $script = $this->getScript($position);
        return empty($script) ? NULL : Html::tag('script', implode(PHP_EOL, $script), array('type' => 'text/javascript'));
    }

    public function buildHead() {
        return implode(PHP_EOL, array(
            $this->buildStylesheet(),
            $this->buildJavascript(self::POSITION_HEAD),
            $this->buildScript(self::POSITION_HEAD)
        ));
    }

    public function buildBody() {
        return implode(PHP_EOL, array(
            $this->buildJavascript(self::POSITION_BODY),
            $this->buildScript(self::POSITION_BODY)
        ));
    }

    public function render($view, $vars = array(), $layout = NULL, $return = FALSE) {
        $CI = & get_instance();
        $content = $CI->load->view($view, $vars, TRUE);

        $data = Util::arrayMerge($vars, array(
                    'head' => $this->buildHead(),
                    'content' => $content,
                    'body' => $this->buildBody(),
        ));

        if (!isset($data['title']))
            $data['title'] = $this->getTitle();

        if (empty($layout))
            $layout = $this->getLayout();

        return $CI->load->view($layout, $data, $return);
    }

}
