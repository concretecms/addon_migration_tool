<?

Loader::model('migration_batch', 'migration_tool');

class DashboardMigrationBatchesExportController extends DashboardBaseController
{

    public function view($id = null)
    {
        if ($id) {
            $batch = MigrationBatch::getByID($id);
        }
        if (is_object($batch)) {
            $exporter = $batch->getExporter();
            $files = $exporter->getReferencedFiles();
            $this->set('batch', $batch);
            $this->set('files', $files);
        } else {
            throw new Exception(t('Invalid batch'));
        }
    }

    public function do_export($id = null)
    {
        if ($id) {
            $batch = MigrationBatch::getByID($id);
        }
        if (is_object($batch)) {

            $exporter = $batch->getExporter();
            $xml = $exporter->getContentXML();
            header('Content-disposition: attachment; filename="export.xml"');
            header('Content-type: "text/xml"; charset="utf8"');
            print $xml;
            exit;
        } else {
            throw new Exception(t('Invalid batch.'));
        }
    }

    public function download_files()
    {
        $id = $_POST['id'];
        if ($id) {
            $batch = MigrationBatch::getByID($id);
        }
        if (!is_object($batch)) {
            $this->error->add(t('Invalid Batch'));
        }
        if (!$this->token->validate("download_files")) {
            $this->error->add($this->token->getErrorMessage());
        }
        $fh = Loader::helper('file');
        $vh = Loader::helper('validation/identifier');
        if (!$this->error->has()) {

            $temp = sys_get_temp_dir();
            if (!$temp) {
                $temp = $fh->getTemporaryDirectory();
            }
            $filename = $temp . '/' . $vh->getString() . '.zip';
            $files = array();
            $filenames = array();
            foreach((array) $_POST['batchFileID'] as $fID) {
                $f = File::getByID(intval($fID));
                if($f->isError()) {
                    continue;
                }
                $fp = new Permissions($f);
                if ($fp->canRead()) {
                    if (!in_array(basename($f->getPath()), $filenames) && file_exists($f->getPath())) {
                        $files[] = $f->getPath();
                    }
                    $filenames[] = basename($f->getPath());
                }
            }
            if(empty($files)) {
                throw new Exception(t("None of the requested files could be found."));
            }
            if(class_exists('ZipArchive', false)) {
                $zip = new ZipArchive;
                $res = $zip->open($filename, ZipArchive::CREATE);
                if($res !== true) {
                    throw new Exception(t('Could not open with ZipArchive::CREATE'));
                }
                foreach($files as $f) {
                    $zip->addFile($f, basename($f));
                }
                $zip->close();
            }
            else {
                $exec = escapeshellarg(DIR_FILES_BIN_ZIP) . ' -j ' . escapeshellarg($filename);
                foreach($files as $f) {
                    $exec .= ' ' . escapeshellarg($f);
                }
                $exec .= ' 2>&1';
                @exec($exec, $output, $rc);
                if($rc !== 0) {
                    throw new Exception(t('External zip failed. Error description: %s', implode("\n", $outout)));
                }
            }
            $fh->forceDownload($filename);
        }
        exit;
    }

    /*
    public function submit()
    {
        $id = $_POST['id'];
        if ($id) {
            $batch = MigrationBatch::getByID($id);
        }
        if (!is_object($batch)) {
            $this->error->add(t('Invalid Batch'));
        }
        if (!$this->token->validate("submit")) {
            $this->error->add($this->token->getErrorMessage());
        }
        if (!$this->error->has()) {

        }
    }
    */

}