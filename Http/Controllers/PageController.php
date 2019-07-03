<?php

namespace Modules\Page\Http\Controllers;

use App\Theme;
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
     * @var Theme $theme
     */
    private $theme;

    /**
     * PageController constructor.
     */
    public function __construct()
    {
        $this->website_uuid = app(\Hyn\Tenancy\Environment::class)->website()->uuid;

        $this->theme = app(\Hyn\Tenancy\Environment::class)->website()->theme;
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

    private function images(int $id)
    {
        $page = Page::query()->findOrFail($id);
        if ($page->body !== null) {
            $html = HtmlDomParser::str_get_html($page->body);
            $images = $page->getMedia();
            $number_images = count($images);

            $img = $html->find('img');

            if ($img !== null) {
                $number_img = count($html->find('img'));
                if ($number_images === $number_img) {
                    $i = 0;
                    foreach ($html->find('img') as $element) {
                        $origin_file = $images[$i]->getPath();
                        $copy_file = '/var/www/atomsit/public/admin/page/projects/website_' . $this->website_uuid . '/images/' . $images[$i]->file_name;
                        if (!copy($origin_file, $copy_file)) {
                            return "La copie $images du fichier a échoué...\n";
                        }
                        $element->src = 'images/' . $images[$i]->file_name;
                        $i++;
                    }
                }
            }
            return $html;
        } else {
            return '';
        }
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


            $file = file_get_contents($file_copy, true);
            $html = HtmlDomParser::str_get_html($file);
            $html->find('body[id=atomsit]', 0)->innertext = $this->images($page->id);

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

    private function project(array $theme_json)
    {
        $project = array(
            'dir' => '../../admin/page/projects/website_' . $this->website_uuid . '/',
            'pages' =>
                $this->pages(),
            'files' =>
                array(),
            'readOnlyFiles' =>
                array(),
            'publishPath' => '../../admin/page/final/website_' . $this->website_uuid . '/',
        );
        $project1 = array_merge($project, $theme_json);
        $file = '/var/www/atomsit/public/admin/page/projects/website_' . $this->website_uuid . '/project.json';
        $fp = fopen($file, 'w');
        fwrite($fp, json_encode($project1));
        fclose($fp);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $theme_json = json_decode(file_get_contents("/var/www/atomsit/public/themes/" . $this->theme->directory . "/project.json"), true);

        $structure = '/var/www/atomsit/public/admin/page/projects/website_' . $this->website_uuid;
        if (!is_dir($structure) === true) {
            if (!mkdir($structure, 0777, true)) {
                return ('Echec lors de la création des répertoires...');
            }
        }
        $src = "/var/www/atomsit/public/themes/" . $this->theme->directory . "/elements";
        $dst = "/var/www/atomsit/public/admin/page/projects/website_" . $this->website_uuid . "/elements";
        if (!is_dir($dst) === true) {
            if (!mkdir($dst, 0777, true)) {
                return ('Echec lors de la création des répertoires...');
            }
        }
        $dir = opendir("/var/www/atomsit/public/themes/" . $this->theme->directory . "/elements");
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    recurse_copy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
        $this->config();

        $this->project($theme_json);


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
                $file_copy = __DIR__ . '/../../../../public/admin/page/final/website_' . $this->website_uuid . '/' . $page['path'];
                $content = file_get_contents($file_copy, true);
                $html = HtmlDomParser::str_get_html($content);


                $div = $html->find('body[id=atomsit]', 0);
                $db_page = Page::findOrFail($id);
                $db_page->clearMediaCollection('default');
                $i = 0;
                foreach ($div->find('img') as $element) {
                    $db_page
                        ->addMediaFromUrl('/var/www/atomsit/public/admin/page/final/website_' . $this->website_uuid . '/' . $element->src)
                        ->toMediaCollection();
                }
                $mediaItems = $db_page->getMedia();
                foreach ($div->find('img') as $element) {
                    $element->src = $mediaItems[$i]->getFullUrl();
                    $i++;
                }

                $db_page->update([
                    'body' => $div
                ]);
                $db_page->save();
            } else {
                $user = Auth::user();
                $file_copy = __DIR__ . '/../../../../public/admin/page/final/website_' . $this->website_uuid . '/' . $page['path'];
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
    public function show($any)
    {
        $page = Page::query()->where("slug", $any)
            ->first();
        if ($page !== null) {
            return view('page::themes.beer.index')
                ->with('content', $page->body);
        } else {
            return abort(404);
        }
    }
}
