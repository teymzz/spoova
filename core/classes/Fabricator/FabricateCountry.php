<?php

namespace spoova\mi\core\classes\Fabricator;

use ErrorException;

class FabricateCountry implements FabricatorInterface {
  
  public static function fabricate(?string $geo = null) : string {
    
    if($geo === null){
      
      $africa = self::Africa();
      $asia = self::Asia();
      $europe = self::Europe();
      $namerica = self::NorthAmerica();
      $samerica = self::SouthAmerica();
      $oceania = self::Oceania();
      
      $all = array_merge($africa, $asia, $europe, $namerica, $samerica, $oceania);
      
      return $all[array_rand($all)];
      
    }else if(method_exists(get_called_class(), $geo)){
      
      $continent = self::$geo();
      return $continent[array_rand($continent)];
      
    }else
    
    throw new ErrorException('invalid option supplied');
    
  }
  
  private static function Africa() : array {
    return [
      'Algeria', 'Angola', 'Benin', 'Botswana',
      'Burkina Faso', 'Burundi', 'Cabo Verde (Cape Verde)', 'Cameroon', 'Central African Republic', 'Chad', 'Comoros', 'Democratic Republic of the Congo (Congo-Kinshasa)',
      'Republic of the Congo (Congo-Brazzaville)',
      'Djibouti', 'Egypt', 'Equatorial Guinea',
      'Eritrea', 'Eswatini (Swaziland)', 'Ethiopia',
      'Gabon', 'Gambia', 'Ghana', 'Guinea', 'Guinea-Bissau', 'Ivory Coast (Côte d\'Ivoire)',
      'Kenya', 'Lesotho', 'Liberia', 'Libya',
      'Madagascar', 'Malawi', 'Mali', 'Mauritania',
      'Mauritius', 'Morocco', 'Mozambique', 'Namibia',
      'Niger', 'Nigeria', 'Rwanda', 'Sao Tome and Principe', 'Senegal', 'Seychelles', 'Sierra Leone', 'Somalia', 'South Africa', 'South Sudan', 'Sudan', 'Tanzania', 'Togo', 'Tunisia', 'Uganda', 'Zambia', 'Zimbabwe'
    ];
  }
  
  
  private static function Asia() : array {
    return [
      "Afghanistan", "Armenia", "Azerbaijan",
      "Bahrain", "Bangladesh", "Bhutan",
      "Brunei", "Cambodia", "China",
      "Cyprus", "Georgia", "India",
      "Indonesia", "Iran", "Iraq", "Israel",
      "Japan", "Jordan", "Kazakhstan",
      "Kuwait", "Kyrgyzstan",
      "Laos", "Lebanon", "Malaysia",
      "Maldives", "Mongolia", "Myanmar (Burma)", "Nepal", "North Korea", "Oman", "Pakistan",
      "Palestine", "Philippines", "Qatar", 
      "Saudi Arabia", "Singapore", "South Korea",
      "Sri Lanka", "Syria", "Taiwan",
      "Tajikistan", "Thailand",
      "Timor-Leste (East Timor)",
      "Turkey", "Turkmenistan",
      "United Arab Emirates", "Uzbekistan",
      "Vietnam", "Yemen"
    ];
  }
  
  private static function Europe() : array {
    return [
      "Albania","Andorra","Armenia",
      "Austria", "Azerbaijan", "Belarus",
      "Belgium", "Bosnia and Herzegovina",
      "Bulgaria", "Croatia",
      "Cyprus", "Czech Republic (Czechia)",
      "Denmark", "Estonia", "Finland",
      "France", "Georgia", "Germany",
      "Greece", "Hungary", "Iceland",
      "Ireland", "Italy", "Kazakhstan",
      "Kosovo", "Latvia", "Liechtenstein",
      "Lithuania", "Luxembourg",
      "Malta", "Moldova", "Monaco",
      "Montenegro", "Netherlands",
      "North Macedonia", "Norway",
      "Poland", "Portugal", "Romania",
      "Russia", "San Marino", "Serbia",
      "Slovakia", "Slovenia", "Spain",
      "Sweden", "Switzerland", "Turkey",
      "Ukraine","United Kingdom",
      "Vatican City (Holy See)"
    ];
  }
  
  private static function NorthAmerica() : array {
    
    return [
      "Antigua and Barbuda", "Bahamas", "Barbados",
      "Belize", "Canada", "Costa Rica", "Cuba",
      "Dominica", "Dominican Republic", "El Salvador",
      "Grenada", "Guatemala", "Haiti", "Honduras",
      "Jamaica", "Mexico", "Nicaragua", "Panama",
      "Saint Kitts and Nevis", "Saint Lucia",
      "Saint Vincent and the Grenadines",
      "Trinidad and Tobago", "United States",
     ];
  }
  
  private static function SouthAmerica() : array {
    return [
      "Argentina", "Bolivia", "Brazil",
      "Chile", "Colombia", "Ecuador",
      "Guyana", "Paraguay", "Peru",
      "Suriname", "Uruguay","Venezuela"
      ];
  }
  private static function Oceania() : array{
    return [
      "Australia", "Fiji", "Kiribati",
      "Marshall Islands", "Micronesia",
      "Nauru", "New Zealand", "Palau", "Papua New Guinea", "Samoa", "Solomon Islands",
      "Tonga", "Tuvalu", "Vanuatu"
    ];
  }
  
}