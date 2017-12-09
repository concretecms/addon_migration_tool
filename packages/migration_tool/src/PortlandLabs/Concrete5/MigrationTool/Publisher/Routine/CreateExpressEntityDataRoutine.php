<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Entity\Express\Entity;
use Concrete\Core\Entity\Express\Form;
use Concrete\Core\Entity\Express\ManyToManyAssociation;
use Concrete\Core\Entity\Express\ManyToOneAssociation;
use Concrete\Core\Entity\Express\OneToManyAssociation;
use Concrete\Core\Entity\Express\OneToOneAssociation;
use Concrete\Core\Entity\Sharing\SocialNetwork\Link;
use Concrete\Core\Express\ObjectAssociationBuilder;
use Doctrine\ORM\Id\UuidGenerator;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Association;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateExpressEntityDataRoutine extends AbstractRoutine
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $entities = $batch->getObjectCollection('express_entity');


        if (!$entities) {
            return;
        }

        $em = \Database::connection()->getEntityManager();
        $em->getClassMetadata('Concrete\Core\Entity\Express\Form')->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());

        /**
         * @var $entity \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Entity
         */
        foreach ($entities->getEntities() as $entity) {
            /**
             * @var $publishedEntity Entity
             */
            $publishedEntity = \Express::getObjectByID($entity->getID());
            if ($publishedEntity) {
                // Create the associations.
                /**
                 * @var $association Association
                 */
                foreach($entity->getAssociations() as $association) {
                    $targetEntity = \Express::getObjectByID($association->getTargetEntity());
                    switch($association->getType()) {
                        case 'one_to_one':
                            $publishedAssociation = new OneToOneAssociation();
                            break;
                        case 'one_to_many':
                            $publishedAssociation = new OneToManyAssociation();
                            break;
                        case 'many_to_one':
                            $publishedAssociation = new ManyToOneAssociation();
                            break;
                        default:
                            $publishedAssociation = new ManyToManyAssociation();
                            break;
                    }
                    $publishedAssociation->setSourceEntity($publishedEntity);
                    $publishedAssociation->setTargetEntity($targetEntity);
                    $publishedAssociation->setInversedByPropertyName($association->getInversedByPropertyName());
                    $publishedAssociation->setTargetPropertyName($association->getTargetPropertyName());

                    $em->persist($publishedAssociation);
                    $em->flush();
                }

                // Create the attribute keys
                $keys = $entity->getAttributeKeys();
                if ($keys) {
                    foreach($keys->getKeys() as $key) {
                        $category = $key->getCategory();
                        if (is_object($category)) {
                            $publisher = $category->getPublisher();
                            $o = $publisher->publish($key);
                            $typePublisher = $key->getTypePublisher();
                            $typePublisher->publish($key, $o);
                        }
                    }
                }
                // Create the forms.
                /**
                 * @var $form Form
                 */
                foreach($entity->getForms() as $form) {
                    $publishedForm = new Form();
                    $publishedForm->setId($form->getId());
                    $publishedForm->setName($form->getName());
                    $publishedForm->setEntity($publishedEntity);
                    $em->persist($publishedForm);
                    $em->flush();
                }

                // default forms
                if ($entity->getDefaultEditFormId()) {
                    $defaultEditForm = $em->find(Form::class, $entity->getDefaultEditFormId());
                    if ($defaultEditForm) {
                        $publishedEntity->setDefaultEditForm($defaultEditForm);
                        $em->persist($publishedEntity);
                    }
                }
                if ($entity->getDefaultViewFormId()) {
                    $defaultViewForm = $em->find(Form::class, $entity->getDefaultViewFormId());
                    if ($defaultViewForm) {
                        $publishedEntity->setDefaultViewForm($defaultViewForm);
                        $em->persist($publishedEntity);
                    }
                }
                $em->flush();
            }
        }

        $em->getClassMetadata('Concrete\Core\Entity\Express\Entity')->setIdGenerator(new UuidGenerator());

    }
}
