<?php

namespace App\Http\Controllers;

use App\Events\ArticleOnSale;
use App\Events\ArticleSold;
use App\Events\Sale;
use App\Models\AbArticle;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Laravel\Reverb\Loggers\Log;

//use mysql_xdevapi\Exception;

class ArtikelController extends Controller
{
    public function SearchArticle(Request $request)
    {
        $abarticles = new AbArticle();

        if ($request->search) {
            $abarticle = $abarticles->searchByName($request->search);
            //$abarticle = DB::table('ab_article')->select('*')->where('ab_name', 'ILIKE', '%' . $request->search . '%')->get();
        } else {
            $abarticle = $abarticles->get();
            //$abarticle =  DB::table('ab_article')->get();
        }
        return view('articles', ['article' => $abarticle]);
    }
    public function newArticle(Request $request){


        $request->validate([
            'ab_name' => 'required|max:80',
            'ab_description' => 'required|max:1000',
            'ab_price' => 'required|integer|min:1',
        ]);

        $hasError = false;
        $article = new AbArticle();
        $article->ab_name = $request->ab_name;
        $article->ab_description = $request->ab_description;
        $article->ab_price = $request->ab_price;
        $article->ab_creator_id = 1;
        $article->ab_createdate = Carbon::now();

        $idmax = DB::table('ab_article')->max('id');
        $article->id = $idmax + 1;
        $article->save();
        $hasError=! $article->save();


        $message =  $hasError ? "Es ist ein Fehler aufgetreten" : "Erfolgreich11";

        return response()->json(["message" => $message]);

    }

    public function search_api(Request $request)
    {
        $page = $request->get('page',1);
        $perpage = $request->get('perpage', 5);
        $search = $request->input('search');

        $results = \App\Models\AbArticle::where('ab_name','ilike','%'.$search.'%')->paginate($perpage);
        foreach ($results as $result) {
            $result->image_url = asset($this->getImagePath($result->id));
        }

        return response()->json($results, 200);
    }
    public function store_api(Request $request): string
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:1', // Ensure price is greater than 0
            'description' => 'required',
        ]);

        // Persistieren Sie die Daten in der Datenbank
        $article = new AbArticle();
        $idmax = DB::table('ab_article')->max('id');
        $article->id = $idmax + 1;
        $article->ab_name = $validatedData['name'];
        $article->ab_price = $validatedData['price'];
        $article->ab_description = $validatedData['description'];
        $article->ab_creator_id = 1;
        $article->ab_createdate = date('Y-m-d H:i:s');
        $article->save();

        return response()->json(['id' => $article->id]);
    }
    public function _apiDeleteArticle($id): void
    {
        $articleToDelete = DB::table('ab_article')->where('id', $id)->get();
        if($articleToDelete)
            DB::table('ab_article')->where('id', $id)->delete();
        else
            throw new Exception('Artikel nicht gefunden');
    }
    public function getImagePath($id) {
        $jpgImagePath = "/articelimages/{$id}.jpg";
        $pngImagePath = "/articelimages/{$id}.png";

        if (file_exists(public_path($jpgImagePath))) {
            return $jpgImagePath;
        } elseif (file_exists(public_path($pngImagePath))) {
            return $pngImagePath;
        }

        return '/articelimages/default.png'; // Pfad zu einem Standardbild
    }
    public function soldArticle_api($id){
        $article = AbArticle::find($id);
        $CreatorId = $article->ab_creator_id;

        \Illuminate\Support\Facades\Log::info("ArticleController:markAsSold: Article found: " . $article->ab_name);

        if ($article && $article->ab_name) {
            event(new ArticleSold("Großartig! Ihr Artikel {$article->ab_name} wurde erfolgreich verkauft!", $CreatorId, $article->ab_name));
            return response()->json(['message' => 'Article marked as sold and event dispatched.']);
        }
        return response()->json(['message' => 'Article not found.'], 404);
    }

    public function markAsSold($id)
    {
        $article = AbArticle::find($id);
        $CreatorId = $article->ab_creator_id;

        \Illuminate\Support\Facades\Log::info("ArticleController:markAsSold: Article found: " . $article->ab_name);

        if ($article && $article->ab_name) {
            event(new Sale("Großartig! Ihr Artikel {$article->ab_name} wurde erfolgreich verkauft!", $CreatorId, $article->ab_name));
            return response()->json(['message' => 'Article marked as sold and event dispatched.']);
        }
        return response()->json(['message' => 'Article not found.'], 404);
    }
    public function promoteArticle(Request $request, $id)
    {
        $article = AbArticle::findOrFail($id);

        broadcast(new ArticleOnSale($article->name, $article->id));

        return response()->json(['message' => 'Article is now on sale and notification sent.']);
    }

    public function offer_api(Request $request, $articleId, $receiver)
    {
        $article = AbArticle::find($articleId);
        \Illuminate\Support\Facades\Log::info("ArticleController:setOffer: Article found: " . $article->ab_name ." receiver: ". $receiver);
        event(new Sale("Der Artikel {$article->ab_name} wird nun günstiger angeboten! Greifen Sie schnell zu.", $article, $receiver));

        return response()->json(['message' => 'Article offer processed.']);
    }




}
