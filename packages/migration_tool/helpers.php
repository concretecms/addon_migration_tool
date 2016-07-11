<?php defined('C5_EXECUTE') or die("Access Denied.");

function compat_is_version_8() {
    return interface_exists('\Concrete\Core\Export\ExportableInterface');
}