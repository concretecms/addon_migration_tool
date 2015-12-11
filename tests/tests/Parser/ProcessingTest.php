<?php

class ProcessingTest extends MigrationToolTestCase
{
    protected function getSampleBatch()
    {
        $data = array(
            array('Page 1', '/ok/this/home/about/test'),
            array('Page 2', '/ok/this/home/two'),
            array('Page 3', '/ok/this/home/about/heres-something-fun'),
            array('Page 4', '/ok/this/home/about/test-two'),
            array('Page 5', '/ok/this/one/more/time'),
            array('Page 6', '/ok/this/more/time'),
            array('Page 7', '/ok/this/abba/test'),
            array('Page 8', '/ok/this/dorp/test'),
            array('Page 9', '/ok/this/about/about/test'),
        );
        $batch = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch();
        $collection = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection();

        foreach ($data as $r) {
            $page = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page();
            $page->setName($r[0]);
            $page->setOriginalPath($r[1]);
            $collection->getPages()->add($page);
            $batch->getObjectCollections()->add($collection);
        }

        return $batch;
    }

    public function testLinkNormalizationYear()
    {
        $data = array(
            array('Foo', '/2014/foo'),
            array('Bar', '/2015/bar'),
        );
        $batch = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch();
        $collection = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection();

        foreach ($data as $r) {
            $page = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page();
            $page->setName($r[0]);
            $page->setOriginalPath($r[1]);
            $collection->getPages()->add($page);
            $batch->getObjectCollections()->add($collection);
        }

        $this->assertEquals(2, $batch->getObjectCollections()->get(0)->getPages()->count());

        $target = new \PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Target($batch);
        $processor = new \Concrete\Core\Foundation\Processor\Processor($target);
        $processor->registerTask(new \PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task\NormalizePagePathsTask());
        $processor->process();

        $pages = $batch->getPages();

        // The normalization saves a batch_patch without the common bit, in this case without the string '/20' of the original path
        $this->assertEquals('4/foo', $pages[0]->getBatchPath());
        $this->assertEquals('5/bar', $pages[1]->getBatchPath());
    }

    public function testLinkNormalization()
    {
        $batch = $this->getSampleBatch();
        $this->assertEquals(9, $batch->getObjectCollections()->get(0)->getPages()->count());

        $target = new \PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Target($batch);
        $processor = new \Concrete\Core\Foundation\Processor\Processor($target);
        $processor->registerTask(new \PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task\NormalizePagePathsTask());
        $processor->process();

        $pages = $batch->getPages();
        $this->assertEquals('/home/about/test', $pages[0]->getBatchPath());
        $this->assertEquals('/home/about/heres-something-fun', $pages[2]->getBatchPath());
        $this->assertEquals('/home/about/test-two', $pages[3]->getBatchPath());
        $this->assertEquals('/more/time', $pages[5]->getBatchPath());
        $this->assertEquals('/abba/test', $pages[6]->getBatchPath());
        $this->assertEquals('/about/about/test', $pages[8]->getBatchPath());
    }
}
