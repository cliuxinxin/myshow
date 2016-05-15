<?php

namespace App\Http\Controllers;


use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Show;
use Goutte;
use Symfony\Component\DomCrawler\Crawler;



class ShowsController extends Controller
{

    /**
     * use auth on follow
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['follow']);
    }
    /**
     * Show list
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {

        $all_shows = Show::all();

        if(Auth::user()){
            $user_shows = Auth::user()->shows;
        } else {
            $user_shows = [];
        }

        $shows = $all_shows->diff($user_shows);

        return view('shows.index',compact('shows'));
    }

    /**
     * Display user's shows
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userShows()
    {
        $shows = Auth::user()->shows;

        return view('shows.userShows',compact('shows'));
    }

    /**
     * Follow the show on index
     *
     * @param $show
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function follow($show)
    {
        Auth::user()->shows()->sync([$show], false);

        return redirect('shows/user');
    }

    /**
     * Unfollow the show
     *
     * @param $show
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function unfollow($show)
    {
        Auth::user()->shows()->detach($show);

        return redirect('shows/user');
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
            return [$node->text(),$node->attr('href')];
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
            $show = Show::firstOrCreate(['name' => $nodeValue[0],'url' => $nodeValue[1], 'type' => 'American Show']);
        }
    }
}
