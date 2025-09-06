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
/**
 * GF addon base class.
 *
 * @since 1.0
 *
 * @package Plugin_Skeleton
 */
abstract class Addon_No_Plugin_Page extends GFAddOn
{
    use GF_Addon_Bootstrap_Trait;
    use Licensing_Trait;
    use Members_Trait;
    use Background_Updates_Trait;
    /**
     * Prepare plugin settings fields.
     *
     * @since  1.0
     *
     * @return array
     */
    public function plugin_settings_fields()
    {
        return [['title' => \sprintf(esc_html__('%s Settings', 'cosmicgiant'), $this->get_short_title()), 'fields' => $this->get_license_settings_fields()]];
    }
    /**
     * Return the plugin's icon for the plugin/form settings menu.
     *
     * @since 1.0
     *
     * @return string
     */
    public function get_menu_icon()
    {
        return \file_get_contents($this->get_base_path() . '/dist/images/menu-icon.svg');
    }
}
