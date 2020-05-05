<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",

    // Here comes the menu items
    "items" => [
        [
            "text" => "Hem",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],
        [
            "text" => "Redovisning",
            "url" => "redovisning",
            "title" => "Redovisningstexter från kursmomenten.",
            "submenu" => [
                "items" => [
                    [
                        "text" => "Kmom01",
                        "url" => "redovisning/kmom01",
                        "title" => "Redovisning för kmom01.",
                    ],
                    [
                        "text" => "Kmom02",
                        "url" => "redovisning/kmom02",
                        "title" => "Redovisning för kmom02.",
                    ],
                    [
                        "text" => "Kmom03",
                        "url" => "redovisning/kmom03",
                        "title" => "Redovisning för kmom03.",
                    ],
                    [
                        "text" => "Kmom04",
                        "url" => "redovisning/kmom04",
                        "title" => "Redovisning för kmom04.",
                    ],
                ],
            ],
        ],
        [
            "text" => "Om",
            "url" => "om",
            "title" => "Om denna webbplats.",
        ],
        // [
        //     "text" => "Styleväljare",
        //     "url" => "style",
        //     "title" => "Välj stylesheet.",
        // ],
        [
            "text" => "Docs",
            "url" => "dokumentation",
            "title" => "Dokumentation av ramverk och liknande.",
        ],
        // [
        //     "text" => "Test &amp; Lek",
        //     "url" => "lek",
        //     "title" => "Testa och lek med test- och exempelprogram",
        // ],
        [
            "text" => "Gissa numret",
            "url" => "guess-game",
            "title" => "Spela gissningsspel",
        ],
        [
            "text" => "100",
            "url" => "dice1",
            "title" => "Spela tärningsspel",
        ],
        [
            "text" => "Movie",
            "url" => "movie",
            "title" => "Visa Filmer",
        ],
        [
            "text" => "Anax dev",
            "url" => "dev",
            "title" => "Anax development utilities",
        ],
    ],
];
