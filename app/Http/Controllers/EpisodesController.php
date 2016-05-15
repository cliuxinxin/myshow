<?php

    namespace App\Http\Controllers;


    use Symfony\Component\DomCrawler\Crawler;
    use Illuminate\Http\Request;
    use App\Http\Requests;
    use Carbon\Carbon;
    use App\Episode;
    use App\Show;
    use Goutte;

class EpisodesController extends Controller
{
    //

    public function index($show)
    {
        return "index";
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
        } else {
            $episdesValues = Episode::where('show',$show->id)->get()    ;
//              $episdesValues = 'has fetched';
        }

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
        preg_match_all('/(\b\d{1,2}\D{0,3})?\b(?:Jan(?:uary)?|Feb(?:ruary)?|Mar(?:ch)?|Apr(?:il)?|May|Jun(?:e)?|Jul(?:y)?|Aug(?:ust)?|Sep(?:tember)?|Oct(?:ober)?|(Nov|Dec)(?:ember)?)\D?(\d{1,2}\D?)?\D?((19[7-9]\d|20\d{2})|\d{2})/i', $nodeValues, $dates);

        $episdesValues = $crawler->filter('pre a')->reduce(function (Crawler $node, $i) {
            return !empty($node->attr('href'));
        })->each(function (Crawler $node, $i) use ($episodes, $dates, $show) {
            return [
                'name' => $node->text(),
                'url' => $node->attr('href'),
                'season' => $episodes[1][$i],
                'episode' => $episodes[2][$i],
                'date' => $dates[0][$i],
                'show' => $show->id
            ];
        });
        return $episdesValues;
    }
}
