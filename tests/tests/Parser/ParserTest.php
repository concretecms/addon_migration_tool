<?php


use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\CIFParser as Parser;

class ParserTest extends MigrationToolTestCase
{
    protected $parser;

    public function setUp()
    {
        parent::setUp();
        $pkg = Concrete\Core\Package\Package::getClass('migration_tool');
        $pkg->on_start();
        $this->parser = new Parser();
    }

    public function testParsePages()
    {
        $collections = $this->parser->getContentObjectCollections(DIR_TEST_FIXTURES . '/cif1.xml');
        foreach($collections as $collection) {
            if ($collection instanceof \PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection) {
                $entities = $collection->getPages();
            }
        }

        $this->assertEquals(21, count($entities));
        /** @var \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page $page */
        $page = $entities[5];
        $this->assertInstanceOf('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page', $page);
        $this->assertEquals('Project Title 4', $page->getName());
        $this->assertEquals('2014-08-06 15:00:00', $page->getPublicDate());
        $this->assertEquals('/portfolio/project-title-4', $page->getOriginalPath());
        $this->assertEquals('', $page->getFilename());
        $this->assertEquals('portfolio_project', $page->getType());
        $this->assertEquals('left_sidebar', $page->getTemplate());
        $this->assertEquals('admin', $page->getUser());
        $this->assertEquals('Pellentesque ultricies ligula vel neque dictum, eu mollis tortor adipiscing.',
            $page->getDescription()
        );
    }

    public function testParsePageAttributes()
    {
        $collections = $this->parser->getContentObjectCollections(DIR_TEST_FIXTURES . '/cif1.xml');
        foreach($collections as $collection) {
            if ($collection instanceof \PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection) {
                $entities = $collection->getPages();
            }
        }
        $this->assertEquals(21, count($entities));
        /** @var \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page $page */
        $page = $entities[2];
        $this->assertEquals('Project Title', $page->getName());
        $this->assertEquals(6, count($page->attributes));
        /* @var \PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageAttribute $page */
        $attribute1 = $page->attributes[2];
        /* @var \PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageAttribute $page */
        $attribute2 = $page->attributes[4];
        $this->assertEquals('project_topics', $attribute1->getAttribute()->getHandle());
        $this->assertXmlStringEqualsXmlString('<attributekey handle="project_topics"><topics><topic>/Homework</topic></topics></attributekey>', $attribute1->getAttribute()->getAttributeValue()->getValue());
        $this->assertEquals('project_tasks', $attribute2->getAttribute()->getHandle());
    }

    public function testParsePageAreaAndBlocks()
    {
        $collections = $this->parser->getContentObjectCollections(DIR_TEST_FIXTURES . '/cif1.xml');
        foreach($collections as $collection) {
            if ($collection instanceof \PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection) {
                $entities = $collection->getPages();
            }
        }

        /** @var \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page $page */
        $page = $entities[10];
        $this->assertEquals('Hello World!', $page->getName());
        $this->assertEquals(5, count($page->areas));
        /* @var \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area $page */
        $area1 = $page->areas[1];
        /* @var \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area $page */
        $area2 = $page->areas[3];
        $this->assertEquals('Main', $area1->getName());
        $this->assertEquals('Sidebar', $area2->getName());

        $blocks = $area1->getBlocks();
        $this->assertEquals(2, count($blocks));
        $this->assertEquals('content', $blocks[1]->getType());
        $this->assertEquals('', $blocks[1]->getName());
    }
}
