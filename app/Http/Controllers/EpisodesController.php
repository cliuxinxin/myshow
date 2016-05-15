<?php

    namespace App\Http\Controllers;


    use Auth;
    use Symfony\Component\DomCrawler\Crawler;
    use Illuminate\Http\Request;
    use App\Http\Requests;
    use Carbon\Carbon;
    use App\Episode;
    use App\Show;
    use Goutte;

class EpisodesController extends Controller
{

    /**
     * use auth on seen
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['seen']);
    }

    /**
     *
     * @param $show
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($show)
    {
        $episodes=$this->episodesSpider($show);

        if(Auth::user()){
            $user_episodes = Auth::user()->episodes;
        } else {
            $user_episodes = [];
        }

        $show = Show::find($show);

        return view('episodes.index',compact('episodes','show','user_episodes'));
    }

    /**
     * Seen the episode
     *
     * @param $episode
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function seen($episode)
    {
        Auth::user()->episodes()->sync([$episode], false);

        $episode = Episode::find($episode);

        Auth::user()->shows()->sync([$episode->show], false);

        return redirect()->action('EpisodesController@index', ['show' => $episode->show]);
    }

    /**
     * Unseen the episode
     *
     * @param $episode
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function unSeen($episode)
    {
        Auth::user()->episodes()->detach($episode);

        $episode = Episode::find($episode);

        return redirect()->action('EpisodesController@index', ['show' => $episode->show]);
    }



    /**
     *
     * @return mixed
     */
    public function episodesSpider($show)
    {
        $show = Show::find($show);

        $update_date =$show->update_date;

        if($update_date == 0 || round((time()-strtotime($update_date))/3600/24) > 6){
            $episdesValues = $this->spiderParse($show);

            foreach ($episdesValues as $episdesValue) {
                Episode::firstOrCreate($episdesValue);
            }

            $show->update(['update_date' => Carbon::now()]);
        }

        $episdesValues = Episode::where('show',$show->id)->get();

        return $episdesValues;
    }

    /**
     *
     * Parse the spider data
     *
     * @param $show
     * @param $episodes
     * @param $dates
     * @return mixed
     */
    public function spiderParse(Show $show)
    {
        $url = str_replace("..", "http://epguides.com", $show->url);
        $crawler = Goutte::request('GET', $url);
        $nodeValues = $crawler->filter('pre')->text();

        preg_match_all('/(\d+)-(\d+)/i', $nodeValues, $episodes);
        preg_match_all('/(\b\d{1,2}\D{0,3})\b(?:Jan(?:uary)?|Feb(?:ruary)?|Mar(?:ch)?|Apr(?:il)?|May|Jun(?:e)?|Jul(?:y)?|Aug(?:ust)?|Sep(?:tember)?|Oct(?:ober)?|(Nov|Dec)(?:ember)?)\D?(\d{1,2}\D?)?\D?((19[7-9]\d|20\d{2})|\d{2})/i', $nodeValues, $dates);

        $episdesValues = $crawler->filter('pre a')->reduce(function (Crawler $node, $i) {
            return !empty($node->attr('href'));
        })->each(function (Crawler $node, $i) use ($episodes, $dates, $show) {
            return [
                'name' => $node->text(),
                'url' => $node->attr('href'),
                'season' => $episodes[1][$i],
                'episode' => $episodes[2][$i],
                'show' => $show->id,
            ];
        });
        foreach($dates[0] as $i=>$date){
            $episdesValues[$i]['date'] = $this->dateFormat($date);
        }
        return $episdesValues;
    }

    public function dateFormat($date)
    {
        $month = array(
            1 => "Jan",
            2 => "Feb",
            3 => "Mar",
            4 => "Apr",
            5 => "May",
            6 => "Jun",
            7 => "Jul",
            8 => "Aug",
            9 => "Sep",
            10 => "Oct",
            11 => "Nov",
            12 => "Dec");
        $date = explode(" ",$date);
        $year = '20'.$date[2];
        $month = array_keys($month,$date[1]);
        $day = $date[0];

        return $year.'-'.$month[0].'-'.$day;
    }
}
