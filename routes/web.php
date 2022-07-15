<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/me',function (){
//   return "me";
//});
//
//Route::get('/show/{id}',function ($id = null){
//    return "show: " . $id ;
//});
//
//Route::get('/profile','profileController@index');
//Route::get('/user/{id},{code}','profileController@userView');

//Route::resource('/profile/{id}','UsersController@index');

//Route::resource('/profile/setting/{id}','UsersController@index');

Route::get('/about',function (){
    return view('about');
//    return 'asd';
});
Route::get('/about/{emp?}-{id?}','staticPage@about');

Route::prefix('setting')->group(function(){
    Route::get('/main','usersetting@main');
    Route::get('/users','usersetting@users');
});


// help migrate
/*
 * for user datebase
 * 1. .env => set username AND password database to connect
 * 2. config/database.php => set get date from .env fo database important('charset' => 'utf8','collation' => 'utf8_unicode_ci',)
 * 3. all command for (create/update/drop/...) of database is database/migrations/
 * 4. in per migrate in function Up is Schema::create > to create table
 * 5. for make new migrate in terminal: php artisan make:migration {name in path} --craete="{name table}"
 * 6. ex: php artisan make:migration posts --create="posts"
 * 7. for run migrate in terminal: php artisan migrate
 * 8. always is cache migrate for clear cache in terminal: php artisan config:clear
 * 9. in terminal: php artisan migrate:refresh -> delete all table and rebuild database from command migrate
 * 10.in terminal: php artisan migrate:rollback -> go back one step in run command migrate
 * 11.for add field in database should make new migrate -> in terminal php artisan make:migration {name in path} --table="{name of table we will update}"
 * 12.ex: php artisan make:migration add_is_admin --table="posts"
 * 13.type field in database ($table->{type})
 * 14.ex: $table->{string- bigIncrements(number AUTO_INCREMENT)}
 * /not work in project
 * 15.for edit structer field table we should install dbal in terminal: composer requite doctrine/dbal
 * 16. migrate for change in terminal: php artisan make:migration change_post_content --table="post"
 * 17.in migrate file added in function -> $table->string('title','230')->change();
 * \
 */


/*
 * insert / delete / update in DB
 */

Route::prefix('db')->group(function(){
    Route::get('/insert/{content}','postconterller@insert');
    Route::get('/select/','postconterller@select');
    Route::get('/update/','postconterller@update');
    Route::get('/delete/{id}','postconterller@delete');

});

/*
 * Model
 */

Route::get('/post/all','postconterller@allpost');
Route::get('/post/save','postconterller@savePost');
Route::get('/post/update','postconterller@updatePost');
Route::get('/post/delete','postconterller@deletePost');

/* Recycle Bin
 *    in model add(in to)
 *       {use Illuminate\Database\Eloquent\SoftDeletes; //Recycle Bin}
 *    in class model add
 *       use SoftDeletes;
 *       protected $date = ['deleted_at'];
 *  --now need add col 'deleted_at' in table
 *    in terminal
 *       php artisan make:migration add_recyclebin_to_post_table --table="post"
 *    in up function database/migrations/add_recyclebin_to_post_table/
 *       $table->softDeletes();
 *    in drop function database/migrations/add_recyclebin_to_post_table/
 *       $table->dropColmun('deleted_at');
 *    in terminal
 *       php artisan migrate
 *    first call Route(/post/rb/delete/)->destroy
 *    secend call Route(/post/rb/show/) to show all destroyed
 *    for 100% delete cal foreceDelete
 *  --
 */
Route::get('/post/rb/show','postconterller@workWithTrash');
Route::get('/post/rb/delete','postconterller@foreceDelete');
Route::get('/post/rb/restor','postconterller@restorPost');



/* One to One Relationship
 * find user and get post of user
 * -----------------------------
 * | table poste | table users |
 * -----------------------------
 * per post have user_id to find posted how created
 *
 * in terminal:
 *      php artisan make:migration add_user_id_to_post_table --table="post"
 * in function up add_user_id_to_post_table
 *      $table->integer('user_id')->unsigned();
 * in function drop add_user_id_to_post_table
 *      $table->dropColumn('user_id');
 * in terminal:
 *      php artisan migrate
 * for create relationship from model post to model user code below in model user added
 *     public function post()
        {
            return $this->hasOne(post::class);
        }
 * now for add Route in web.php in below code
 *
 */

Route::get('user/{id}/post',function($id){

    //find(user)-> get post
//    $user_post= \App\User::find(2)->post;// 2-> id user in user table
//    return $user_post;

    //find(user)-> get post -> get title
    $user_post= \App\User::find($id)->post;// id-> id user in user table
    return $user_post;
});

