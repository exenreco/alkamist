<?php
# return false if dir failed
if( null === __DIR__ || empty(__DIR__) ):
    return false;
endif;

# The path of tihs file
$root   = __DIR__;
# The path uri of tihs file
$root_uri   = get_template_directory_uri(__DIR__) . "/assets/blocks/copyright-block/assets";
# the path to this block css files
$css    = "$root_uri/css";
# the path to this block js files
$js     = "$root_uri/js";

# Block settings
return array(
    'path'          => $root,
    'block.json'    => "$root/block.json",
    // ,
    // 'options'   => array(
    //     'api_version'           => '2',
    //     'title'                 => 'Copyright Notice',
    //     'category'              => 'text',
    //     'parent'                => [],
    //     'ancestor'              => [],
    //     'icon'                  => '',
    //     'description'           => 'Generates a customizeable block for site copyright text.',
    //     'keywords'              => ['alkamist', 'copyright'],
    //     'textdomain'            => 'alkamist',
    //     'styles'                => '',
    //     'variations'            => [],
    //     'supports'              => array('html', 'gradient', 'color'),
    //     'example'               => array(),
    //     "render_callback"       => "",
    //     'attributes'            => array(),
    //     'uses_context'          => [],
    //     'provides_context'      => '',
    //     'editor_script_handles' => ['alkamist-copyright-notice-editor'],
    //     'script_handles'        => ["$js/script_handles.js"],
    //     'view_script_handles'   => ["$js/view_handles.js"],
    //     'editor_style_handles'  => ["$css/editor_handles.css"],
    //     'style_handles'         => ["$css/style_handles.css"]
    // )
);