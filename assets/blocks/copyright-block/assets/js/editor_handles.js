(function(wp, $) 
{
    const
    {
        domReady
    } = wp,
    {
        __,
        _x,
        _n,
        _nx,
        sprintf
    } = wp.i18n,

    {
        select,
        dispatch,
        useSelect,
        useDispatch
    } = wp.data,

    {
        render,
        RawHTML,
        Fragment,
        useState,
        useEffect,
        createElement,
        renderToString,
        createInterpolateElement
    } = wp.element,

    {
        parse,
        serialize,
        rawHandler,
        cloneBlock,
        createBlock,
        getBlockType,
        getSaveElement,
        getSaveContent,
        getBlockContent,
        registerBlockType,
        createBlocksFromInnerBlocksTemplate
    } = wp.blocks,

    /**
     * Block Editor
     * All required Block editor features
     */
    {
        RichText,
        InnerBlocks,
        BlockPreview,
        useBlockProps,
        BlockControls,
        InspectorControls,
    } = wp.blockEditor,

    /**
     * Block Components
     * All required Block componients
     */
    {
        __experimentalNumberControl,
        TextareaControl,
        ColorIndicator,
        SelectControl,
        DropdownMenu,
        ColorPalette,
        RadioControl,
        ColorPicker,
        PanelHeader,
        TextControl,
        DatePicker,
        PanelBody,
        PanelRow,
        TabPanel,
        Popover,
        Button,
        Panel,
    } = wp.components,

    // ADD TO EXTRACT AFTER EXPERIMENTAL
    NumberControl = __experimentalNumberControl,

    /**
     * BLOCK ARRAY TO BLOCK
     * 
     * Converts an array of wp template to a wordpress block.
     * 
     * @param {array} template An array of wordpress blocks in array format.
     * 
     * {
     * 
     *  That is a wp InnerBlock template to a block object,
     * 
     *  for example: 
     * 
     *  - [ ['core/paragraph', {}] ] - which converts to a wp paragraph block 
     * 
     *  - [ ['core/group', {}, ['core/paragraph', {}] ] ] - which converts 
     *  to a wp group with a paragraph block.
     * 
     * }
     * 
     * @return {object|null} A react elemet of the created block or null.
     */
    block_array_to_block = function( template = [] )
    {
        if( typeof(template) !== 'object' ) { return null; }

        var atts,  elements = [], children, blockName;

        template.forEach((block, index) =>
        {
            blockName   = block[0];
            atts        = block[1];
            children    = block[2];

            if( blockName && typeof(blockName) === "string" 
            && atts && typeof(atts) === 'object' )
            {
                elements.push((() => (children && typeof(children) === 'object')
                ?
                    createBlock(
                        blockName,
                        ...atts,
                        block_array_to_block(children)
                    )
                :
                    createBlock(
                        blockName,
                        ...atts,
                        null
                    )
                )())
            }
        });

        return elements;
    },

    block_array_to_template = function( template = [] )
    {
        if( typeof(template) !== 'object' ) { return null; }

        var atts,  elements = [], children, blockName;

        template.forEach((block, index) =>
        {
            blockName   = block[0];
            atts        = block[1];
            children    = block[2];

            if( blockName && typeof(blockName) === "string" 
            && atts && typeof(atts) === 'object' )
            {
                elements.push((() => (children && typeof(children) === 'object')
                ?
                    [
                        blockName,
                        {...atts},
                        block_array_to_template(children)
                    ]
                :
                    [
                        blockName,
                        {...atts},
                        null
                    ]
                )())
            }
        });

        return elements;
    },

    PRESET_TEMPLATES = 
    [
        {
            help: '',
            label: '',
            value: [ ['core/group', {}, [ ['core/site-title',{}] ]] ],
        },
    ],

    PRESET_SYMBOLS =
    [
        { value: '©', label: '©', title:'Copyright', help: 'use copyright symbol ©' },
        { value: '®', label: '®', title:'Registered Trademark', help: 'use registered trade mark symbol ®' },
        { value: '™', label: '™', title:'Trademark', help: 'use trade mark symbol ™' },
        { value: '℠', label: '℠', title:'Service Mark', help: 'use service mark symbol ℠' }
    ],

    PRESET_DATE_FORMATS =
    [
        { value: 'current-year', label: `Current Year [ ${ new Date().getFullYear() } ]`, help:'help text' },
        { value: 'year-year', label: `Year - Year [ 1992 - ${ new Date().getFullYear() }]`, help:' help text' },
    ],

    PRESET_DATE_SEPORATORS =
    [
        { value: '-', label: '-', title:'hyphen', help: 'adds a dash between dates' },
        { value: '~', label: '~', title:'tilde', help: 'adds a tilda between dates' },
        { value: '|', label: '|', title:'verbar', help: 'adds a pipe between dates' },
        { value: 'to', label: 'to', title:'to', help: 'adds a "to" between dates' }
    ],

    /**
     * PRESET MAP
     * 
     * An array of copyright presets that allows the
     * user to generate a predefined block.
     * 
     * @return {map} A javascript map object containing a list of presets.
     */
    PresetsMap = (() =>
    {
        const
        map = new Map();

        map.set('simple',
        {
            title: 'Simple',
            label: 'a template that ouly returns the copyright text.',
            template:
            [
                {
                    name: 'core/group',
                    atts:
                    {
                        lock:   { move: true, remove: true },
                        tagName:        'div',
                        className:      'alkamist copyright-group',
                        layout: { type: "flex", orientation: "vertical", justifyContent: "center" }
                    },
                    children:
                    [
                        {
                            name: 'core/site-title',
                            atts:
                            {
                                tagName:        'h6',
                                className:      'alkamist copyright-owner',
                                placeholder:    "Site Title",
                                content:        "Site Title"
                            },
                            children: null
                        }
                    ]
                }
            ]
        });

        map.set('mesmorized', 
        {
            title: 'Mesmorized',
            label: 'a template that replicates the higlight wp theme.',
            template:
            [
                {
                    name: 'core/group',
                    atts:
                    {
                        lock:   { move: true, remove: true },
                        tagName:        'div',
                        className:      'alkamist copyright-group',
                        layout: { type: "flex", orientation: "vertical", justifyContent: "center" }
                    },
                    children:
                    [
                        {
                            name: 'core/site-logo',
                            atts:
                            {
                                tagName:    'img',
                                className:  "alkamist copyright-image is-style-rounded"
                            },
                            children: null
                        },
                        {
                            name: 'core/social-links',
                            atts:
                            {
                                tagName:    'ul',
                                className:  'alkamist copyright-group',
                                align:      'center',
                            },
                            children:
                            [
                                {
                                    name: 'core/social-link',
                                    atts:
                                    {
                                        url:        '#',
                                        align:      'center',
                                        service:    'linkedin',
                                        tagName:    'li',
                                        className:  'alkamist copyright-social-item',
                                    },
                                    children: null
                                },
                                {
                                    name: 'core/social-link',
                                    atts:
                                    {
                                        url:        '#',
                                        align:      'center',
                                        service:    'facebook',
                                        tagName:    'li',
                                        className:  'alkamist copyright-social-item',
                                    },
                                    children: null
                                },
                                {
                                    name: 'core/social-link',
                                    atts:
                                    {
                                        url:        '#',
                                        align:      'center',
                                        service:    'instagram',
                                        tagName:    'li',
                                        className:  'alkamist copyright-social-item',
                                    },
                                    children: null
                                },
                                {
                                    name: 'core/social-link',
                                    atts:
                                    {
                                        url:        '#',
                                        align:      'center',
                                        service:    'twitter',
                                        tagName:    'li',
                                        className:  'alkamist copyright-social-item',
                                    },
                                    children: null
                                },
                            ]
                        }
                    ]
                }
            ]
        });

        map.set('custom', 
        {
            title: 'Custom Blocks',
            label: 'allows custom blocks',
            template:
            [
                {
                    name: 'core/group',
                    atts:
                    {
                        lock:       { move: true, remove: true },
                        tagName:    'div',
                        className:  'alkamist copyright-group',
                        layout:     { type: "flex", orientation: "vertical", justifyContent: "center" }
                    },
                    children:
                    [
                        {
                            name: 'core/paragraph',
                            atts:
                            {
                                tagName:    'p',
                                className:  'alkamist copyright-text',
                                align:      'center', placeholder: 'additionl content...'
                            },
                            children: null
                        }
                    ]
                }
            ]
        });

        return map;
    })(),


    locations_map = (() => 
    {
    })(),


    /**
     * INSRTER CONTENTS && SETTINGS
     * 
     * {
     * 
     *  Creates and controls all block inserter 
     * 
     *  settings and controls.
     * 
     * }
     * 
     * @param {object} attributes An object of block setetings and properties.
     * 
     * @param {function} setAttributes A function used update or set new block attributes.
     * 
     * @since Alkamist 1.0.0
     * 
     * @since WP API version 2
     * 
     * @return {array} the controls and settings of the block inserter.
     */
    inserter = ( attributes, setAttributes ) => 
    {
        /*return createElement(
            BlockPreview,
            {
                blocks:         block_array_to_block(PresetsMap.get('mesmorized').template[0]),
                minHeight:      800,
                viewportWidth:  800,
            }
        );*/
    },

    /**
     * SIDEBAR CONTENTS && SETTINGS
     * 
     * {
     * 
     *  Creates and controls all editor 
     * 
     *  sidebar controls and settings
     * 
     * }
     * 
     * @param {object} attributes An object of block setetings and properties.
     * 
     * @param {function} setAttributes A function used update or set new block attributes.
     * 
     * @since Alkamist 1.0.0
     * 
     * @since WP API version 2
     * 
     * @return {array} the block's blockeditor controls.
     */
    sidebar = function ( attributes, setAttributes, innerBlocks )
    {
        const
        /**
         * STYLEYS PANEL
         * 
         * {
         * 
         *  Returns all block editor controls && settings that 
         * 
         *  enables users to style the block.
         * 
         * }
         * 
         * @since Alkamist 1.0.0
         * 
         * @since WP API version 2
         * 
         * @return {array} An array of react elements to define the blocks styles.
         */
        stylesPanel = (() =>
        {
            const
            /**
             * 
             */
            preset_controls = () =>
            {
                /*const
                template_input = () => createElement(
                    RadioControl,
                    {
                        help:       'The symbol used to indicate the type of copyright.',
                        label:      'Copyright symbol',
                        options:    (() =>
                        {
                            const
                            // date format options
                            options = [];
                            // map date format options
                            PRESET_TEMPLATES.map(
                                (option, index) => 
                                {
                                    const
                                    s = serialize( option.value );

                                    options.push({
                                        label: createElement(
                                            'div',
                                            {
                                            },
                                            s
                                        )
                                    });
                                }
                            );

                            // return date format options
                            return options;
                        })(),
                        className:  'copyright_symbol alkamiist_radio_grid',
                    }
                );
                return createElement(
                    'section',
                    {
                    },
                    createElement(
                        'p',
                        {className: 'decription', style: {fontStyle: 'italic', opacity: '0.65'}},
                        'Choose a template layout to make the copyright block more personalized.',
                        createElement('hr')
                    ),
                    template_input()
                );*/
            },

            copyright_controls = () =>
            {
                const
                symbol_input = () => createElement(
                    'section',{ style: {marginBottom: '28px'} },
                    createElement(
                        RadioControl,
                        {
                            help:       'The symbol used to indicate the type of copyright.',
                            label:      'Copyright symbol',
                            selected:   attributes.copyrightSymbol ? attributes.copyrightSymbol : '©',    
                            onChange:   (selected) => setAttributes({...attributes, copyrightSymbol: selected}),
                            className:  'copyright_symbol alkamiist_radio_grid',
                            options:    (() =>
                            {
                                const
                                // date format options
                                options = [];
                                // map date format options
                                PRESET_SYMBOLS.map(
                                    (option, index) => options.push(option)
                                );
                                // return date format options
                                return options;
                            })()
                        }
                    )
                ),
                copyright_text = () => createElement(
                    'section',{ style: {marginBottom: '28px'} },
                    createElement(
                        TextareaControl,
                        {
                            rows: 2,
                            help: 'The text that comes after the copyright symbol.',
                            label: 'Copyright text or owner name',
                            value: attributes.copyrightText,
                            onChange: (text) => setAttributes({...attributes, copyrightText: text}),
                            placeholder: 'Copyright text or Owner name'
                        }
                    )
                ),
                date_format_input = () => createElement( 
                    'section',{ style: {marginBottom: '28px'} },
                    createElement(
                        SelectControl,
                        {
                            help:           'Select the date format for copyright dates.',
                            label:          'Date format',
                            value:          attributes.dateFormat ? attributes.dateFormat : 'current_year',
                            multiple:       false,
                            onChange:       ( selected ) => setAttributes({
                                ...attributes,
                                dateFormat:     selected,
                                dateEnd:        `${new Date().getFullYear()}`,
                                dateSeparator:  `${PRESET_DATE_SEPORATORS[0].value}`
                            }),
                            options:        (() =>
                            {
                                const
                                // date format options
                                options = [];
                                // map date format options
                                PRESET_DATE_FORMATS.map(
                                    (option, index) => options.push(option)
                                );
                                // return date format options
                                return options;
                            })(),
                            labelPosition:  'top',
                        }
                    )
                ),
                start_date_input = () => createElement(
                    'section',{ style: {marginBottom: '28px'} },
                    createElement(
                        NumberControl,
                        {
                            min:            1900,
                            max:            2099,
                            step:           1,
                            help:           'the first year the subject was copyrighted in.',
                            value:          attributes.dateStart,
                            onChange:       (year) => setAttributes({ ...attributes, dateStart: year }),
                            required:       true,
                            shiftStep:      10,
                            labelPosition:  'top',
                            label:          __(`${(attributes.dateFormat === 'year-year') ? 'Starting' : 'Copyright'} year`, 'alkamist'),
                        },
                    )
                ),
                date_seporator = () => createElement(
                    'section',{ style: {marginBottom: '28px'} },
                    createElement(
                        RadioControl,
                        {
                            help:       'The symbol used to seperate the start and end date.',
                            label:      'Date separator',
                            selected:   attributes.dateSeparator ? attributes.dateSeparator : '-',    
                            onChange:   (selected) => setAttributes({...attributes, dateSeparator: selected}),
                            className:  'date_separator alkamiist_radio_grid',
                            options:    (() =>
                            {
                                const
                                // date format options
                                options = [];
                                // map date format options
                                PRESET_DATE_SEPORATORS.map(
                                    (option, index) => options.push(option)
                                );
                                // return date format options
                                return options;
                            })()
                        }
                    )
                ),
                end_date_input = () => createElement(
                    'section',{ style: {marginBottom: '28px'} },
                    createElement(
                        NumberControl,
                        {
                            min:            1900,
                            max:            2099,
                            step:           1,
                            help:           'the year the subject\'s copyright ends.',
                            value:          attributes.dateEnd,
                            onChange:       (year) => setAttributes({ ...attributes, dateEnd: year }),
                            required:       false,
                            shiftStep:      10,
                            labelPosition:  'top',
                            label:          __('Ending year', 'alkamist'),
                        }
                    )
                ),
                copyright_rights = () => createElement(
                    'section',{ style: {marginBottom: '28px'} },
                    createElement(
                        TextareaControl,
                        {
                            rows: 2,
                            help: 'The text that comes after the copyright statement.',
                            label: 'Copyright rights',
                            value: attributes.copyrightRights,
                            onChange: (text) => setAttributes({...attributes, copyrightRights: text}),
                            placeholder: 'Copyright rights'
                        }
                    )
                ),
                date_group = () => createElement(
                    'section',
                    {
                    },
                    createElement(
                        'p',
                        {className: 'decription', style: {fontStyle: 'italic', opacity: '0.65'}},
                        'Make changes to the copyright block date and date seperator.',
                        createElement('hr')
                    ),
                    symbol_input(),
                    copyright_text(),
                    date_format_input(),
                    (attributes.dateFormat === 'year-year') ? date_seporator() : null,
                    (attributes.dateFormat === 'year-year') ? start_date_input() : null,
                    end_date_input(),
                    copyright_rights()
                );

                return ( date_group() );
            },

            /**
             * STYLES PANEL BODY
             * 
             * The react element that creates the styles panel body
             * 
             * @since Alkamist 1.0.0
             * 
             * @since WP API version 2
             * 
             * @returns {object} a react object that creates the styles panel body.
             */
            styles_panel_body = () => 
            {
                const
                [
                    getCopyrightToggle,
                    setCopyrightToggle
                ] = useState(false),
                [
                    getTemplateToggle,
                    setTemplateToggle
                ] = useState(true);

                return ([
                    createElement(
                        PanelBody,
                        {
                            //icon:           '',
                            title:          'Settings',
                            opened:         getCopyrightToggle,
                            onToggle:       () => setCopyrightToggle(!getCopyrightToggle),
                            className:      '',
                            buttonPros:     {},
                            initialOpen:    getCopyrightToggle
                        },
                        copyright_controls()
                    ),
                    createElement(
                        PanelBody,
                        {
                            //icon:           '',
                            title:          'Templates',
                            opened:         getTemplateToggle,
                            onToggle:       () => setTemplateToggle(!getTemplateToggle),
                            className:      '',
                            buttonPros:     {},
                            initialOpen:    getTemplateToggle
                        },
                        preset_controls()
                    )
                ]);
            },

            /**
             * STYLES PANEL
             * 
             * The react element that creates the styles panel
             * 
             * @since Alkamist 1.0.0
             * 
             * @since WP API version 2
             * 
             * @returns {object} a react element indicating block styles.
             */
            styles_panel = () => createElement(
                Panel,
                {
                    header:     __("Make changes to the sit's copright block.", "alkamist"),
                    className:  'alkamist-copyright-interface',
                },
                styles_panel_body()
            );
            
            /**
             * return react object consists of the 
             * block styles panel
             */
            return styles_panel();
        })(),

        animationsPanel = (() =>
        {
        })(),

        proPanel = (() =>
        {
        })(),

        miscPanel = (() =>
        {
        })(),

        /**
         * UNDEFINED PANEL
         * 
         * {
         * 
         * The tab panel thats returned 
         * 
         * when a panel is invalid or 
         * 
         * undefined.
         * 
         * }
         * 
         * @since Alkamist 1.0.0
         * 
         * @since WP API version 2
         * 
         * @returns {object} a react element indicating panel is undefined.
         */
        undefinedPanel = (() => 
        {
            const
            /**
             * EMPTY TAB
             * 
             * The text that gets displayed when a tab panel is empty.
             * 
             * @since Alkamist 1.0.0
             * 
             * @since WP API version 2
             * 
             * @returns {object} a react element indicating empty panel.
             */
            emptyTab = () => createElement(
                'i',
                {
                    style:
                    {
                        flex:           "1 1 auto",
                        margin:         "auto",
                        display:        "flex",
                        padding:        "4px",
                        position:       "relative",
                        textAlign:      'center',
                        alignItems:     "center",
                        justifyContent: "center",
                    },
                    tagName:    "i",
                    children:   null,
                    className:  "emptyTab copyright"
                },
                'undefined tab panel...'
            ),

            /**
             * EMPTY PANEL
             * 
             * The panel that holds emptyTab text.
             * 
             * @since Alkamist 1.0.0
             * 
             * @since WP API version 2
             * 
             * @returns {object} a react element indicating empty panel.
             */
            emptyPanel = () => createElement(
                Panel,
                {
                    tagName:    "section",
                    className:  "emptyPanel copyright",
                    children:   [emptyTab()]
                },
                emptyTab()
            );

            /**
             * return react Empty tab panel object
             */
            return [emptyPanel()];
        })(),

        /**
         * GET SIDEBAR SELECTED TAB
         * 
         * returns the interface tab option that should be active.
         * 
         * @param {object}tab The interface tab to jump to
         * 
         * @since Alkamist 1.0.0
         * 
         * @since WP API version 2
         * 
         * @return {object} The react object to create
         */
        get_sidebar_selected_tab = (tab) =>
        {
            switch(tab.name)
            { // returns the selected tab
                case 'styles-panel':
                    // styles panel
                    return stylesPanel;
                break;
                case 'animations-panel':
                    // animation panel
                    return animationsPanel;
                break;
                case 'pros-panel':
                    // pros panel
                    return proPanel;
                break;
                case 'misc-panel':
                    // misc panel
                    return miscPanel;
                break;
                default:
                    // undefined panel
                    return undefinedPanel;
                break;
            }
        },

        /**
         * GET SIDEBAR ACTIVE TAB PANEL 
         * :: getSidebarActiveTabPanel
         * the name of the tab that should be active
         * 
         * SET SIDEBAR ACTIVE TAB PANEL 
         * ::setSidebarActiveTabPanel
         * set the name of the new tab that should be active
         * 
         * @param {string} tab The new or current tab name
         * 
         * @since Alkamist 1.0.0
         * 
         * @since WP API version 2
         */
        [
            /**
             * GET SIDEBAR ACTIVE TAB PANEL 
             * :: getSidebarActiveTabPanel
             * the name of the tab that should be active
             */
            getSidebarActiveTabPanel,

            /**
             * SET SIDEBAR ACTIVE TAB PANEL 
             * ::setSidebarActiveTabPanel
             * set the name of the new tab that should be active
             */
            setSidebarActiveTabPanel
        ] = useState('styles-panel'),

        /**
         * 
         */
        sidebar_tab_options = () => createElement(
            TabPanel,
            {
                id:             'alkamist_copyright_interface',
                onSelect:       (tab) => setSidebarActiveTabPanel(tab.name),
                className:      'alkamist-copyright-interface',
                activeClass:    '',
                orientation:    'horizontal',
                selectOnMove:   true,
                initialTabName: getSidebarActiveTabPanel,
                tabs:
                [{
                    //icon:       'svg react',
                    name:       'styles-panel',
                    title:      __('Styles'),
                    disabled:   false,
                    className:  'alkamist-panel copyright-styles-panel',
                },
                {
                    //icon:       'svg react',
                    name:       'animations-panel',
                    title:      __('Animations'),
                    disabled:   false,
                    className:  'alkamist-panel copyright-animations-panel',
                },
                {
                    //icon:       'svg react',
                    name:       'pros-panel',
                    title:      __('Pro'),
                    disabled:   false,
                    className:  'alkamist-panel copyright-pros-panel',
                },
                {
                    //icon:       'svg react',
                    name:       'misc-panel',
                    title:      __('Misc'),
                    disabled:   false,
                    className:  'alkamist-panel copyright-misc-panel',
                }],
            },
            (tab) => get_sidebar_selected_tab(tab)
        ),

        /**
         * 
         */
        sidebar_settings_area = () => createElement(
            InspectorControls,
            {
                className: 'alkamist copyright-inspector',
                children: [sidebar_tab_options()] 
            },
            sidebar_tab_options()
        ),

        /**
         * CONTENT CONTENTS && SETTINGS
         * 
         * {
         * 
         *  Creates and controls all edit && saved block 
         * 
         *  content, settings and controls.
         * 
         * }
         * 
         * @param {object} attributes An object of block setetings and properties.
         * 
         * @param {function} setAttributes A function used update or set new block attributes.
         * 
         * @since Alkamist 1.0.0
         * 
         * @since WP API version 2
         * 
         * @return {array} the block's save and edited contents.
         */
        content = () =>
        {
            const
            template_updater = (templateName) =>
            {
                const temp = ( templateName && PresetsMap.get(templateName) )
                ?
                    PresetsMap.get(templateName).template
                :
                    PresetsMap.get('simple').template
                ;
                return block_array_to_template(temp);
            },

            copyright_updater = ( value ) =>
            {
                setAttributes({
                    ...attributes,
                    copyrightSymbol: attributes.copyrightSymbol,
                });
            },

            /**
             * COPYRIGHT BLOCK
             * 
             * the parent copyright block element.
             */
            copyright_parent_block = () => createElement(
                'section',
                {},
                createElement(
                    InnerBlocks,
                    {}
                ),
                createElement(
                    'p',
                    {
                    },
                    (() => [
                        // copyright symbol
                        (attributes.copyrightSymbol) ? attributes.copyrightSymbol : '',
    
                        // copyright own
                        (attributes.copyrightText) ? ` ${attributes.copyrightText}` : '',
    
                        // seperator and end year
                        ( attributes.dateFormat === 'year-year' 
                        && attributes.dateSeparator
                        && attributes.dateStart )
                        ? ` ${attributes.dateStart} ${attributes.dateSeparator}`
                        : '',

                        // end date
                        attributes.dateEnd ? ` ${attributes.dateEnd}.` : '',

                        createElement('br'),
                        // rights
                        (attributes.copyrightRights)
                        ? `${attributes.copyrightRights}`
                        : ''
                    ])()
                )
            );

            return copyright_parent_block();
        };

        /**
         * An array of react objects that creates the 
         * block interface
         */
        return [sidebar_settings_area(), content()];
    },

    /**
     * EDIT BLOCK
     * 
     * {
     * 
     *  Determins the controls, settings, content and 
     * 
     *  all other related features for the block's editor 
     * 
     *  interface.
     * 
     * }
     * 
     * @param {object} props An object of properties that defines the block
     * 
     * @since Alkamist 1.0.0
     * 
     * @since WP API version 2
     * 
     * @return {array} the block's editor interface and features.
     */
    editBlock = ( props ) =>
    {
        const

        // useDispatch to update the block attributes
        __DISPATCH_BLOCK__ = useDispatch('core/block-editor'),

        /**
         * SELECTED BLOCK
         * 
         * {
         * 
         *  The properties and features of the currently instance 
         * 
         *  of the block selected in the editor.
         * 
         * @since Alkamist 1.0.0
         * 
         * @since WP API version 2
         * 
         * @return {object} the block object when valid.
         * }
         */
        __SELECTED_BLOCK__ = useSelect( (select) => 
            select('core/block-editor').getBlock(props.clientId)
        ),

        /**
         * SELECTED BLOCK ATTRIBUTES && SETATTRIBUTES
         * 
         * extract blocks:
         * 
         *  - attributes
         * 
         *  - setAttributes
         * 
         * from props.
         * 
         * @since Alkamist 1.0.0
         * 
         * @since WP API version 2
         */
        {
            attributes,
            //setAttributes
        } = __SELECTED_BLOCK__,

        {
            setAttributes,
            innerBlocks
        } = props,



        /**
         * BLOCK PROPS
         * 
         * The available block properties
         * 
         * @since Alkamist 1.0.0
         * 
         * @since WP API version 2
         */
        //blockProps = useBlockProps(),
        
        /**
         * Initialize block editor inserter options
         * 
         * @since Alkamist 1.0.0
         * 
         * @since WP API version 2
         */
        block_inserter = inserter( attributes, setAttributes ),

        /**
         * Initialize block editor sidebar options
         * 
         * @since Alkamist 1.0.0
         * 
         * @since WP API version 2
         */
        block_sidebar = sidebar( attributes, setAttributes, innerBlocks ),

        blockProps = useBlockProps();


        /**
         * Returns an array of editor block parts
         */
        return ([block_inserter, block_sidebar ]);
    },

    /**
     * SAVE BLOCK
     * 
     * {
     * 
     *  Determines the contents and layout of 
     * 
     *  the block after it has been saved.
     * 
     * }
     * 
     * @param {object} props An object of properties that defines the block
     * 
     * @since Alkamist 1.0.0
     * 
     * @since WP API version 2
     * 
     * @return {array} the renders of the block when saved.
     */
    saveBlock = ( props ) =>
    {
        const
        /**
         * EXTRACT ATTRIBUTES & SETATTRIBUTES
         * 
         * {
         * 
         *  extract block properties:
         * 
         *  - attributes
         * 
         *  - setAttributes
         * 
         * from props parameter.
         * 
         * }
         * 
         * @since Alkamist 1.0.0
         * 
         * @since WP API version 2
         */
        { attributes, setAttributes } = props,

        /**
         * BLOCK PROPS
         * 
         * on save block properties
         * 
         * @since Alkamist 1.0.0
         * 
         * @since WP API version 2
         */
        //blockProps = useBlockProps().save(),

        blockProps = useBlockProps.save(),

        /**
         * Initialize block frontend saved content.
         * 
         * @since Alkamist 1.0.0
         * 
         * @since WP API version 2
         */
        copyright_parent_block = () => createElement(
            'section',
            {},
            createElement(
                InnerBlocks.Content,
                {
                }
            ),
            createElement(
                'p',
                {
                },
                (() => [
                    // copyright symbol
                    (attributes.copyrightSymbol) ? attributes.copyrightSymbol : '',
    
                    // copyright own
                    (attributes.copyrightText) ? ` ${attributes.copyrightText}` : '',

                    // seperator and end year
                    ( attributes.dateFormat === 'year-year' 
                    && attributes.dateSeparator
                    && attributes.dateStart )
                    ? ` ${attributes.dateStart} ${attributes.dateSeparator}`
                    : '',

                    // end date
                    attributes.dateEnd ? ` ${attributes.dateEnd}.` : '',

                    createElement('br'),
                    // rights
                    (attributes.copyrightRights)
                    ? `${attributes.copyrightRights}`
                    : ''
                ])()
            )
        );

        /**
         * Returns an array of content 
         * for the site's frontend
         */
        return copyright_parent_block();
    },

    /**
     * INITIALIZE BLOCK
     * 
     * {
     * 
     *  Creates the block and its properties for the wp editor and frontend,
     * 
     *  when the dom is loaded and ready.
     * 
     * }
     * 
     * @param {object} wp An object of worpress properties.
     * {
     * 
     *  Contains functions, methods and properties that allows  
     * 
     *  all wp block to be registered.
     * 
     * }
     * 
     * @param {object} wp An instance of jQuery
     * 
     * @since Alkamist 1.0.0
     * 
     * @since WP API version 2
     * 
     * @return {void}
     */
    initializeBlock = () => registerBlockType('alkamist/copyright',
    {
        icon:           'file:./icon.svg',
        name:           'alkamist/copyright',
        title:          'Copyright Block',
        edit:           editBlock,
        save:           saveBlock,
        //render:         renderBlock,
        category:       'common',
        keywords:       ["alkamist", "copyright", "notice", "copyright notice"],
        description:    '',
        api_version:    2,
        supports:       {
            html:       true,
            lock:       false, // Remove support for locking UI.
            anchor:     true,
            inserter:   true,
            multiple:   true, // Use the block just once per post
            reusable:   false, // Don't allow the block to be converted into a reusable block.
            alignWide:  true,
            ariaLabel:  true,
            className:  true,
            align:      true,
            color:
            {
                text:                   true,
                link:                   true,
                background:             true,
                gradients:              true,
                __experimentalDuotone:  '> .overlay'
            },
            spacing:
            {
                margin:     true,    // Enable margin UI control.
                padding:    true,    // Enable padding UI control.
                blockGap:   [ 'horizontal', 'vertical' ],                   // Enables block spacing UI control.
            },
            position:
            {
                sticky: true // Enable selecting sticky position.
            },
            dimensions:
            {
                minHeight: true // Enable min height control.
            },
            typography:
            {
                fontSize:   true,   // Enable support and UI control for font-size.
                lineHeight: true,   // Enable support and UI control for line-height.
            },
        },
        attributes:
        {
            align:
            {
                type: 'string',
                default: 'center'
            },
            layout:
            {
                type: 'flex',
                orientation: "horizotal",
                justifyContent: 'center'
            },
            spacing:
            {
                margin:
                {
                    top: 0,
                    lef: 0,
                    right: 0,
                    bottom: 0,
                },
                padding:
                {
                    top: 0,
                    lef: 0,
                    right: 0,
                    bottom: 0,
                },
                blockGap:
                {
                    vertical: 0,
                    horizontal: 0
                }
            },
            elements:
            {
                link:
                {
                    color:
                    {
                        text: 'red'
                    },
                    ':hover':
                    {
                        text: 'red'
                    },
                    typography:
                    {
                        fontSize: 'inherit',
                        lineHeight: '1.5'
                    },
                },
            },
            demesions:
            {
                minHeight: '30px'
            },
            typography:
            {
                fontSize: 'inherit',
                lineHeight: 'auto'
            },
            
            colors:
            {
                type: 'array',
                default:
                [
                    { name:"", color: "", },
                    { name:"", color: "", },
                    { name:"", color: "", },
                    { name:"", color: "", }
                ]
            },
            style:
            {
                type: 'object',
                default:
                {
                    color:
                    {
                        type: 'object',
                        default:
                        {
                            text: 'inherit',
                            duotone: ['red', 'green'],
                            gradient: '',
                            background: '',
                            backgroundColor: '',
                        }
                    },
                    position:
                    {
                        type: 'object',
                        default:
                        {
                            top: '0px',
                            tpye: 'sticky'
                        }
                    }
                }
            },
            dateFormat:
            {
                type: 'string',
                value: PRESET_DATE_FORMATS[0].value
            },
            dateSeparator:
            {
                type: 'string',
                value: PRESET_DATE_SEPORATORS[0].value,
            },
            dateStart:
            {
                type: 'string',
                default: '2011'
            },
            dateEnd:
            {
                type: 'string',
                default: (() => new Date().getFullYear() )(),
            },
            copyrightSymbol:
            {
                type: 'string',
                default: PRESET_SYMBOLS[0].value
            },
            copyrightText:
            {
                type: 'string',
                default: 'Copyright'
            },
            copyrightRights:
            {
                type: 'string',
                default: 'All rights reserved.'
            }
        }
    });

    /**
     * ANANYMOUSLY INITIALIZE BLOCK
     * 
     * {
     * 
     *  Initializes the block instance on load.
     * 
     *  creates the block instance on dom ready
     * 
     * }
     * 
     * @since Alkamist 1.0.0
     * 
     * @since WP API version 2
     * 
     * @return {void}
     */
    initializeBlock();
})( window.wp, window.jQuery );