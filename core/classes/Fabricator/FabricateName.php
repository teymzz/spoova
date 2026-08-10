<?php

namespace spoova\mi\core\classes\Fabricator;

use spoova\mi\core\classes\Fabricator\FabricatorAbstract;
use spoova\mi\core\classes\Anonymous;

use function spoova\mi\core\classes\Anonymous;

class FabricateName extends FabricatorAbstract {

  private static array $fabrications = [];
  
  /**
   * @param string $type options [masculine|feminine|firstname|lastname]
   *  - Options can be separated by pipe
   */
  public static function fabricate(string $type = 'Firstname|Lastname') : string {

    self::save(get_called_class());

    // $generateName = function($type) {

    //   $initials = self::initials();

    //   $feminine = self::feminine();

    //   $masculine = self::masculine();

    //   $type = strtolower($type);

    //   if($type === 'firstname'){
    //     // mix feminine & masculine
    //     $mix = array_merge($masculine, $feminine);
    //     return $mix[array_rand($mix)];
    //   } else if ($type === 'lastname'){
    //     return $initials[array_rand($initials)];
    //   } else if ($type === 'masculine'){
    //     return $masculine[array_rand($masculine)];
    //   } else if ($type === 'feminine'){
    //     return $feminine[array_rand($feminine)];
    //   }

    // };

    Anonymous::fn(function($type){

      $type = strtolower($type);
      $initials = self::initials();
      $feminine = self::feminine();
      $masculine = self::masculine();
      
      if($type === 'firstname'){
        // mix feminine & masculine
        $mix = array_merge($masculine, $feminine);
        return $mix[array_rand($mix)];
      } else if (in_array($type, ['lastname','surname','initial'])){
        return $initials[array_rand($initials)];
      } else if ($type === 'masculine'){
        return $masculine[array_rand($masculine)];
      } else if ($type === 'feminine'){
        return $feminine[array_rand($feminine)];
      }

    }, $generatorId);
    
    $types = explode('|', $type);
    $names = '';
    
    foreach ($types as $key => $type){
      if($key > 0) $names .= " ";
      $names .= Anonymous($generatorId)($type);
    }
    self::$fabrications[] = $names;
    return $names;
    
  }
  
  private static function initials() : array {
    return [
      "Ford","Russel","Brown","Wood",
      "Green","Roberts","Hall","Wright","Bright",
      "Brighton","Evans","Williams","Taylor","Jones",
      "Walker","Thompson","Arslan","Keller",
      "Huber","Meyer","Reyes","Brunner","Olssen","Olsen","Larsen",
      "Karlsson","Hanson","Andersson","Fernandez","Martinez",
      "Lopez","Peres","Pires","Moyes","Sanchez","Ruiz","Alonso","Romero",
      "Torres","Ramos","Ramirez","Pavlov","Gomez","Alvez","Viera",
      "Eriksen","Berg","Fox","Klein","Becker","Bliss","Russo","Bruno",
      "Marino","Costa","Bianco","Amari","Valentiano","Orlando","Romeo","O'Neill",
      "O'Connor","Sullivan","Kelly","Wagner","Hoffmann","Richard","Leroy","Laurent",
      "Bertrand","Roux","Morel","Lambert","Bonnet","Garcia","Michel","Salonen","Smith",
      "Petrovic","Dimitrov","Denis","Schwarz","Muller","Miller","Lee","MacDonald","Santos",
      "Diaz","Aguera","Vasquez","Castillo","Ceasar","Castro","Garza","Cortez","Suarez",
      "Silva","White","Robinson","Young","Allen","Scott","Philips","Turner","Parker",
      "Edwards","Collins","Stewart","Morris","Rogers","Reed","Howard","Richardson","Watson",
      "Brooks","Bennett","Gray","James","Watford","Foster","Sanders","Powell","Jekins",
      "Ward","Hughes","Morales","Ross","Foxx","Carter","Serrano","Zamora","Valencia",
      "Butler","Fisher","Anderson","Moore","Hernandez","Lewis","Campbell","Bailey","Bell",
    ];
  }
  
