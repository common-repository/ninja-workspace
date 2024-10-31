<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
class Ninjaworkspace_Beaver_Widget extends FLBuilderModule {
    public function __construct()
    {
        parent::__construct(array(
            'name' => __('Ninja Beaver Widget', 'ninjaworkspace'),
            'description' => __('A Ninja Beaver Builder widget with a shortcode.', 'ninjaworkspace'),
            'category' => __('Basic', 'fl-builder'),
            'dir' => __DIR__,
            'partial_refresh' => true,
            'url' => plugins_url('', __FILE__),
            'icon' => 'button.svg',
        ));
    }

}

FLBuilder::register_module('Ninjaworkspace_Beaver_Widget', array());