/*
 * reverse request
 * find post and  get user of post
 * if model post add code:
 *    public function user()
    {
        //این کلاس متعلق است به کلاس یوزر
        return $this->belongsTo(User::class);
    }
 *
 *
 */


Route::get('post/{id}/user',function($id){

    $post_user = \App\Post::find($id)->user;
    return $post_user;
});

/*
 * many to One Relationship
 * find user and get All posts
 * in model user add code:
 *    public function posts()
        {
            return$this->hasMany(post::class);
        }
 *
 *
 */

Route::get('user/{id}/posts',function ($id){
    //get all post of user
    $user_posts = \App\User::find($id)->posts;

    foreach ($user_posts as $user_post) {
        echo $user_post->title;
        echo '</br>';
    }
});

/*
 * Many to Many Relationship
 *
 * in example create model role and table
 * in terminal:
 *      php artisan make:model Role -m {-m -> magration}
 * in migrate create_roles_table function up:
 *      $table->string('name');
 * for use (Many to Many Relationship) we need new table to put Relationship. Name of Operation is pivot
 * in terminal:
 *      php artisan make:migration add_pivot_role_user_table --create=role_user
 * in migration add_pivot_role_user_table function up:
 *      $table->integer('user_id')->unsigned();
 *      $table->integer('role_id')->unsigned();
 * now create migrate
 * in terminal:
 *      php artisan migrate
 * in database(phpmyadmin) add 2 user
 * in database(phpmyadmin) add 1 role
 *
 * in model Role:
 *   public function users()
    {
        //هر کاربر میتواند چند نقش بگیرد
        return $this->belongsToMany(User::class);
    }

 *
 * in model post
 *   public function roles()
    {
        //هر نقش میتواند به چندین کاربر تعلق بگیرد
        return $this->belongsToMany(Role::class);
    }
 *
 */
// Relattion from User for get role
Route::get('user/{id}/roles',function($id){

    //get all role of User
//    $user_roles = \App\User::find($id)->roles;
//    return $user_roles;

    //get all date of role of user and just get name of role
    $user_roles = \App\User::find($id)->roles;
    foreach ($user_roles as $user_role) {
        echo $user_role->name;
        echo '<br>';
    }
});

// Relation from role for get user
Route::get('role/{id}/users',function($id){
   $role_users = \App\Role::find($id)->users;
   return $role_users;
});


/*
 * ex many to any Relationship
 *
 * table created:
 *  comments -> end name of table just (s) -> comment(s)
 *  hashtags -> end name of table just (s) -> hashtag(s)
 *  comment_hashtag
 *
 *
 *
 */

Route::get('hashtag/{id}/comments',function ($id){
    $comment = \App\hashtag::find($id)->comment;
    return $comment;
});

Route::get('comment/{id}/hashtags',function ($id){
    $hashtag = \app\comment::find($id)->hashtag;
    return $hashtag;
});

Route::get('user/{id}/hashtag',function ($id){
//    $hashtag = \App\hashtag::find($id)->user;
//    return $hashtag;
    $hashtag= \App\User::find($id)->hashtag;
    return $hashtag;
});

//Tinker
/*
 *
 * Run Tinker in terminal:
 *      php artisan tinker
 *      $post = new App\Post
 *      $post->title= 'new post with Tinker'
 *      $post->content = 'content post with Tinker'
 *      $post_user_id = 1
 *      $post->save()
 */


// CRUD on to many Relationship
/*
 * easyless to Relationship
 * in example bottom save($post)-> get id user in from post
 *
 * for True Working we need write function in model user:
 *       public function posts()
        {
            return $this->hasMany(post::class);
        }
 *
 *
 */

Route::get('/crud/create',function(){
   $user = \App\User::find(2);
   $post = new \App\Post();
   $post->title = 'new title post of crud';
   $post->content = 'new content post of crud';

   $user->posts()->save($post);
});

// For View data of model User
// call use (dd)

Route::get('/crud/read',function(){
   $user = \App\User::find(1);
//    dd($user);
    foreach ($user->posts as $post) {
        echo $post->title;
        echo "<br/>";

    }
});

//find Post of User and edit with id post
Route::get('/crud/update',function(){
    $user = \App\User::find(1);
    $user->posts()->whereId(1)->update(['title'=>'curd used']);
});

//find post of User and delete with id post
Route::get('/crud/delete',function(){
    $user = \App\User::find(1);
    $user->posts()->whereId(1)->delete;
});

// Crud many to Many Relationship
/*
 *
 */

Route::get('/crud/mtm/create',function(){
    $user = \App\User::find(1);
    $role = new \App\Role();
    $role->name = 'author';
    $user->roles()->save($role);
});
