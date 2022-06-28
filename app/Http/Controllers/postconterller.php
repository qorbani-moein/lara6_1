<?php

namespace App\Http\Controllers;

use App\post;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class postconterller extends Controller
{
    //public $operation;
    public function insert($content)
    {
        DB::insert('insert into post(title,content)values(?,?)',['111','222']);
//        DB::insert("insert into post(title,content)values('عنوان','متن')");
        $operation = "insert";
        return view('layouts.db',compact(['operation','content']));
    }

    public function select()
    {
        return $content = DB::select('select * from post');
        $operation = "select";
        //return view('layouts.db',compact(['operation']));
    }

    public function update()
    {
        return DB::update("UPDATE post set title='new title' WHERE id=2" );
    }

    public function delete($id)
    {
        return DB::delete("DELETE FROM post WHERE id='" . $id ."'");
    }

    public function allpost()
    {
        //for work with table->post we should add code in post modle {protected $table = 'post';}
//        $post=post::all();
//        return $post;

        //find by id field
//        $post=post::find(2);
//        return $post;

        //where in sql
//        $post = post::where('title','111')->orderby('id','asc')->get(); //desc //asc
//        return $post;

        $post = post::where('title','111')->orderby('id','asc')->take(1)->get(); //take = limit(sql)
        return $post;

        // if not found result. show 404
//        $post=post::findOrFail(2);
//        return $post;




    }

    public function savePost()
    {
        //for work with table->post we should add code in post modle {protected $table = 'post';}
//        $post = new post();
//
//        $post->title='عنوان ';
//        $post->content = 'توضیح';
//
//        $post->save();
//

        //for work with table->post in methode create we should add code in post modle {protected $fillable = ['title','content'];}
        $post = post::create(['title'=>'title 2' , 'content'=>'content 2']);
    }
}
