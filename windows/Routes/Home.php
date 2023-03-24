<?php

namespace spoova\mi\windows\Routes;

use DBStatus;
use Form;
use spoova\mi\core\classes\Collection;
use spoova\mi\core\classes\Request;
use spoova\mi\windows\Frames\UserFrame;
use spoova\mi\windows\Models\Posts;
use User;
use Window;

class Home extends UserFrame {
    
    public function __construct(){

        self::onCall([
            window(':') => fn() => $this->handlePosts()
        ]);

        self::call($this, 
            [
                window(':') => 'root',

                SELF::ONCALL => function() {
                    alert();
                }
            ]
        );

    }

    function root() { 
        
        monitor();

        // print Res::live();

        // $Test = new Test;

        // $Test->heyf;

        // $userID = User::id()->primary();

        // $Postss = ( Posts::of('userd') -> read([], [2]) -> Collection() );

       

        // Collection::protect(['Author']);

        // $Posts = ( Posts::of('user') -> read([], [2]) -> Collection() );
        
        //vdump(Posts::read() -> withDefault(['author'=>'xyz']) -> read() -> User);
     
        // vdump( Posts::user() -> withDefault(['Author' => 'Meyit']) -> byRecent() -> read(['posts.id as postid']) -> Posts );



        //$Posts = ( Posts::of('user') -> read() -> Posts );
        // $Posts = Posts::pull()->user();
        
        // vdump($Posts);

        //$Posts = Posts::pull()->users;

        // hasOne(Comment::class) :  Post::comments()->read(1)->comments 
        // hasOne(Comment::class) :  Select * from posts join comment on posts.id = comment.posts_id

        // hasMany(Comment::class) :  Post::comments()->read(1)->comments 
        // hasMany(Comment::class) :  Select * from comments join posts on posts.id = comment.posts_id

        //belongsTo(Comment::class) : Post::comments()->read(1)->comments       
        //belongsTo(Comment::class) : Select * from comments join posts on comment.id = posts.commeny_id       

        //belongsTo(Posts::class) : Comment::posts()->read(1)->posts       
        //belongsTo(Posts::class) : Select * from comment join posts on posts.id = comment.post_id       

        // Post::comments() -> read() -> comments
        // Post::comments() -> read() -> Post 

        //Posts::Users()->read(['firstname','lastname'], 1)->Users;
        //Posts::Users()->read(['firstname','lastname'], 1)->Posts;
        //Posts::Users()->delete(1)->Posts;

        // User belongsTo Phone (hasOne) idealistic
        //Phone::User()->read()->Phone; (relationship owned by Phone)
        //Select * from Phone Join User on Phone.id = User.phone_id
        // Phone::User()

        //User::Phone()->read()->Usee; (relationship owned by Phone)
        //Select * from Phone Join User on Phone.id = User.phone_id
        // Phone::User()

        // Phone belongsTo User (hasMany) real
        // Phone::User('h_id')->read()->User; (relationship owned by User)
        // Select * from User Join Phone on Phone.id = User.h_id

        //User::Phone()->read()->Users;
        //Select * from Phone Join Users on Users.id = Phone.user_id

        //Phone::Users()->read()->Phone;
        //Select * from Posts Join Users on Users.id = Phone.user_id

        //vdump($Posts);

        /* 
            Structures -------------------------

            Syntax 1:
            Posts::of('users','ForeignKey', 'ForeignModelField') //users => id
            Comments::of('admins','ForeignKey', 'ForeignModelField') //admin => id
            
            Comments::of('admins')->bind('users')
             //select * from comments join admin on Comments.adminid = admin.id 
        
             //    Pr: users.id, Fr:userid; Pr: posts.id, Fr: postid   
             //Users::on('posts', 'uid')   ->on('friends')

             //Correct Relationship of above
             // users.id, userid; friends.id; friendid
             // Users::on(Friends::class)->on('posts') // on friends.userid = Posts.userid
             // Posts::from(Friends::class)->from(User::class) // on friends.userid = Posts.userid
             
             =>> Select * from Posts join Friends 
             on Friends.userid = Posts.userid 
             on Posts.userid = User.id
             where user.id = 1
             
             //  belongsTo: user_id       user_id             user.id
             // Posts::from(Friends::class)->from(User::class) // on friends.userid = Posts.userid
                
                =======>> select * from Posts 
                            join Friends on Posts.user_id = Friends.user_id 
                            join Users on Posts.user_id = Users.id 
             
                =>> select * from Posts join Friends 
                        on Friends.id = Posts.Friend_id 
                        on Posts.userid = User.id
                        where user.id = 1
        
                        where('user.id = 1')
             */

        // new CollectionItems()
        // $Posts = (new CollectionItems(['password' => 'hi']));
        //$Posts = (Collection::list(['password' => 'hi'])->Collection);
        // foreach($Posts as $data => $value) {

        //     vdump($value);

        //0}a
        //$Posts = Posts::where("id='1");
        //vdump($Posts);
        /* 
            $Post1 = new Post::data([a, b, c]);
            $Post2 = new Post([a, d, e]);

            $Post1::$data > [a, b, c];
            $Post2::$data > [a, d, e]
        */

        //$Posts = is_array($Posts?? [])? ($Posts??[]) : [];
  
        //self::load('homex', fn() => compile(['posts' => $Posts]) );
        
    }

    private function handlePosts() {
        
        $Request = new Request;

        if($Request->isPost()) {

            Form::model(new Posts);

            $data = $Request->data();

            $data['userid'] = User::id()->primary();

            Form::loadData($data);

            ( Form::isAuthenticated() && Form::isSaved() );

            if( Form::errors() ) {

            }

        }


    }

}
