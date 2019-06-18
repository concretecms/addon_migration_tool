<?php

defined('C5_EXECUTE') or die("Access Denied.");

if (!function_exists('compat_is_version_8')) {
    function compat_is_version_8()
    {
        return interface_exists('\Concrete\Core\Export\ExportableInterface');
    }
}

if (!function_exists('compat_supports_site_types')) {
    function compat_supports_site_types()
    {
        return class_exists('\Concrete\Core\Export\Item\SiteType');
    }
}
