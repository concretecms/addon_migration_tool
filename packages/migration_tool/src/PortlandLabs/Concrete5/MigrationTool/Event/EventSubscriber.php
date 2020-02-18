<?php
namespace PortlandLabs\Concrete5\MigrationTool\Event;

use Concrete\Core\Application\Application;
use Concrete\Core\Application\Service\Dashboard;
use Concrete\Core\Http\ResponseAssetGroup;
use Concrete\Core\Page\View\PageView;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class EventSubscriber implements EventSubscriberInterface
{

    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'on_before_render' => array(
                array('onBeforeRender')
            ),
        );
    }

    public function onBeforeRender(GenericEvent $ev)
    {
        $view = $ev->getArgument('view');
        if ($view && $view instanceof PageView) {
            $dashboard = $this->app->make(Dashboard::class);
            if ($dashboard->inDashboard($view->getPageObject())) {
                $responseAssetGroup = ResponseAssetGroup::get();
                $responseAssetGroup->requireAsset('migration_tool/backend');
            }
        }
    }
    

}
