<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Pipeline\Stage;

use League\Pipeline\StageInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\ValidatorTarget;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidatePagePathStage implements StageInterface
{
    public function __invoke($result)
    {
        $subject = $result->getSubject();
        $page = $subject->getObject();

        $path = $page->getBatchPath();

        if ($path) {
            $container = substr($path, 0, strrpos($path, '/'));
            if ($container) {
                $em = \Database::connection()->getEntityManager();
                $r = $em->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page');
                $page = $r->findOneBy(array('batch_path' => $container));
                if (!is_object($page)) {
                    $result->getMessages()->add(
                        new Message(t('Container path %s not found in import batch. A blank container page will be substituted.', $container), Message::E_WARNING)
                    );
                }
            }
        }

        return $result;
    }

}
