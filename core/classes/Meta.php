<?php

 namespace spoova\core\classes;
 use spoova\core\classes\Attribs;

/**
 * This class is a used for building and applying meta tags to the pages. When used, it automatical sets the charset as UTF-8. Other values are added manually
 * 
 * @author Akinola Saheed <teymss@gmail.com>
 */
 class Meta{
    
  	private $charset;
 	private $rcontents;
 	private $contents;
	private $rendering;
	private $meta_on = false;

	/**
	 * Initializes the meta class
	 *
	 * @param boolean $charset character set of meta tag
	 */
 	function __construct($charset = false){
 		(func_num_args() > 0)? $this->charset($charset) :'';
 	}
	
	/**
	 * Sets the charset of the meta tag. 
	 * This should be defined first and can be initialized 
	 * along with the class declaration.
	 *
	 * @param string $charset
	 * @return void
	 */
 	public function charset($charset = 'UTF-8'){
		$this->meta_on = false;
 		$this->charset = $charset;
 		$this->rcontents[0] = ['meta'=>['charset'=>$charset]]; 
 		$this->contents[0]  = '<meta charset="'.$charset.'"/>';
 	}

	/**
	 * Sets the name, type and content attributes of meta tags (only)
	 *
	 * @param string $name as name attribute value of meta tag (except link tags)
	 * @param string $content as content attribute of the meta tag
	 * @param string $type as the type attribute of the meta tag
	 * @return void
	 */
 	public function add($name, $content, $type='name'){
		$this->meta_on = false;
 		if($type == 'property'){
 			$rcontents = ['meta'=>['property'=>$name,'content'=>$content]];
 		}elseif($type == 'http-equiv'){
 			$rcontents = ['meta'=>['http-equiv'=>$name,'content'=>$content]];
 		}else{
 			$rcontents = ['meta'=>['name'=>$name,'content'=>$content]];
 		}
	    
 		$props = $rcontents['meta'];

        $attrs = '';
 		foreach ($props as $key => $value) {
 			if(trim($value) == ''){
 				unset($props[$key]);
 			}else{
 				$attrs .= $key.'="'.$value.'" ';
 			}
 		}

 		$meta =  "<meta ".$attrs."/>"; 

 		if($this->rendering){
           return $meta;
 		}else{
 		   $this->contents[] = $meta;
 		}		

 		$this->rcontents[] = $rcontents;

 	}

	/**
	 * Sets the name, type and content attributes of link tags (only)
	 *
	 * @param string $rel as name relativity value of link tag
	 * @param string $href as href attribute of the meta tag
	 * @param string|array $attrs as other attributes of the meta tag (e.g type, title)
	 *             
	 * @return void
	 */
 	public function link(string $rel,string $href, $attrs){
 		$this->meta_on = false;

		if(is_string($attrs)){
			$attrs = Attribs::split($attrs, 'array');
		}

		$attrs = (array) $attrs;

		$type = $attrs['type']?? '';
		$title = $attrs['title']?? '';

		unset($attrs['type']);
		unset($attrs['title']);

		$pps = ['rel'=>$rel,'href'=>$href,'type'=>$type,'title'=>$title];

		//merge other attributes
		$pps = array_merge($pps, $attrs);

	    $rcontents = ['link'=>$pps];
 		$props = $pps;

		$attrs = '';
 		foreach ($props as $key => $value) {
 			if(trim($value??'') == ''){
 				unset($props[$key]);
 			}else{
 				$attrs .= $key.'="'.$value.'" ';
 			}
 		}

 		$link =  "<link ".$attrs."/>"; 

 		if($this->rendering){
           return $link;
 		}else{
 		   $this->contents[] = $link;
 		}		

 		$this->rcontents[] = $rcontents;
 	}
	
	/**
	 * Shortcut for adding meta tags with name='property'
	 *
	 * @param string $name name attribute of meta tag
	 * @param string $content content attribute of meta tag
	 * @return void
	 */
 	public function prop(string $name, string $content){

	   $this->meta_on = false;
	   $this->add($name, $content, 'property');
	   
 	}
	
	/**
	 * Shortcut for adding meta-equiv (i.e http-equiv='$name') attribute to meta tag
	 *
	 * @param string $name http-equiv value of the meta tag
	 * @param string $content content attribute of the meta tag
	 * @return void
	 */
 	public function equiv($name,$content){

		$this->meta_on = false;
		$this->add($name,$content,'http-equiv');
		        
 	}

	/**
	 * Shortcut for meta refresh 
	 *
	 * @param string $content content attribute (refresh time) of meta tag
	 * @return void
	 */
 	public function refresh($content){
		 $this->meta_on = false;
         $this->add('refresh',$content,'http-equiv'); 		
 	}

	/**
	 * Adds a new name attribute to new meta tag
	 *
	 * @param string $name name attibute of meta tag
	 * @param string $content content attribute of meta tag
	 * @return void
	 */
 	public function name($name, $content){

		$this->meta_on = false;
		$this->add($name,$content); 
		
 	}

	/**
	 * Shortcut for adding og attributes to meta tag (google)
	 *
	 * @param string $name name attibute of meta tag (without colon)
	 * @param string $content attribute of meta tag
	 * @return void
	 */
	public function og($name,$content){

		$this->meta_on = false;
		$this->add('og:'.$name,$content); 

	}  

	/**
	 * removes all stored meta tag from the meta array list
	 *
	 * @return void
	 */
	public function drop(){

		$this->meta_on = false;
		$this->contents = [];
		$this->rcontents = [];

	}

	/**
	 * returns stored data
	 * This function enables developer to view stored meta
	 *
	 * @param bool $type true displays the meta tags stored
	 * @param bool $type returns the array of stored data
	 */
 	public function export(bool $type = false){

 		$contents = $this->contents;

 		if($type == false){
 			foreach ($contents as $value) {
 				print("<pre>".htmlentities($value)."\n</pre>");
 			}
 		}else{
 			return $this->contents;
 		}
 	}

	/**
	 * return or print saved data
	 * This function should be used to add meta to page
	 *
	 * @param bool $type false prints stored meta
	 * @param bool $type true returns $meta
	 */
 	public function dump(bool $type = false){
 		$contents = $this->contents;
		
    	$metas = $contents? implode("\n", $contents) : '';
		if($type == false){
			print $metas;
			return;
		}

		$this->meta_on = true;
		return $metas;
 	}

	public function meta_on(){
		return $this->meta_on;
	}
	
	/**
	 * prints sample meta to the page
	 *
	 * @return void
	 */
	public function samples(){

		$docs = [
			'Basic' => [
				'Title' => "Basic HTML Meta Tags",
				'Meta' => [
					['name'=>'viewport','content'=>"width = 320 ; initial-scale = 1.0; maximum-scale; minimum-scale; user-scalable = no "],
					['name'=>'keywords','content'=>"your, tags"],
					['name'=>'description','content'=>"150 words"],
					['name'=>'subject','content'=>"your website\'s subject"],
					['name'=>'copyright','content'=>"company name"],
					['name'=>'language','content'=>"ES"],
					['name'=>'robots','content'=>"index,follow"],
					['name'=>'revised','content'=>"Sunday, July 18th, 2010, 5:15 pm"],
					['name'=>'abstract','content'=>""],
					['name'=>'topic','content'=>""],
					['name'=>'summary','content'=>""],
					['name'=>'Classification','content'=>"Business"],
					['name'=>'author','content'=>"name, email@hotmail.com"],
					['name'=>'designer','content'=>""],  			
					['name'=>'copyright','content'=>""],
					['name'=>'owner','content'=>""],
					['name'=>'reply-to','content'=>"email@hotmail.com"],  			
					['name'=>'url','content'=>"http://www.websiteaddrress.com"],
					['name'=>'identifier-URL','content'=>"http://www.websiteaddress.com"],  			
					['name'=>'directory','content'=>"submission"],
					['name'=>'category','content'=>""],
					['name'=>'coverage','content'=>"Worldwide"],
					['name'=>'distribution','content'=>"Global"],   
					['name'=>'rating','content'=>'General'],
					['name'=>'revisit-after','content'=>'7 days'],  			
					['http-eqiv'=>'Expires','content'=>'0'],
					['http-eqiv'=>'Pragma','content'=>'no-cache'],
					['http-eqiv'=>'Cache-Control','content'=>'no-cache']
				],
			],

			'OpenGraph' => [
				'Title' => "OpenGraph Meta Tags",
				'Meta' => [
					['name'=>'og:title','content'=>'The Rock'],
					['name'=>'og:type','content'=>'movie'],
					['name'=>'og:url','content'=>'http://www.imdb.com/title/tt0117500/'],
					['name'=>'og:image','content'=>'http://ia.media-imdb.com/rock.jpg'],
					['name'=>'og:site_name','content'=>'IMDb'],  			
					['name'=>'og:description','content'=>'A group of U.S. Marines, under command of...'],
					['name'=>'fb:page_id','content'=>'43929265776'],
					['name'=>'og:email','content'=>'me@example.com'],
					['name'=>'og:phone_number','content'=>'650-123-4567'],  			
					['name'=>'og:fax_number','content'=>'+1-415-123-4567'],
					['name'=>'og:latitude','content'=>'37.416343'],
					['name'=>'og:longitude','content'=>'-122.153013'],
					['name'=>'og:street-address','content'=>'1601 S California Ave'],
					['name'=>'og:locality','content'=>'Palo Alto'],  			
					['name'=>'og:region','content'=>'CA'],
					['name'=>'og:postal-code','content'=>'94304'],
					['name'=>'og:country-name','content'=>'USA'],
					['property'=>'og:type','content'=>'game.achievement'],  			
					['property'=>'og:points','content'=>'POINTS_FOR_ACHIEVEMENT'],
					['property'=>'og:video','content'=>'http://example.com/awesome.swf'],
					['property'=>'og:video:height','content'=>'640'],  
					['property'=>'og:video:width','content'=>'385'],
					['property'=>'og:video:type','content'=>'application/x-shockwave-flash'],  		
					['property'=>'og:video','content'=>'http://example.com/html5.mp4'],
					['property'=>'og:video:type','content'=>'video/mp4'],
					['property'=>'og:audio','content'=>'http://example.com/fallback.vid'],
					['property'=>'og:audio:title','content'=>'Amazing Song'],  			
					['property'=>'og:audio:artist','content'=>'Amazing Band'],
					['property'=>'og:audio:album','content'=>'Amazing Album'],
					['property'=>'og:audio:type','content'=>'application/mp3'],
					['name'=>'custom_name','content'=>'custom_value'],
				]
			],

			'Apple' => [
				'Title' => "Apple Meta Tags",
				'Meta' => [
					['name'=>'apple-mobile-web-app-capable','content'=>'yes'],  		
					['name'=>'apple-touch-fullscreen','content'=>'yes'],
					['name'=>'apple-mobile-web-app-status-bar-style','content'=>'black'],
					['name'=>'format-detection','content'=>'telephone=no'],
				]
			],

			'Explorer' => [
				'Title' => "Internet Explorer Meta Tags",
				'Meta' => [
					['http-eqiv'=>'Page-Enter','content'=>'RevealTrans(Duration=2.0,Transition=2)'],  			
					['http-eqiv'=>'Page-Exit','content'=>'RevealTrans(Duration=3.0,Transition=12)'],
					['name'=>'mssmarttagspreventparsing','content'=>'true'],
					['http-eqiv'=>'X-UA-Compatible','content'=>'chrome=1'],  
					['name'=>'msapplication-starturl','content'=>'http://blog.reybango.com/about/'],
					['name'=>'msapplication-window','content'=>'width=800;height=600'],  			
					['name'=>'msapplication-navbutton-color','content'=>'red'],
					['name'=>'application-name','content'=>'Rey Bango Front-end Developer'],
					['name'=>'msapplication-tooltip','content'=>'Launch Rey Bango\'s Blog'],
					['name'=>'msapplication-task','content'=>'name=About;action-uri=/about/;icon-uri=/images/about.ico'],
					['name'=>'msapplication-task','content'=>'name=The Big List;action-uri=/the-big-list-of-javascript-css-and-html-development-tools-libraries-projects-and-books/;icon-uri=/images/list_links.ico'],
					['name'=>'msapplication-task','content'=>'name=jQuery Posts;action-uri=/category/jquery/;icon-uri=/images/jquery.ico'],
					['name'=>'msapplication-task','content'=>'name=Start Developing;action-uri=/category/javascript/;icon-uri=/images/script.ico'],
				]
			], 	

			'Link' => [
				'Title' => "HTML Link Tags",
				'Link'  => [
					['rel'=>'alternate','href'=>'http://feeds.feedburner.com/martini','type'=>'application/rss+xml','title'=>'RSS'],
					['rel'=>'shortcut icon','href'=>'/favicon.ico','type'=>'image/ico','title'=>''],  			
					['rel'=>'fluid-icon','href'=>'/fluid-icon.png','type'=>'image/png','title'=>''],
					['rel'=>'me','href'=>'http://google.com/profiles/thenextweb','type'=>'text/html','title'=>''],
					['rel'=>'shortlink','href'=>'http://blog.unto.net/?p=353','type'=>'','title'=>''],
					['rel'=>'archives','href'=>'http://blog.unto.net/2003/05/','type'=>'','title'=>'May 2003'],  			
					['rel'=>'index','href'=>'http://blog.unto.net/','type'=>'','title'=>'DeWitt Clinton'],
					['rel'=>'start','href'=>'','type'=>'','title'=>'Pattern Recognition 1'],
					['rel'=>'prev','href'=>'http://blog.unto.net/opensearch/opensearch-and-openid-a-sure-way-to-get-my-attention/','type'=>'','title'=>'OpenSearch and OpenID? A sure way to get my attention.'], 
					['rel'=>'next','href'=>'http://blog.unto.net/meta/not-blog/','type'=>'','title'=>'Not blog'],
					['rel'=>'search','href'=>'/search.xml','type'=>'application/opensearchdescription+xml','title'=>'Viatropos'],  			
					['rel'=>'self','href'=>'http://www.syfyportal.com/atomFeed.php?page=3','type'=>'application/atom+xml','title'=>''],
					['rel'=>'first','href'=>'http://www.syfyportal.com/atomFeed.php','type'=>'','title'=>''],
					['rel'=>'next','href'=>'http://www.syfyportal.com/atomFeed.php?page=4','type'=>'','title'=>''],
					['rel'=>'previous','href'=>'http://www.syfyportal.com/atomFeed.php?page=2','type'=>'','title'=>''],  			
					['rel'=>'last','href'=>'http://www.syfyportal.com/atomFeed.php?page=147','type'=>'','title'=>''],
					['rel'=>'shortlink','href'=>'http://smallbiztrends.com/?p=43625','type'=>'','title'=>''],
					['rel'=>'canonical','href'=>'http://smallbiztrends.com/2010/06/9-things-to-do-before-entering-social-media.html','type'=>'','title'=>''], 	
					['rel'=>'EditURI','href'=>'application/rsd+xml" title="RSD" href="http://smallbiztrends.com/xmlrpc.php?rsd'],
					['rel'=>'pingback','href'=>'http://smallbiztrends.com/xmlrpc.php'],  			
					['rel'=>'stylesheet','href'=>'http://wordpress.org/style/iphone.css" type="text/css'],
					//['rel'=>'','href'=>''], //media
				]		
			], 				

		];

		$metaString = "";

		foreach ($docs as $key => $value) {

			foreach ($value as $vkey => $vval) {

			   if(!is_array($vval)){
				   $metaString .= "\n\n".$vval."\n\n";
			   }else{
				   $tagName = strtolower($vkey);
				   foreach ($vval as $tags => $tagval) {

						 $tagAttrs = '';
						 if(is_array($tagval)){
						 foreach ($tagval as $tkey => $tval) {
							 if($tval != ''){
							   $tagAttrs .= " ".$tkey.'="'.$tval.'"';
						   }
						 }                      	
						 }
				   
					   $metaString .= "<".$tagName." ".$tagAttrs."> \n"; 
				   }
				   
			   }
			}
		}

		print("<pre>".htmlentities($metaString)."</pre>");
	}
 }

 /* 
   SAMPLE

   $meta = new \core\classes\Meta;

   $meta->name('viewport', 'width=device-width, initial-scale=.9, maximum-scale=1.0, user-scalable=1');
   $meta->name('description', 'website_description');
   $meta->prop('og:title', 'website_name');
   $meta->prop('og:image', '//website_icon_url');
   $meta->prop('og:type', 'website');
   $meta->link('icon', 'https://www.website.com/path_to_icon","image/png');

   //print out saved meta
   $meta->dump(); //prints meta
   $meta->dump(true); //returns meta
    
   $meta->view(); //display meta tags
   $meta->view(true); //displays meta array list
 */
 
?>