<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Show;
use Goutte;
use Symfony\Component\DomCrawler\Crawler;



class ShowsController extends Controller
{
    /**
     * Show list
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        $shows = Show::all();
        return view('shows.index',compact('shows'));
    }

    public function follow($show)
    {

        return $show;
    }

    /**
     * Spide and create shows inter
     *
     * @return string
     */
    public function spider()
    {
        $this->spiderAndCreateShows();

        return 'OK';
    }

    /**
     * Spider the show
     *
     * @return mixed
     */
    public function spiderTheShow()
    {
        $crawler = Goutte::request('GET', 'http://epguides.com/menu/current.shtml');
        $nodeValues = $crawler->filter('td.tdmenu ul li b a')->each(function (Crawler $node, $i) {
            return $node->text();
        });
        return $nodeValues;
    }

    /**
     * Spider the show and create show
     */
    public function spiderAndCreateShows()
    {
        $nodeValues = $this->spiderTheShow();

        foreach ($nodeValues as $nodeValue) {
            $show = Show::firstOrCreate(['name' => $nodeValue, 'type' => 'American Show']);
        }
    }
}
