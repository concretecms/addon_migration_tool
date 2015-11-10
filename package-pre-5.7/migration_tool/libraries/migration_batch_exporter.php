<?php

class MigrationBatchExporter
{

	protected $batch;
	protected $parsed = false;
	protected $x;

	public function __construct(MigrationBatch $batch)
	{
		$this->batch = $batch;
	}

	protected function parse()
	{
		Loader::library('content/exporter');
		$this->x = new SimpleXMLElement("<?xml version=\"1.0\" encoding=\"UTF-8\"?><concrete5-cif></concrete5-cif>");
		$this->x->addAttribute('version', '1.0');

		$pages = $this->batch->getPages();
		if (count($pages)) {
			$top = $this->x->addChild('pages');
			foreach($pages as $c) {
				$c->export($top);
			}
		}
	}

	public function getContentXML()
	{
		if (!$this->parsed) {
			$this->parse();
		}
		$xml = $this->x->asXML();
		// this line is screwing up blocks that need to control their output specifically, like markdown
		//$xml = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $xml);
		return $xml;
	}

	/**
	 * Loops through all pages and returns files referenced.
	 */
	public function getReferencedFiles()
	{
		if (!$this->parsed) {
			$this->parse();
		}

		$regExp = '/\{ccm:export:file:(.*?)\}|\{ccm:export:image:(.*?)\}/i';
		$items = array();
		if (preg_match_all(
			$regExp,
			$this->getContentXML(),
			$matches
		)
		) {
			if (count($matches)) {
				for ($i = 1; $i < count($matches); $i++ ) {
					$results = $matches[$i];
					foreach($results as $reference) {
						if ($reference) {
							$items[] = $reference;
						}
					}
				}
			}
		}
		$files = array();
		$db = Loader::db();
		foreach($items as $item) {
			$db = Loader::db();
			$fID = $db->GetOne('select fID from FileVersions where fvFilename = ?', array($item));
			if ($fID) {
				$f = File::getByID($fID);
				if (is_object($f) && !$f->isError()) {
					$files[] = $f;
				}
			}
		}
		return $files;
	}

}