<?

class DashboardMigrateController extends Controller
{
    protected $x;

    public function submit()
    {
        Loader::library('content/exporter');
        $this->x = new SimpleXMLElement("<?xml version=\"1.0\" encoding=\"UTF-8\"?><concrete5-cif></concrete5-cif>");
        $this->x->addAttribute('version', '1.0');

        $startingPoint = Page::getByID($_REQUEST['startingPoint']);
        if (is_object($startingPoint) && !$startingPoint->isError()) {
            $top = $this->x->addChild('pages');
            // Get all pages beneath here.
            $pages = $startingPoint->getCollectionChildrenArray();
            foreach($pages as $cID) {
                $c = Page::getByID($cID);
                $c->export($top);
            }

            $xml = $this->x->asXML();
            $xml = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $xml);

            header('Content-type: text/xml');
            print $xml;
            exit;
        }
    }

    /*
    public function get_content_xml()
    {

        Loader::library("content/exporter");
        $export = new ContentExporter();
        $export->run();
        $export->removeItem('packages', 'package', 'sample_content_generator');
        $export->removeItem('singlepages', 'page', 'sample_content_generator');
        // check packages
        $xml = $export->output();

        $th = Loader::helper('text');
        $xml = $th->formatXML($xml);

        $this->set('outputContent', $xml);
    }
    */


}