<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer;

use voku\helper\UTF8;

trait ParserTrait
{
    /**
     * Get SimpleXMLElement object from file.
     *
     * @param $file name of the file to read
     *
     * @return \SimpleXMLElement
     */
    protected function getXmlContent($file)
    {
        $content = file_get_contents($file);
        $content = $this->prepareXmlString($content);

        return simplexml_load_string($content);
    }

    /**
     * Remove all illegal characters for XML.
     *
     * @see https://www.w3.org/TR/xml11/#charsets
     *
     * @param $string
     *
     * @return string
     */
    protected function prepareXmlString($string)
    {
        $string = preg_replace(
            '/[\\x00-\\x08\\x0b\\x0c\\x0e-\\x1f\\x7f]/',
            '',
            UTF8::to_utf8($string)
        );

        return ($string) ? $string : '';
    }
}
