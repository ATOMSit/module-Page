<?php

namespace Modules\Page\Http\Controllers;

use DiDom\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Page\Entities\Page;
use Sunra\PhpSimple\HtmlDomParser;

class PageController extends Controller
{
    /**
     * @var string $website_uuid
     */
    private $website_uuid;

    /**
     * PageController constructor.
     */
    public function __construct()
    {
        $this->website_uuid = app(\Hyn\Tenancy\Environment::class)->website()->uuid;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('page::index');
    }

    private function config()
    {
        // Création du config.json
        $config = ([
            "demoMode" => false,
            "project" => "website_" . $this->website_uuid,
            "mode" => 1,
            "showIntroduction" => false,
            "jets" => true,
            "checkForUpdates" => false,
            "lang" => "en",
            "enableAuthorization" => false,
            "updateServers" => [
                "//update.novibuilder.com"
            ]
        ]);
        $file = '/var/www/atomsit/public/admin/page/config/website_' . $this->website_uuid . '.json';
        $fp = fopen($file, 'w');
        fwrite($fp, json_encode($config));
        fclose($fp);
    }

    private function pages()
    {
        $array = array();
        $pages = Page::all();
        foreach ($pages as $page) {
            $file_origin = __DIR__ . '/../../Resources/views/themes/beer/index.html';
            $file_copy = __DIR__ . '/../../../../public/admin/page/projects/website_' . $this->website_uuid . '/atomsitID' . $page->id . '.html';
            if (!copy($file_origin, $file_copy)) {
                echo "La copie $file_origin du fichier a échoué...\n";
            }
            $content = file_get_contents($file_copy, true);

            $html = HtmlDomParser::str_get_html($content);


            $html->find('body[id=atomsit]', 0)->innertext = $page->body;

            $fp = fopen($file_copy, 'w');
            fwrite($fp, $html);
            fclose($fp);
            $new_page = array(
                'path' => 'atomsitID' . $page->id . '.html',
                'index' => true,
                'isActive' => true,
                'title' => $page->title,
                'preview' => 'novi/pages/index.jpg',
            );
            array_push($array, $new_page);
        }
        return $array;
    }

