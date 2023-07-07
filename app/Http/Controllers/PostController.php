<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;

class PostController extends Controller
{
    //

    public function create(Request $request)
    {
        // $posts = Post::orderBy("created_at", "desc")->paginate(3);

        // dd($request->searchKey);
        $posts = Post::when(request("searchKey"), function ($p) {
            $key = request("searchKey");
            $p->orwhere("title", "like", "%" . $key . "%")
                ->orwhere("description", "like", "%" . $key . "%");
        })
            ->orderBy("created_at", "desc")
            ->paginate(2);


        return view('create', compact("posts"));


        // $posts = Post::where("id", "<=", 5)->select("title")->get();
        // $posts = Post::pluck("title", "id");
        // $posts = Post::where("id", "<", "5")->where("address", "Mandalay")->get();
        // $posts = Post::orWhere("id", "<", 5)->orWhere("address", "Mandalay")->get();
        // $posts = Post::orderBy("price", "desc")->get();
        // dd($posts->toArray());
        // $posts = Post::select("address", "title", "price")
        //         ->where("address", "Pyin Oo Lwin")
        //         ->whereBetween("price", [2000, 10000])
        //         ->orderBy("price", "desc")
        //         ->dd();
        // dd($posts->toArray());

        // $posts = Post::select("address", DB::raw("count(*) as people_count, sum(price) as total_price"))
        //         ->groupBy("address")
        //         ->get()
        //         ->toArray();
        // dd($posts);

        // map, each, through
        // $posts = Post::paginate(2)->through(function ($p) {

        //     $p->price *= 2;
        //     return $p;
        // });
        // dd($posts->toArray());


        // $post = Post::where("title", 'LIKE',  '%'. $serachKey. '%')->get()->toArray();
        // $post = Post::when(request("title"), function($p){
        //     $searchKey = $_REQUEST["title"];
        //     $p->where("title", "like", '%'.$searchKey.'%');

        // })->paginate(2);
        // dd($post->toArray());


    }

    public function postCreate(Request $request)
    {
        // validation စစ်တယ်။ data ကို array format ပြောင်းတယ်
        // image column အတွက် generate လုပ်ထားတဲ့ name နဲ့ database ထဲကို ထည့်တယ်။
        $this->validationCheck($request);
        $req_data = $this->getPostData($request);   // change to array data

        if ($request->hasFile("postImage")) {
            // $request->file("postImage")->store("myImage");
            $fileName = uniqid() . $request->file("postImage")->getClientOriginalName();
            $request->file("postImage")->storeAs("public", $fileName);
            $req_data["image"] = $fileName;
        }

        Post::create($req_data);
        return redirect()->route('post#createPage')->with(["successMessage" => "Post ဖန်တီးခြင်းအောင်မြင်ပါသည်"]);
    }

    // url ကနေပါလာမယ့် parameter ကို postId အနေနဲ့ လက်ခံလိုက်တာ
    public function postDelete($postId)
    {
        // first way
        // Post::where("id", $postId)->delete();
        // return back();

        // second way
        Post::findOrFail($postId)->delete();
        return back();

        // $delete = Post::where("id", "=", $postId)->delete();
        // return back();
        // post#home ကို redirect လုပ်ထားလို့ အဲ့ route အတိုင်းသွားပြီး create() function ထဲမှာ posts data တွေဆွဲထုတ်ပြီး
        // data passing လုပ်ထားလို့ error မတက်ဘူး
        // return redirect()->route("post#home");
        // return view("create"); => error တက်မယ်။ data တွေဆွဲထုတ်ထားတာ မရှိဘဲ
        // create.blade.php ကို ပြထားတဲ့အတွက် create template ထဲမှာ $posts ကို မသိဘူးဆိုပြီး ဖြစ်သွားမယ်။
    }


    public function postUpdatePage($id)
    {
        // data တွေရယူတဲ့အခါမှာ object or collection type ပုံစံဖြစ်တယ်ဆိုရင် -> or [] နဲ့ data ယူလို့ရတယ်
        // $post = Post::where("id", $id)->get()->toArray();
        // $post = Post::findOrFail($id)->toArray();
        $post = Post::where("id", $id)->first(); // collection or object ရမယ်

        return view("update", compact("post"));
    }

    public function postEditPage($id)
    {
        $post = Post::where("id", $id)->first();
        // dd($post->toArray());
        // dd($post);
        // $post = Post::where("id", $id)->get()->toArray();
        return view('edit', compact("post"));
    }

    public function postUpdate(Request $request)
    {
        // dd($request->file('postImage'));
        $this->validationCheck($request);
        $updateData = $this->getPostData($request); // already changed to array format
        $id = $request->postId;

        if ($request->hasFile("postImage")) {

            $oldImageName = Post::where("id", $id)->value('image');
            // dd($oldImageName);
            if ($oldImageName != null) {
                Storage::delete("public/" . $oldImageName);
            }
            // $request->file("postImage")->store("myImage");
            $fileName = uniqid() . $request->file("postImage")->getClientOriginalName();
            // dd($fileName);
            $request->file("postImage")->storeAs("public", $fileName);
            $updateData["image"] = $fileName;
        }

        Post::where("id", $id)->update($updateData);

        return redirect()->route("post#createPage")->with(["successMessage" => "Update လုပ်ခြင်းအောင်မြင်ပါသည်"]);
    }


    private function getPostData($request)
    {
        $data = [
            "title" => $request->postTitle,
            "description" => $request->postDescription,
        ];

        // default တန်ဖိုး သတ်မှတ်တာ
        $data["address"] = $request->postAddress == null ? "Mandalay" : $request->postAddress;
        $data["price"] = $request->postPrice == null ? 2000 : $request->postPrice;
        $data["rating"] = $request->postRating == null ? 0 : $request->postRating;



        // dd($data);
        return $data;
    }

    private function validationCheck($request)
    {
        $validationRules = [
            "postTitle" => "required|min:5|unique:posts,title," . $request->postId,
            "postDescription" => "required",
            // "postAddress" => "required",
            // "postPrice" => "required|integer|between:2000,50000",
            // "postRating" => "required|integer|between:0,5",
            "postImage" => "image|mimes:jpg,jpeg,png"

        ];
        $validationMessage = [
            "postTitle.required" => "Post Title ဖြည့်ရန်လိုအပ်ပါသည်",
            "postTitle.min" => "အနည်းဆုံး ၅ လုံးအထက်ရှိရပါမည်",
            "postTitle.max" => "၁၀ လုံးထက်ကျော်၍မရပါ",
            "postTitle.unique" => "Post Title တူနေပါသည်။ တူ၍မရပါ",
            "postDescription.required" => "Post Description ဖြည့်ရန်လိုအပ်ပါသည်",
            // "postAddress.required" => "Address need to be filled",
            // "postPrice.required" => "Price ထည့်ရန်လိုအပ်ပါသည်",
            // "postPrice.integer" => "Integer ဖြစ်ရပါမည်",
            // "postPrice.between" => "Price သည် 2000 နှင့် 50000 ကြားရှိရပါမည်",
            // "postRating.integer" => "Rating သည် Integer ဖြစ်ရပါမည်",
            // "postRating.between" => "Rating must be between 0 and 5",
            "postImage.mimes" => "Image သည် jpg, jpeg, png type သာဖြစ်ရပါမည်",
            "postImage.image" => "uploaded file သည် Image ဖြစ်ရပါမည်",

        ];


        Validator::make($request->all(), $validationRules, $validationMessage)->validate();
    }
}
