<?php

namespace spoova\mi\core\classes\Fabricator;

class FabricateAddress implements FabricatorInterface {

  /**
   * Generates a realistic random address based on country
   *
   * @param $country Optional country parameter to specify the country for the address
   * @return string
   */
  public static function fabricate(?string $country = null) : string {

    $locations = self::locations();

    // Pick a random country
    $country = $country ?? array_rand($locations);
    $data    = $locations[$country];

    $state  = $data['states'][array_rand($data['states'])];
    $city   = $state['cities'][array_rand($state['cities'])];
    $street = $data['streets'][array_rand($data['streets'])];

    $streetNo = rand(1, 999);

    return "{$streetNo} {$street}, {$city}, {$state['name']}, {$country}";
  }

  /**
   * Global address data
   */
  private static function locations() : array {
    return [

      "Nigeria" => [
        "streets" => [
          "Adeola Odeku Street", "Ahmadu Bello Way", "Awolowo Road",
          "Herbert Macaulay Way", "Lekki–Epe Expressway"
        ],
      ],

      "United States" => [
        "streets" => [
          "Wall Street", "Hollywood Boulevard", "Fifth Avenue",
          "Sunset Boulevard", "Broadway"
        ],
        "states" => [
          [
            "name"   => "California",
            "cities" => ["Los Angeles", "San Francisco", "San Diego"]
          ],
          [
            "name"   => "New York",
            "cities" => ["New York City", "Buffalo", "Rochester"]
          ]
        ]
      ],

      "United Kingdom" => [
        "streets" => [
          "Baker Street", "Oxford Street", "Downing Street",
          "Abbey Road", "Piccadilly Circus"
        ],
        "states" => [
          [
            "name"   => "England",
            "cities" => ["London", "Manchester", "Liverpool", "Birmingham"]
          ],
          [
            "name"   => "Scotland",
            "cities" => ["Edinburgh", "Glasgow"]
          ]
        ]
      ],

      "France" => [
        "streets" => [
          "Champs-Élysées", "Rue de Rivoli", "Boulevard Saint-Germain"
        ],
        "states" => [
          [
            "name"   => "Île-de-France",
            "cities" => ["Paris", "Versailles"]
          ],
          [
            "name"   => "Provence-Alpes-Côte d’Azur",
            "cities" => ["Marseille", "Nice"]
          ]
        ]
      ],

      "Japan" => [
        "streets" => [
          "Shibuya Crossing", "Ginza Street", "Takeshita Street"
        ],
        "states" => [
          [
            "name"   => "Tokyo",
            "cities" => ["Shibuya", "Shinjuku", "Akihabara"]
          ],
          [
            "name"   => "Osaka",
            "cities" => ["Namba", "Umeda"]
          ]
        ]
      ],
      "Morocco" => [
        "streets" => [
            "Avenue Mohammed V", "Boulevard Zerktouni",
            "Rue de la Liberté", "Hassan II Boulevard"
        ],
        "states" => [
            [
            "name"   => "Casablanca-Settat",
            "cities" => ["Casablanca", "Mohammedia"]
            ],
            [
            "name"   => "Rabat-Salé-Kénitra",
            "cities" => ["Rabat", "Salé", "Kénitra"]
            ],
            [
            "name"   => "Marrakesh-Safi",
            "cities" => ["Marrakesh", "Safi"]
            ]
        ]
      ],

      "Ghana" => [
        "streets" => [
            "Oxford Street", "Ring Road", "Independence Avenue",
            "Spintex Road", "Liberation Road"
        ],
        "states" => [
            [
            "name"   => "Greater Accra",
            "cities" => ["Accra", "Tema", "Madina"]
            ],
            [
            "name"   => "Ashanti",
            "cities" => ["Kumasi", "Obuasi"]
            ],
            [
            "name"   => "Central",
            "cities" => ["Cape Coast", "Winneba"]
            ]
        ]
      ],

      "Tanzania" => [
        "streets" => [
            "Samora Avenue", "Nyerere Road",
            "Ohio Street", "Bagamoyo Road"
        ],
        "states" => [
            [
            "name"   => "Dar es Salaam",
            "cities" => ["Ilala", "Kinondoni", "Temeke"]
            ],
            [
            "name"   => "Arusha",
            "cities" => ["Arusha City", "Moshi"]
            ],
            [
            "name"   => "Dodoma",
            "cities" => ["Dodoma City"]
            ]
        ]
      ],

      "China" => [
        "streets" => [
            "Nanjing Road", "Wangfujing Street",
            "Chang'an Avenue", "Huaihai Road"
        ],
        "states" => [
            [
            "name"   => "Beijing",
            "cities" => ["Chaoyang", "Haidian", "Dongcheng"]
            ],
            [
            "name"   => "Shanghai",
            "cities" => ["Pudong", "Huangpu", "Xuhui"]
            ],
            [
            "name"   => "Guangdong",
            "cities" => ["Guangzhou", "Shenzhen", "Foshan"]
            ]
        ]
      ],

      "India" => [
        "streets" => [
            "MG Road", "Connaught Place",
            "Brigade Road", "Linking Road"
        ],
        "states" => [
            [
            "name"   => "Maharashtra",
            "cities" => ["Mumbai", "Pune", "Nagpur"]
            ],
            [
            "name"   => "Delhi",
            "cities" => ["New Delhi", "Dwarka", "Rohini"]
            ],
            [
            "name"   => "Karnataka",
            "cities" => ["Bangalore", "Mysore"]
            ]
        ]
      ],

      "Russia" => [
        "streets" => [
            "Tverskaya Street", "Nevsky Prospect",
            "Arbat Street", "Kutuzovsky Avenue"
        ],
        "states" => [
            [
            "name"   => "Moscow Oblast",
            "cities" => ["Moscow", "Khimki", "Podolsk"]
            ],
            [
            "name"   => "Saint Petersburg",
            "cities" => ["Saint Petersburg", "Pushkin"]
            ],
            [
            "name"   => "Krasnodar Krai",
            "cities" => ["Krasnodar", "Sochi"]
            ]
        ]
      ],
      "Australia" => [
        "streets" => [
            "King Street", "George Street", "Queen Street",
            "Oxford Street", "Bourke Street"
        ],
        "states" => [
            [
            "name"   => "New South Wales",
            "cities" => ["Sydney", "Wollongong"]
            ],
            [
            "name"   => "Victoria",
            "cities" => ["Melbourne", "Geelong"]
            ],
            [
            "name"   => "Queensland",
            "cities" => ["Brisbane", "Gold Coast"]
            ]
        ]
      ]
    ];

  }
  
}