    private function project()
    {
        $project = array(
            'presets' =>
                array(
                    0 =>
                        array(
                            'title' => 'Header Classic',
                            'category' => 'header',
                            'reload' => true,
                            'path' => 'header-classic.html',
                            'preview' => 'elements/header-classic.jpg',
                            'id' => 0,
                            'element' =>
                                array(),
                        ),
                    1 =>
                        array(
                            'title' => 'Map Fullwidth',
                            'category' => 'contacts',
                            'reload' => true,
                            'path' => 'map-fullwidth.html',
                            'preview' => 'elements/map-fullwidth.jpg',
                            'id' => 1,
                            'element' =>
                                array(),
                        ),
                    2 =>
                        array(
                            'title' => 'Footer Classic',
                            'category' => 'footers',
                            'path' => 'footer-classic.html',
                            'reload' => false,
                            'preview' => 'elements/footer-classic.jpg',
                            'id' => 2,
                            'element' =>
                                array(),
                        ),
                    3 =>
                        array(
                            'title' => 'Blog Classic',
                            'category' => 'blogs',
                            'path' => 'blog-classic.html',
                            'reload' => false,
                            'preview' => 'elements/blog-classic.jpg',
                            'id' => 3,
                            'element' =>
                                array(),
                        ),
                    4 =>
                        array(
                            'title' => 'Blog Post',
                            'category' => 'blogs',
                            'path' => 'blog-post.html',
                            'reload' => false,
                            'preview' => 'elements/blog-post.jpg',
                            'id' => 4,
                            'element' =>
                                array(),
                        ),
                    5 =>
                        array(
                            'title' => 'Blog Grid',
                            'category' => 'blogs',
                            'path' => 'blog-grid.html',
                            'reload' => false,
                            'preview' => 'elements/blog-grid.jpg',
                            'id' => 5,
                            'element' =>
                                array(),
                        ),
                    6 =>
                        array(
                            'title' => 'Blog Masonry',
                            'category' => 'blogs',
                            'path' => 'blog-masonry.html',
                            'reload' => false,
                            'preview' => 'elements/blog-masonry.jpg',
                            'id' => 6,
                            'element' =>
                                array(),
                        ),
                    7 =>
                        array(
                            'title' => 'Blog Modern',
                            'category' => 'blogs',
                            'path' => 'blog-modern.html',
                            'reload' => false,
                            'preview' => 'elements/blog-modern.jpg',
                            'id' => 7,
                            'element' =>
                                array(),
                        ),
                    8 =>
                        array(
                            'title' => 'Breadcrumbs Minimal',
                            'category' => 'breadcrumbs',
                            'path' => 'breadcrumbs-minimal.html',
                            'reload' => false,
                            'preview' => 'elements/breadcrumbs-minimal.jpg',
                            'id' => 8,
                            'element' =>
                                array(),
                        ),
                    9 =>
                        array(
                            'title' => 'Breadcrumbs Parallax',
                            'category' => 'breadcrumbs',
                            'reload' => true,
                            'path' => 'breadcrumbs-parallax.html',
                            'preview' => 'elements/breadcrumbs-parallax.jpg',
                            'id' => 9,
                            'element' =>
                                array(),
                        ),
                    10 =>
                        array(
                            'title' => 'Breadcrumbs Classic',
                            'category' => 'breadcrumbs',
                            'path' => 'breadcrumbs-classic.html',
                            'reload' => false,
                            'preview' => 'elements/breadcrumbs-classic.jpg',
                            'id' => 10,
                            'element' =>
                                array(),
                        ),
                    11 =>
                        array(
                            'title' => 'Contact Form With Information',
                            'category' => 'contacts',
                            'reload' => true,
                            'path' => 'contact-form-with-information.html',
                            'preview' => 'elements/contact-form-with-information.jpg',
                            'id' => 11,
                            'element' =>
                                array(),
                        ),
                    12 =>
                        array(
                            'title' => 'Footer Minimal',
                            'category' => 'footers',
                            'path' => 'footer-minimal.html',
                            'reload' => false,
                            'preview' => 'elements/footer-minimal.jpg',
                            'id' => 12,
                            'element' =>
                                array(),
                        ),
                    13 =>
                        array(
                            'title' => 'Contact Form',
                            'category' => 'contacts',
                            'reload' => true,
                            'path' => 'contact-form.html',
                            'preview' => 'elements/contact-form.jpg',
                            'id' => 13,
                            'element' =>
                                array(),
                        ),
                    14 =>
                        array(
                            'title' => 'Contact Form With Map',
                            'category' => 'contacts',
                            'reload' => true,
                            'path' => 'contact-form-with-map.html',
                            'preview' => 'elements/contact-form-with-map.jpg',
                            'id' => 14,
                            'element' =>
                                array(),
                        ),
                    15 =>
                        array(
                            'title' => 'Gallery Grid',
                            'category' => 'galleries',
                            'reload' => true,
                            'path' => 'gallery-grid.html',
                            'preview' => 'elements/gallery-grid.jpg',
                            'id' => 15,
                            'element' =>
                                array(),
                        ),
                    16 =>
                        array(
                            'title' => 'Gallery Cobbles',
                            'category' => 'galleries',
                            'reload' => true,
                            'path' => 'gallery-cobbles.html',
                            'preview' => 'elements/gallery-cobbles.jpg',
                            'id' => 16,
                            'element' =>
                                array(),
                        ),
                    17 =>
                        array(
                            'title' => 'Gallery Masonry',
                            'category' => 'galleries',
                            'reload' => true,
                            'path' => 'gallery-masonry.html',
                            'preview' => 'elements/gallery-masonry.jpg',
                            'id' => 17,
                            'element' =>
                                array(),
                        ),
                    18 =>
                        array(
                            'title' => 'Gallery Condensed',
                            'category' => 'galleries',
                            'reload' => true,
                            'path' => 'gallery-condensed.html',
                            'preview' => 'elements/gallery-condensed.jpg',
                            'id' => 18,
                            'element' =>
                                array(),
                        ),
                    19 =>
                        array(
                            'title' => 'Gallery Albums Grid',
                            'category' => 'galleries',
                            'reload' => true,
                            'path' => 'gallery-albums-grid.html',
                            'preview' => 'elements/gallery-albums-grid.jpg',
                            'id' => 19,
                            'element' =>
                                array(),
                        ),
                    20 =>
                        array(
                            'title' => 'Gallery Albums Cobbles',
                            'category' => 'galleries',
                            'reload' => true,
                            'path' => 'gallery-albums-cobbles.html',
                            'preview' => 'elements/gallery-albums-cobbles.jpg',
                            'id' => 20,
                            'element' =>
                                array(),
                        ),
                    21 =>
                        array(
                            'title' => 'Gallery Albums Masonry',
                            'category' => 'galleries',
                            'reload' => true,
                            'path' => 'gallery-albums-masonry.html',
                            'preview' => 'elements/gallery-albums-masonry.jpg',
                            'id' => 21,
                            'element' =>
                                array(),
                        ),
                    22 =>
                        array(
                            'title' => 'Gallery Albums Condensed',
                            'category' => 'galleries',
                            'reload' => true,
                            'path' => 'gallery-albums-condensed.html',
                            'preview' => 'elements/gallery-albums-condensed.jpg',
                            'id' => 22,
                            'element' =>
                                array(),
                        ),
                    23 =>
                        array(
                            'title' => 'Header Sidebar',
                            'category' => 'header',
                            'reload' => true,
                            'path' => 'header-sidebar.html',
                            'preview' => 'elements/header-sidebar.jpg',
                            'id' => 23,
                            'element' =>
                                array(),
                        ),
                    24 =>
                        array(
                            'title' => 'Slider Dots',
                            'category' => 'sliders',
                            'reload' => true,
                            'path' => 'slider-dots.html',
                            'preview' => 'elements/slider-dots.jpg',
                            'id' => 24,
                            'element' =>
                                array(),
                        ),
                    25 =>
                        array(
                            'title' => 'Map Container',
                            'category' => 'contacts',
                            'reload' => true,
                            'path' => 'map-container.html',
                            'preview' => 'elements/map-container.jpg',
                            'id' => 25,
                            'element' =>
                                array(),
                        ),
                    26 =>
                        array(
                            'title' => 'Menu Single',
                            'category' => 'menu',
                            'path' => 'menu-single.html',
                            'reload' => false,
                            'preview' => 'elements/menu-single.jpg',
                            'id' => 26,
                            'element' =>
                                array(),
                        ),
                    27 =>
                        array(
                            'title' => 'Menu Classic',
                            'category' => 'menu',
                            'path' => 'menu-classic.html',
                            'reload' => false,
                            'preview' => 'elements/menu-classic.jpg',
                            'id' => 27,
                            'element' =>
                                array(),
                        ),
                    28 =>
                        array(
                            'title' => 'Menu Modern',
                            'category' => 'menu',
                            'path' => 'menu-modern.html',
                            'reload' => false,
                            'preview' => 'elements/menu-modern.jpg',
                            'id' => 28,
                            'element' =>
                                array(),
                        ),
                    29 =>
                        array(
                            'title' => 'Slider Arrow',
                            'category' => 'sliders',
                            'reload' => true,
                            'path' => 'slider-arrow.html',
                            'preview' => 'elements/slider-arrow.jpg',
                            'id' => 29,
                            'element' =>
                                array(),
                        ),
                    30 =>
                        array(
                            'title' => 'Subscribe Forms',
                            'category' => 'contacts',
                            'reload' => true,
                            'path' => 'subscribe-forms.html',
                            'preview' => 'elements/subscribe-forms.jpg',
                            'id' => 30,
                            'element' =>
                                array(),
                        ),
                    31 =>
                        array(
                            'title' => 'Subscribe Forms With Parallax',
                            'category' => 'contacts',
                            'reload' => true,
                            'path' => 'subscribe-forms-with-parallax.html',
                            'preview' => 'elements/subscribe-forms-with-parallax.jpg',
                            'id' => 31,
                            'element' =>
                                array(),
                        ),
                ),
            'name' => 'Black Bear Bar',
            'dir' => '../../admin/page/projects/website_b594c009f67548cfad97e00a86f9a935/',
            'pages' =>
                $this->pages(),
            'files' =>
                array(),
            'readOnlyFiles' =>
                array(),
            'publishPath' => '../../admin/page/final/website_b594c009f67548cfad97e00a86f9a935/',
            'disablePublishPromt' => false,
            'layers' =>
                array(
                    0 =>
                        array(
                            'name' => 'Sections',
                            'element' => 'header, footer, section',
                            'canBeInsertedTo' => '.page',
                        ),
                    1 =>
                        array(
                            'name' => 'Grid Column',
                            'element' => '.range:not(.range-fix) > [class*="cell-"]',
                            'canBeInsertedTo' => '.range:not(.range-fix)',
                        ),
                    2 =>
                        array(
                            'name' => 'Order List',
                            'element' => 'ol:not(.list-fix) > li',
                            'canBeInsertedTo' => 'ol:not(.list-fix)',
                        ),
                    3 =>
                        array(
                            'name' => 'Unorder List',
                            'element' => 'ul:not(.list-fix) > li',
                            'canBeInsertedTo' => 'ul:not(.list-fix)',
                        ),
                    4 =>
                        array(
                            'name' => 'Description List',
                            'element' => 'dl:not(.list-fix) > dt, dl:not(.list-fix) > dd',
                            'canBeInsertedTo' => 'dl:not(.list-fix)',
                        ),
                    5 =>
                        array(
                            'name' => 'Timeline',
                            'element' => '.timeline > .timeline-date, .timeline > .timeline-item',
                            'canBeInsertedTo' => '.timeline',
                        ),
                    6 =>
                        array(
                            'name' => 'Gallery item',
                            'element' => '.row:not(.row-fix) > [class*="col-"]',
                            'canBeInsertedTo' => '.row:not(.row-fix)',
                        ),
                    7 =>
                        array(
                            'name' => 'Accordion',
                            'element' => '.card-group-custom > .card',
                            'canBeInsertedTo' => '.card-group-custom',
                        ),
                    8 =>
                        array(
                            'name' => 'Group',
                            'element' => '[class*=group-]:not(.group-fix) > *',
                            'canBeInsertedTo' => '[class*=group-]:not(.group-fix)',
                        ),
                    9 =>
                        array(
                            'name' => 'Article',
                            'element' => '.article-wrap > .article',
                            'canBeInsertedTo' => '.article-wrap',
                        ),
                    10 =>
                        array(
                            'name' => 'Post',
                            'element' => '.post-wrap > .post, .post-wrap > .post-modern-timeline-date',
                            'canBeInsertedTo' => '.post-wrap',
                        ),
                ),
            'iconFonts' =>
                array(
                    0 =>
                        array(
                            'family' => 'Material Design Icons',
                            'default' => false,
                        ),
                    1 =>
                        array(
                            'family' => 'fl-budicons-free',
                            'default' => true,
                            'cssPath' => 'fonts/flbudiconsfree/fl-budicons-free.css',
                        ),
                ),
            'plugins' =>
                array(
                    0 =>
                        array(
                            'name' => 'novi-plugin-background-image',
                            'settings' =>
                                array(
                                    'querySelector' => '.novi-bg-img',
                                    'childQuerySelector' => '.novi-bg-img',
                                ),
                        ),
                    1 =>
                        array(
                            'name' => 'novi-plugin-camera-slider',
                            'settings' =>
                                array(
                                    'querySelector' => '.camera_wrap',
                                ),
                        ),
                    2 =>
                        array(
                            'name' => 'novi-plugin-background',
                            'settings' =>
                                array(
                                    'querySelector' => '.novi-bg',
                                ),
                        ),
                    3 =>
                        array(
                            'name' => 'novi-plugin-campaign-monitor',
                            'settings' =>
                                array(
                                    'querySelector' => '[class*="campaign-mailform"]',
                                ),
                        ),
                    4 =>
                        array(
                            'name' => 'novi-plugin-google-map',
                            'settings' =>
                                array(
                                    'querySelector' => '.google-map-container',
                                ),
                        ),
                    5 =>
                        array(
                            'name' => 'novi-plugin-icon-manager',
                            'settings' =>
                                array(
                                    'querySelector' => '.novi-icon',
                                ),
                        ),
                    6 =>
                        array(
                            'name' => 'novi-plugin-iframe',
                            'settings' =>
                                array(
                                    'querySelector' => 'iframe[src]',
                                ),
                        ),
                    7 =>
                        array(
                            'name' => 'novi-plugin-image',
                            'settings' =>
                                array(
                                    'querySelector' => 'img[src]',
                                ),
                        ),
                    8 =>
                        array(
                            'name' => 'novi-plugin-label',
                            'settings' =>
                                array(
                                    'querySelector' => 'label',
                                ),
                        ),
                    9 =>
                        array(
                            'name' => 'novi-plugin-light-gallery',
                            'settings' =>
                                array(
                                    'groupQuerySelector' => '[data-lightgallery="group"]',
                                    'albumQuerySelector' => '[data-lightgallery="dynamic"]',
                                    'childQuerySelector' => '[data-lightgallery="item"]',
                                    'querySelector' => '[data-lightgallery="group"], [data-lightgallery="dynamic"], [data-lightgallery="item"]',
                                ),
                        ),
                    10 =>
                        array(
                            'name' => 'novi-plugin-link',
                            'settings' =>
                                array(
                                    'querySelector' => 'a[href]',
                                    'favoriteLinks' =>
                                        array(
                                            0 =>
                                                array(
                                                    'title' => '',
                                                    'value' => '',
                                                ),
                                        ),
                                    'applyToProjectElements' => true,
                                ),
                        ),
                    11 =>
                        array(
                            'name' => 'novi-plugin-mailchimp',
                            'settings' =>
                                array(
                                    'querySelector' => '[class*="mailchimp-mailform"]',
                                ),
                        ),
                    12 =>
                        array(
                            'name' => 'novi-plugin-material-parallax',
                            'settings' =>
                                array(
                                    'querySelector' => '.parallax-container',
                                ),
                        ),
                    13 =>
                        array(
                            'name' => 'novi-plugin-owl-carousel',
                            'settings' =>
                                array(
                                    'querySelector' => '.owl-carousel',
                                    'childQuerySelector' => '.owl-carousel .owl-item > *',
                                ),
                        ),
                    14 =>
                        array(
                            'name' => 'novi-plugin-rd-facebook',
                            'settings' =>
                                array(
                                    'querySelector' => '.facebook',
                                ),
                        ),
                    15 =>
                        array(
                            'name' => 'novi-plugin-rd-instafeed',
                            'settings' =>
                                array(
                                    'querySelector' => '.instafeed',
                                ),
                        ),
                    16 =>
                        array(
                            'name' => 'novi-plugin-rd-mailform',
                            'settings' =>
                                array(
                                    'querySelector' => '.rd-mailform',
                                    'configLocation' => 'bat/rd-mailform.config.json',
                                ),
                        ),
                    17 =>
                        array(
                            'name' => 'novi-plugin-rd-twitterfeed',
                            'settings' =>
                                array(
                                    'querySelector' => '.twitter',
                                ),
                        ),
                    18 =>
                        array(
                            'name' => 'novi-plugin-swiper-slider',
                            'settings' =>
                                array(
                                    'querySelector' => '.swiper-container',
                                    'effects' =>
                                        array(
                                            0 =>
                                                array(
                                                    'label' => 'Slide',
                                                    'value' => 'slide',
                                                    'clearableValue' => false,
                                                ),
                                            1 =>
                                                array(
                                                    'label' => 'Fade',
                                                    'value' => 'fade',
                                                    'clearableValue' => false,
                                                ),
                                        ),
                                ),
                        ),
                    19 =>
                        array(
                            'name' => 'novi-plugin-vide',
                            'settings' =>
                                array(
                                    'querySelector' => '.novi-vide',
                                ),
                        ),
                ),
            'mediaDir' => 'images/',
            'videoDir' => 'video/',
            'fontDir' => 'fonts/',
            'cssDir' => 'css/',
            'codeEditor' =>
                array(
                    'cssFile' => NULL,
                    'jsFile' => NULL,
                ),
            'pageContainer' => '.page',
            'mediaLibrary' =>
                array(
                    'items' =>
                        array(
                            0 =>
                                array(
                                    'original' => 'colors.jpeg',
                                    'width' => 1280,
                                    'height' => 960,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/colors.jpeg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 0,
                                ),
                            1 =>
                                array(
                                    'original' => 'about-1.png',
                                    'width' => 789,
                                    'height' => 833,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/about-1.png',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 38,
                                ),
                            2 =>
                                array(
                                    'original' => 'about-02-420x259.jpg',
                                    'width' => 420,
                                    'height' => 259,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/about-02-420x259.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 39,
                                ),
                            3 =>
                                array(
                                    'original' => 'about-03-420x259.jpg',
                                    'width' => 420,
                                    'height' => 259,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/about-03-420x259.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 40,
                                ),
                            4 =>
                                array(
                                    'original' => 'about-08-326x330.jpg',
                                    'width' => 326,
                                    'height' => 330,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/about-08-326x330.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 41,
                                ),
                            5 =>
                                array(
                                    'original' => 'about-09-326x330.jpg',
                                    'width' => 326,
                                    'height' => 330,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/about-09-326x330.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 42,
                                ),
                            6 =>
                                array(
                                    'original' => 'aside-blog-about-1-210x210.jpg',
                                    'width' => 210,
                                    'height' => 210,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/aside-blog-about-1-210x210.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 43,
                                ),
                            7 =>
                                array(
                                    'original' => 'bg-image-2.jpg',
                                    'width' => 1920,
                                    'height' => 955,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/bg-image-2.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 44,
                                ),
                            8 =>
                                array(
                                    'original' => 'bg-image-3.jpg',
                                    'width' => 1920,
                                    'height' => 955,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/bg-image-3.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 45,
                                ),
                            9 =>
                                array(
                                    'original' => 'bg-image-4.jpg',
                                    'width' => 1920,
                                    'height' => 955,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/bg-image-4.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 46,
                                ),
                            10 =>
                                array(
                                    'original' => 'bg-menu-1.jpg',
                                    'width' => 548,
                                    'height' => 701,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/bg-menu-1.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 47,
                                ),
                            11 =>
                                array(
                                    'original' => 'bg-menu-2.jpg',
                                    'width' => 548,
                                    'height' => 701,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/bg-menu-2.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 48,
                                ),
                            12 =>
                                array(
                                    'original' => 'bg-menu-3.jpg',
                                    'width' => 548,
                                    'height' => 701,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/bg-menu-3.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 49,
                                ),
                            13 =>
                                array(
                                    'original' => 'bg-menu-4.jpg',
                                    'width' => 548,
                                    'height' => 701,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/bg-menu-4.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 50,
                                ),
                            14 =>
                                array(
                                    'original' => 'bg-menu-5.jpg',
                                    'width' => 548,
                                    'height' => 701,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/bg-menu-5.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 51,
                                ),
                            15 =>
                                array(
                                    'original' => 'bg-menu-6.jpg',
                                    'width' => 548,
                                    'height' => 701,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/bg-menu-6.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 52,
                                ),
                            16 =>
                                array(
                                    'original' => 'bg-menu-7.jpg',
                                    'width' => 1150,
                                    'height' => 530,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/bg-menu-7.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 53,
                                ),
                            17 =>
                                array(
                                    'original' => 'deals-01-669x484.jpg',
                                    'width' => 669,
                                    'height' => 484,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/deals-01-669x484.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 54,
                                ),
                            18 =>
                                array(
                                    'original' => 'gallery-2-1200x800_original.jpg',
                                    'width' => 1200,
                                    'height' => 800,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/gallery-2-1200x800_original.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 55,
                                ),
                            19 =>
                                array(
                                    'original' => 'post-02-870x412.jpg',
                                    'width' => 870,
                                    'height' => 412,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/post-02-870x412.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 56,
                                ),
                            20 =>
                                array(
                                    'original' => 'post-07-546x321.jpg',
                                    'width' => 570,
                                    'height' => 321,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/post-07-546x321.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 57,
                                ),
                            21 =>
                                array(
                                    'original' => 'post-08-398x269.jpg',
                                    'width' => 398,
                                    'height' => 269,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/post-08-398x269.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 58,
                                ),
                            22 =>
                                array(
                                    'original' => 'post-09-398x269.jpg',
                                    'width' => 398,
                                    'height' => 269,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/post-09-398x269.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 59,
                                ),
                            23 =>
                                array(
                                    'original' => 'sandwiches-5-310x260.png',
                                    'width' => 310,
                                    'height' => 260,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/sandwiches-5-310x260.png',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 60,
                                ),
                            24 =>
                                array(
                                    'original' => 'sandwiches-6-310x260.png',
                                    'width' => 310,
                                    'height' => 260,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/sandwiches-6-310x260.png',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 61,
                                ),
                            25 =>
                                array(
                                    'original' => 'shop-cart-1-130x130.jpg',
                                    'width' => 130,
                                    'height' => 130,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/shop-cart-1-130x130.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 62,
                                ),
                            26 =>
                                array(
                                    'original' => 'testimonials-02-104x104.jpg',
                                    'width' => 104,
                                    'height' => 104,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/testimonials-02-104x104.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 63,
                                ),
                            27 =>
                                array(
                                    'original' => 'testimonials-03-104x104.jpg',
                                    'width' => 104,
                                    'height' => 104,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/testimonials-03-104x104.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 64,
                                ),
                            28 =>
                                array(
                                    'original' => 'typography-1-770x485.jpg',
                                    'width' => 770,
                                    'height' => 485,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/typography-1-770x485.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 65,
                                ),
                            29 =>
                                array(
                                    'original' => 'typography-2-350x220.jpg',
                                    'width' => 350,
                                    'height' => 220,
                                    'type' => 'image',
                                    'thumbnail' => 'projects/website_b594c009f67548cfad97e00a86f9a935/novi/media/thumbnails/typography-2-350x220.jpg',
                                    'categories' =>
                                        array(
                                            0 => 3,
                                        ),
                                    'id' => 66,
                                ),
                        ),
                    'categories' =>
                        array(
                            0 =>
                                array(
                                    'name' => 'images',
                                    'images' => 30,
                                    'videos' => 0,
                                    'id' => 3,
                                ),
                        ),
                ),
            'googleFonts' =>
                array(
                    'Changa One' =>
                        array(
                            'category' => 'display',
                            'subsets' =>
                                array(),
                            'variants' =>
                                array(
                                    0 => '400',
                                    1 => '400i',
                                ),
                        ),
                    'Grand Hotel' =>
                        array(
                            'category' => 'handwriting',
                            'subsets' =>
                                array(),
                            'variants' =>
                                array(
                                    0 => '400',
                                ),
                        ),
                    'Lato' =>
                        array(
                            'category' => 'sans-serif',
                            'subsets' =>
                                array(),
                            'variants' =>
                                array(
                                    0 => '300',
                                    1 => '400',
                                    2 => '400italic',
                                    3 => '700',
                                ),
                        ),
                ),
            'basicTemplate' => '<!DOCTYPE html>
<html class="wide wow-animation smoothscroll" lang="en">
<head>     <!-- Site Title--> <title>Sandwiches</title>
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport"
				content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="utf-8">
	<link rel="icon" href="images/favicon.ico" type="image/x-icon">     <!-- Stylesheets-->
	<link rel="stylesheet" type="text/css"
				href="//fonts.googleapis.com/css?family=Changa+One:400,400i%7CGrand+Hotel%7CLato:300,400,400italic,700">
	<link rel="stylesheet" href="css/style.css">
	<!--[if lt IE 10]>
	<div
			style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;">
		<a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="images/ie8-panel/warning_bar_0000_us.jpg"
																																				 border="0" height="42" width="820"
																																				 alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a>
	</div>
	<script src="js/html5shiv.min.js"></script>   <![endif]-->   </head>
<body>     <!-- Page-->
<div class="page text-center">

</div>     <!-- Global Mailform Output-->
<div class="snackbars" id="form-output-global"></div>     <!-- Java script-->
<script src="js/core.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>',
        );
        $file = '/var/www/atomsit/public/admin/page/projects/website_' . $this->website_uuid . '/project.json';
        $fp = fopen($file, 'w');
        fwrite($fp, json_encode($project));
        fclose($fp);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $structure = '/var/www/atomsit/public/admin/page/projects/website_' . $this->website_uuid;
        if (!is_dir($structure) === true) {
            if (!mkdir($structure, 0777, true)) {
                return ('Echec lors de la création des répertoires...');
            }
        }
        $this->config();
        $this->project();

        return view('page::index')
            ->with('website_id', $this->website_uuid);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $file_project = '/var/www/atomsit/public/admin/page/projects/website_' . $this->website_uuid . '/project.json';
        $array_project = json_decode(file_get_contents($file_project, true), true);
        foreach ($array_project['pages'] as $page) {
            if (strpos($page['path'], 'atomsitID') !== false) {
                $id = basename(str_replace('atomsitID', '', $page['path']), '.html');
                $file_copy = __DIR__ . '/../../../../public/admin/page/projects/website_' . $this->website_uuid . '/' . $page['path'];
                $content = file_get_contents($file_copy, true);
                $html = HtmlDomParser::str_get_html($content);
                $html->find('body[id=atomsit]', 0);
                $db_page = Page::findOrFail($id);
                $db_page->update([
                    'body' => $html
                ]);
                $db_page->save();
            } else {
                $user = Auth::user();
                $file_copy = __DIR__ . '/../../../../public/admin/page/projects/website_' . $this->website_uuid . '/' . $page['path'];
                $content = file_get_contents($file_copy, true);
                $html = HtmlDomParser::str_get_html($content);
                $html->find('body[id=atomsit]', 0);
                $db_page = new Page([
                    'title' => $page['title'],
                    'slug' => $page['title'],
                    'body' => $html
                ]);
                $db_page->author()->associate($user)->save();
            }
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public
    function show($id)
    {
        return view('page::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public
    function edit($id)
    {
        return view('page::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public
    function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public
    function destroy($id)
    {
        //
    }
}
