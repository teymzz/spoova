<?php

namespace spoova\mi\windows\Routes;

use Res;
use Session;
use spoova\mi\core\classes\Request;
use spoova\mi\windows\Frames\AccessFrame;
use spoova\mi\windows\Models\Access\AccessModel;

class Login extends AccessFrame {
    
    public function __construct($Request){

        Session::onauto('login', 'home');

        Res::setFlash('mod', 'me');

        print Res::flash('mod');

        $this::preload([window(':')], fn() => AccessModel::onSubmit() );
        
        $this::call($this,
            [
                window(':') => 'root',

                SELF::ONCALL => function() {
                    print window('base');
                },
            ]
        ); 

    }


    function root($vars, Request $Request) {
        
        self::load('login', fn() => compile() );
        
    }

    /**
     * Add name of routes
     *
     * @return array
     */
    public static function addRoutes(array $array = []) : array {

        return [
            // 'routeName' => 'routePath'
        ];

    }

    // function hey($vars, Request $Request){

    //     $Posts = new DataModel(new PostsModel);

    //     //$Posts::ofUser()->read();

    //     // $Posts = new DataModel(PostModel::class);

    //     // $Posts::ofUser() -> where ('data = ? ', []);

    //     // $Posts = 

    //     //     // select * from posts where userid = User::mainid() and date = ? 
    //     //     Posts::ofUser('user_id')->where('date = ?', []);

    //     //     //select * from user join posts on user.id = Posts.userid where user = ? and date > ?
    //     //     User::on(Post::class, 'outer')
    //     //           ->where('user = ? and date > ?')
    //     //           ->read(['firstname','lastname'])
    //     //           ->as(['first','last'])->posts;

    //     //     Posts::on(User::class)
    //     //            ->where('user = ? and date > ?', [User::autoID(), Now()])
    //     //            ->get(1);
    //     //     //select * from posts join user on Post.id = User.postid where user = ? and date > ?
    //     //     Posts::insert();

            

    //     //     Posts::ofUserFriends()->where('date = ?', []);

    //     //     return Friends::class;

    //     //     return User::hasMany(Friends::class);

    //     //     Posts::user()->where();
    //     //     Friends::user()->where();
    //     //     Posts::where()->

    //     // user()->posts()->where('title = 10');
    //     // user()->friends()->where('title = 10');
    //     // user()->house()->where('title = 10');
    //     // 
    //     // $data = $data->get(0);
    //     // // vdump($data->loop());
    //     // //print_r($data);
    //     // //if($data->exists()) {
    //     //     foreach($data->loop() as $value){
    //     //       //foreach($value as $userdata){
    //     //         print br($value);
    //     //       //}
    //     //     }
    //     // //}

    //     // $array = [
    //     //     0 => [
    //     //         'name' => 'boy',
    //     //         'ageRange' => ['74','34','21']
    //     //     ]
    //     // ];

    //     // $data = new DataObject($array);
        
    //     // vdump($data->pull('ageRange')->protect('1')->pull(1));
        
    //     // // vdump($data, $data->loop(), $id);

    //     // $dataid = $data;

    //     //vdump($dataid->protect(['password']));

    //     //foreach($data->data as $key => $value){

    //     //}
    //     // foreach($id as $key => $data){
    //     //     //vdump($key);
    //     // }
    //     // $data = user('user_entity')->data()->getPassword();
    //     //vdump($data->protect(['password'])->toJson());
    //     //$Request->strict();['data' => $data]

    //    self::load('hey', fn() => compile() );
    // }



}
