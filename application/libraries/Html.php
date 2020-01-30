<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Html {

    public static function parseAttribute($attributes = array()) {
        if (!is_array($attributes)) {
            return $attributes;
        }
        $output = array();
        foreach ($attributes as $key => $val) {
            $output[] = $key . '="' . $val . '"';
        }
        return implode(' ', $output);
    }

    public static function openTag($tag, $attributes = array(), $endTag = TRUE) {
        return '<' . $tag . ' ' . self::parseAttribute($attributes) . (!$endTag ? '/' : NULL) . '>';
    }

    public static function endTag($tag) {
        return '</' . $tag . '>';
    }

    public static function tag($tag, $content = NULL, $attributes = array(), $endTag = TRUE) {
        return self::openTag($tag, $attributes, $endTag) . $content . (($endTag) ? self::endTag($tag) : NULL);
    }

    public static function generateDownloadLink($dir, $file) {
        return base_url() . '?data=' . SecurityManager::encode($dir) . '&id=' . SecurityManager::encode($file);
    }

    public static function js($js) {
        if (is_string($js)) {
            $js = array('src' => $js);
        }
        $js['type'] = 'text/javascript';
        return self::tag('script', NULL, $js);
    }

    public static function css($css) {
        if (is_string($css)) {
            $css = array('href' => $css);
        }
        $css['rel'] = 'stylesheet';
        return self::tag('link', NULL, $css, FALSE);
    }

}
