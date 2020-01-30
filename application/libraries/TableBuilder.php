<?php

class TableBuilder {

    private $table;
    private $thead;
    private $tbody;
    private $head;
    private $body;

    public function __construct($table = array(), $thead = array(), $tbody = array()) {
        $this->table = $table;
        $this->thead = $thead;
        $this->tbody = $tbody;
    }

    public function setHead($head = array(), $attribute = array()) {
        $this->head[] = array($head, $attribute);
    }

    public function getHead() {
        foreach ($this->head as $row) {
            $output[] = Html::openTag('tr', $row[1]);
            foreach ($row[0] as $cell) {
                if (is_array($cell)) {
                    $output[] = Html::tag('th', $cell[0], $cell[1]);
                } else {
                    $output[] = Html::tag('th', $cell);
                }
            }
            $output[] = Html::endTag('tr');
        }
        return implode(PHP_EOL, $output);
    }

    public function setBody($body = array(), $attribute = array()) {
        $this->body[] = array($body, $attribute);
    }

    public function getBody() {
        foreach ($this->body as $row) {
            $output[] = Html::openTag('tr', $row[1]);
            foreach ($row[0] as $cell) {
                if (is_array($cell)) {
                    $output[] = Html::tag('td', $cell[0], $cell[1]);
                } else {
                    $output[] = Html::tag('td', $cell);
                }
            }
            $output[] = Html::endTag('tr');
        }
        return implode(PHP_EOL, $output);
    }

    public function render() {
        $output = array(
            Html::openTag('table', $this->table),
            Html::tag('thead', $this->getHead(), $this->thead),
            Html::tag('tbody', $this->getBody(), $this->tbody),
            Html::endTag('table')
        );
        return implode(PHP_EOL, $output);
    }

}
