<?php

return [

    'pieces' => [

        'base' => env(
            'PROMPTS_PIECES_BASE',
            'Please generate a %s of %d words max '
        ),

        'title' => env(
            'PROMPTS_PIECES_TITLE',
            'and give it a title '
        ),

        'type' => env(
            'PROMPTS_PIECES_TYPE',
            'for a %s '
        ),

        'genre' => env(
            'PROMPTS_PIECES_GENRE',
            'in the "%s" genre, described as "%s" '
        ),

        'sub_genre' => env(
            'PROMPTS_PIECES_SUB_GENRE',
            'and the "%s" sub-genre described as "%s" '
        ),

        'tone' => env(
            'PROMPTS_PIECES_TONE',
            'using a "%s" tone described as "%s" '
        ),

        'theme' => env(
            'PROMPTS_PIECES_THEME',
            'with a "%s" theme described as "%s" '
        ),

        'settings' => [

            'time_period' => env('PROMPTS_PIECES_SETTINGS_TIME_PERIOD', 'set in the %s time period '),

            'location' => env('PROMPTS_PIECES_SETTINGS_LOCATION', 'set in the %s location '),

        ],

        'endings' => [

            'base' => env(
                'PROMPTS_PIECES_ENDINGS',
                'Please respond with the content only; do not add any extra options or comments. '
                . "\n Return the data in JSON format using the following structure: "
                . ' { "content": "[CONTENT HERE]"%s } '
            ),

            'title_template' => env(
                'PROMPTS_PIECES_ENDINGS_TITLE_TEMPLATE',
                ', "title": "[TITLE HERE]" '
            ),

        ],

        'limits' => [

            'words' => [
                'synopsis' => (int) env('PROMPTS_PIECES_LIMITS_WORDS_SYNOPSIS', 200),
            ],

        ],
    ],

];