  private static function masculine() : array {
    return [
      "Felix","Russel","Ethan","William",
      "Greg","Tom","Randy","Fred","Bob",
      "Kai","Lucas","Kim","Ryan","Anthony",
      "Andrew","Tyler","Brandon","Alexander",
      "Benjamin","Bobby","Dave","Drake","Adrian",
      "Roman","Reyes","Ramsey", "Franklin","Pedro",
      "Patrick","Cane","Bryan","Bradley","Scott",
      "Robin","George","Gibbs","Henry","Edward",
      "Jackson","Oliver","Caleb","Wiltord","Ted",
      "Ali","Cameron","Adam","Rick","Authur","Arnold",
      "Austin","Bart","Brian","Bruce","Carl","Chuck","Clark",
      "Clinton","Cooper","Cyrus","Damian","Derreck","Davis",
      "Desmond","Donald","Douglas","Dwayne","Ebert","Edwin",
      "Elliot","Elton","Elvis","Fabian","Finn","Frank","Frederick",
      "Gerald","Gerrad","Gilbert","Harold","Harrison","Hector","Hope","Herman",
      "Hen","Jason","Kelvin","Kenneth","Kent","Kyle","Landon","Larry",
      "Lincoln","Luther","Mac","Madison","Malcom","Martin","Marvin","Max",
      "Mike","Miles","Mac","Nate","Miguel","Nelson","Newt","Nicolas",
      "Owen","Percy","Oscar","Ralph","Raymond","Richie","Stanford",
      "Steve","Sylvester","Taylor","Theo","Tony","Tyson","Victor","Vincent",
      "Walker","Wallace","Wayne","Wilfred","Wesley","Will","Willis","Zack",
      "Clark","Alan","Antonio","Albert","Andres","Alfred","Alec","Alvares",
      "Keiran","Tierney","Ambrose","Andreas","Benjamin","Bentley","Carlos",
      "Dominic","Cedric","Cole","Charles","Calvin","Craig","Claude","Dean",
      "Drake","Dennis","Dalton","Derek","Edgar","Evan","Elvin","Howard","Jeremy",
      "Juan","Karl","Leonard","Lawrence","Lucien","Marc","Maxwell","Mitchell","Mateo",
      "Smith","Niles","Palmer","Powell","Ryder","Sebastian","Sylvan","Weston"
    ];
  }
  
  private static function feminine() : array {
    return [
      "Emily","Dorothy","Rihanna","Lois",
      "Lane","Lana","Rose","Alexander","Mara",
      "Louis","Molly","Patricia","Pamella","Angelina",
      "Caroline","Ava","Alexis","Annie",
      "Anabelle","Jamie","Jenna","Sophie","Morgana",
      "Veronica","Vicky","Tessa","Jessica","Jennifer",
      "Simbi","Alena","Serena","Samantha","Isabella","Olivia",
      "Abigail","Adriana","Agatha","Helen","Alex","Alice","Bella","Jenny",
      "Betty","Bonny","Bridget","Carissa","Caroline","Cassidy","Clara","Gold",
      "Claire","Cindy","Clarice","Evelyn","Faith","Felicity","Florence","Hayley","Damond",
      "Iris","Isabel","Jasmine","Jane","Jess","Elsa","Joanne","June","Diana",
      "Katherine","Katie","Katrina","Lacey","Larissa","Lauren","Leisha","Lexi",
      "Lily","Linda","Lucy","Lydia","Margaret","Marsha","May","Megan","Minna",
      "Nadia","Nancy","Natalie","Mindy","Mellisa","Belle","Loraine","Lara","Leila",
      "Winnie","Rhoda","Jasamine","Lizzy","Jess","Juliana","Judy","Justina","Abeth",
      "Bethany","Belinda","Enrica","Blake","Naomi","Angela","Alexie","Chloe","Charlotte",
      "Christina","Camila","Caitlin","Cassandra","Ciara","Courtney","Catherine","Cynthia",
      "Clarissa","Stephine","Sophia","Stella","Savannah","Sasha","Sylvia","Sabrina","Simone",
      "Thea","Tiffany","Tara","Bianca","Beatrice","Barbara","Bonnie","Bailey","Ella","Freya",
      "Floria","Fatima","Iris","Juliet","Julia","Kate","Lauren","Morgan","Marina","Monica","Margeret",
      "Nina","Nicolette","Nicki","Nora","Nicole","Nathalie","Octavia","Penelope","Pandora","Priscilla",
      "Rita","Rosalie","Riley","Ruby","Roxanne",
    ];
  }

  public static function randomize() : string {

    $fabrications = self::$fabrications;
    $fabrications = implode(" ", $fabrications);
    $fabrications = trim($fabrications, " ");
    $fabrications = explode(" ", $fabrications);
    $fabrications = array_unique($fabrications);
    shuffle($fabrications);
    $test = [1, 3, 4, 5, 6, 7, 2];
    $strName = ($test[array_rand($test)] % 2 === 0)? implode('', $fabrications) : $fabrications[0];

    $suffix = substr($strName, 0, 4);
    $strParts = str_split($strName, 3);
    shuffle($strParts);

    $strName = $suffix.($strParts[0] ?? '').((date('s') % 2 == 0)? randice(3, '12345678_') : '');

    return $strName;

  }

  public static function reset(){
    self::$fabrications = [];
  }
  
}