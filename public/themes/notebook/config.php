<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Inherit from another theme
    |--------------------------------------------------------------------------
    |
    | Set up inherit from another if the file is not exists,
    | this is work with "layouts", "partials", "views" and "widgets"
    |
    | [Notice] assets cannot inherit.
    |
    */

    'inherit' => null, //default

    /*
    |--------------------------------------------------------------------------
    | Listener from events
    |--------------------------------------------------------------------------
    |
    | You can hook a theme when event fired on activities
    | this is cool feature to set up a title, meta, default styles and scripts.
    |
    | [Notice] these event can be override by package config.
    |
    */

    'events' => array(

        // Before event inherit from package config and the theme that call before,
        // you can use this event to set meta, breadcrumb template or anything
        // you want inheriting.
        'before' => function($theme)
        {
            $theme->set('title', 'VPA System');
            $theme->set('keywords', 'VPA System');
            $theme->set('description', 'Vendor Performance Appraisal System');

            // Breadcrumb template.
            // $theme->breadcrumb()->setTemplate('
            //     <ul class="breadcrumb">
            //     @foreach ($crumbs as $i => $crumb)
            //         @if ($i != (count($crumbs) - 1))
            //         <li><a href="{{ $crumb["url"] }}">{{ $crumb["label"] }}</a><span class="divider">/</span></li>
            //         @else
            //         <li class="active">{{ $crumb["label"] }}</li>
            //         @endif
            //     @endforeach
            //     </ul>
            // ');
        },

        // Listen on event before render a theme,
        // this event should call to assign some assets,
        // breadcrumb template.
        'beforeRenderTheme' => function($theme)
        {
            // ie9 compatibility
            $theme->asset()->container('ie9')->usePath()->add('html5shiv', 'js/ie/html5shiv.js');
            $theme->asset()->container('ie9')->usePath()->add('respond', 'js/ie/respond.min.js');
            $theme->asset()->container('ie9')->usePath()->add('excanvas', 'js/ie/excanvas.js');

            // styles
            $theme->asset()->usePath()->add('bootstrap', 'css/bootstrap.css');
            $theme->asset()->usePath()->add('animate', 'css/animate.css');
            $theme->asset()->usePath()->add('font-awesome', 'css/font-awesome.min.css');
            $theme->asset()->usePath()->add('font', 'css/font.css');
            $theme->asset()->usePath()->add('app', 'css/app.css');

            // core js
            // $theme->asset()->container('core-scripts')->usePath()->add('jquery', 'js/jquery.min.js');
            $theme->asset()->container('core-scripts')->usePath()->add('jquery', 'js/jquery-1.11.2.min.js');
            $theme->asset()->container('core-scripts')->usePath()->add('bootstrap', 'js/bootstrap.js');
            $theme->asset()->container('core-scripts')->usePath()->add('app', 'js/app.js');
            $theme->asset()->container('core-scripts')->usePath()->add('slimscroll', 'js/slimscroll/jquery.slimscroll.min.js');
        },

        // Listen on event before render a layout,
        // this should call to assign style, script for a layout.

        'beforeRenderLayout' => array(

            'main' => function($theme)
            {
                
            },

            'error' => function($theme)
            {
                
            }

        )

    )

);