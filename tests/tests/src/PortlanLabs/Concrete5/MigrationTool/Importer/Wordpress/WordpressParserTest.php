<?php

use PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\WordpressParser as Parser;

class WordpressParserTest extends MigrationToolTestCase
{
    protected $parser;

    public function setUp()
    {
        $this->error = new \Concrete\Core\Error\Error();
        libxml_clear_errors();

        parent::setUp();
        $pkg = Concrete\Core\Package\Package::getClass('migration_tool');
        $pkg->on_start();
        $this->parser = new Parser();
    }

    public function testValidateWrongFileExtension()
    {
        $file = array(
            'type' => 'text/html',
            'tmp_name' => DIR_TEST_FIXTURES . '/wordpress-correct.xml'
        );

        $this->parser->validateUploadedFile($file, $this->error);
        $this->assertEquals($this->error->offsetGet(0), 'File does not appear to be an XML file.');
    }

    public function testValidateWronglyFormattedXML()
    {
        $file = array(
            'type' => 'text/xml',
            'tmp_name' => DIR_TEST_FIXTURES . '/wordpress-xml-incorrect.xml'
        );

        $this->parser->validateUploadedFile($file, $this->error);

        // Expect 3 XML format errors
        $this->assertCount(3, $this->error->getList());
    }

    public function testValidateMissingWXRVersion()
    {
        $file = array(
            'type' => 'text/xml',
            'tmp_name' => DIR_TEST_FIXTURES . '/wordpress-wxr-incorrect-version.xml'
        );

        $this->parser->validateUploadedFile($file, $this->error);
        $this->assertEquals($this->error->offsetGet(0), 'Missing or invalid WXR version number');
    }

    public function testValidateCorrectWXR()
    {
        $file = array(
            'type' => 'text/xml',
            'tmp_name' => DIR_TEST_FIXTURES . '/wordpress-correct.xml'
        );

        $this->parser->validateUploadedFile($file, $this->error);
        $this->assertCount(0, $this->error->getList());
    }

    public function testParseContent()
    {
        $file = array(
            'type' => 'text/xml',
            'tmp_name' => DIR_TEST_FIXTURES . '/wordpress-correct.xml'
        );

        $this->parser->validateUploadedFile($file, $this->error);

        $collections = $this->parser->getContentObjectCollections();

        // Expecting 60 new pages and posts on the collection
        $this->assertCount(60, $collections[0]->pages);
    }

    // TODO create tests for things that might be missed inside pages, like empty titles. Maybe these cases
    // just need to be reported and not error to the user, so they can be presented on the report page.
    // TODO test or expect some methods to be called inside? like block creation for content or other blocks?
    // TODO test also the import and creation of pages from the batch? This way we'll go full circle
}
