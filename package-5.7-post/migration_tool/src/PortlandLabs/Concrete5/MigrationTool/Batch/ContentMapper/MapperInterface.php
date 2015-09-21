<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper;


use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;

defined('C5_EXECUTE') or die("Access Denied.");

interface MapperInterface
{

    public function getMappedItemPluralName();
    public function getHandle();
    public function getItems(Batch $batch);
    public function getTargetItems(Batch $batch);
    public function getMatchedTargetItem(ItemInterface $item);


}