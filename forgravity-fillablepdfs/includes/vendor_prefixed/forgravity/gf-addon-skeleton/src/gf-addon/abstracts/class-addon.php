<?php

/**
 * GF addon base class.
 *
 * @since 1.0
 *
 * @package Plugin_Skeleton
 */
namespace ForGravity\Fillable_PDFs\Plugin_Skeleton\GF_Addon\Abstracts;

\defined('ABSPATH') || exit;
if (!\class_exists('GFAddOn')) {
    return;
}
use GFAddOn;
use ForGravity\Fillable_PDFs\Plugin_Skeleton\GF_Addon\Traits\Bootstrap as GF_Addon_Bootstrap_Trait;
use ForGravity\Fillable_PDFs\Plugin_Skeleton\Traits\Licensing as Licensing_Trait;
use ForGravity\Fillable_PDFs\Plugin_Skeleton\Traits\Integrations\Members as Members_Trait;
use ForGravity\Fillable_PDFs\Plugin_Skeleton\Traits\Background_Updates as Background_Updates_Trait;
use ForGravity\Fillable_PDFs\Plugin_Skeleton\GF_Addon\Traits\Plugin_Page as GF_Addon_Plugin_Page_Trait;
/**
 * GF addon base class.
 *
 * @since 1.0
 *
 * @package Plugin_Skeleton
 */
abstract class Addon extends GFAddOn
{
    use GF_Addon_Bootstrap_Trait;
    use Licensing_Trait;
    use Members_Trait;
    use Background_Updates_Trait;
    use GF_Addon_Plugin_Page_Trait;
}
