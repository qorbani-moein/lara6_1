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
 *       protected $datess = ['deleted_at'];
 *  --now need add col 'deleted_at' in table
 *    in terminal
 *       php artisan make:migration add_recyclebin_to_post_table --table="post"
 *    in up function database/migrations/add_recyclebin_to_post_table/
 *       $table->softDeletes();
 *    in drop function database/migrations/add_recyclebin_to_post_table/
 *       $table->dropColmun('deleted_at');
 *    in terminal
 *       php artisan migrate
 *  --
 */
Route::get('/post/rb','postconterller@rb');



/* One to One Relationship
 * -----------------------------
 * | table poste | table users |
 * -----------------------------
 * per post have user_id to find posted how created
 *
 * in terminal:
 *      php artisan make:migration add_user_id_to_post_table --table="post"
 * in function up add_user_id_to_post_table
 *      $table->integer('user_id')->unsigned();
 */
