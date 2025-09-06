<?php

/**
 * Members plugin integration.
 *
 * @since   1.0
 *
 * @package Plugin_Skeleton
 */
namespace ForGravity\Fillable_PDFs\Plugin_Skeleton\Traits\Integrations;

/**
 * Members plugin integration.
 *
 * @since   1.0
 *
 * @package Plugin_Skeleton
 */
trait Members
{
    /**
     * Get the Members capabilities prefix.
     *
     * @since 1.0
     *
     * @return string
     */
    protected abstract function get_members_cap_prefix();
    /**
     * Register the CosmicGiant capabilities group with the Members plugin.
     *
     * @since 1.0
     */
    public function members_register_cap_group()
    {
        members_register_cap_group('cosmicgiant', ['label' => esc_html('CosmicGiant'), 'icon' => 'dashicons-forgravity', 'caps' => []]);
    }
    /**
     * Register the capabilities and their human readable labels wit the Members plugin.
     *
     * @since 1.0
     */
    public function members_register_caps()
    {
        // Define capabilities for the add-on.
        $caps = [$this->get_members_cap_prefix() => esc_html__('Manage Settings', 'cosmicgiant'), $this->get_members_cap_prefix() . '_uninstall' => esc_html__('Uninstall', 'cosmicgiant')];
        // Register capabilities.
        foreach ($caps as $cap => $label) {
            members_register_cap($cap, ['label' => \sprintf('%s: %s', $this->get_short_title(), $label), 'group' => 'cosmicgiant']);
        }
    }
}
