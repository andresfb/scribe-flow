<?php

return [

    // TODO: move the prompts to a table with a 'name', 'prompt_data' fields and store them in json format
    // TODO: create a PiecePrompt DTO with the structure below.

    'pieces' => [

        'base' => env(
            'PROMPTS_PIECES_BASE',
            'Please generate a %d words story idea '
        ),

        'title' => env(
            'PROMPTS_PIECES_TITLE',
            'and give it a title '
        ),

        'type' => env(
            'PROMPTS_PIECES_TYPE',
            'for a "%s" '
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

            'time_period' => env('PROMPTS_PIECES_SETTINGS_TIME_PERIOD', 'set in the "%s" time period. '),

            'location' => env('PROMPTS_PIECES_SETTINGS_LOCATION', 'set in a "%s" location. '),

        ],

        'endings' => [

            'base' => env(
                'PROMPTS_PIECES_ENDINGS',
                'Avoid telling the story, just give me the idea. Please respond with'
                .' the content only; do not add any extra instructions, options or comments. '
                . "\n Return the data in JSON format using the following structure: "
                . ' { "content": "[IDEA HERE]"%s } '
            ),

            'title_template' => env(
                'PROMPTS_PIECES_ENDINGS_TITLE_TEMPLATE',
                ', "title": "[TITLE HERE]" '
            ),

        ],

        'limits' => [

            'words' => [
                'synopsis' => (int) env('PROMPTS_PIECES_LIMITS_WORDS_SYNOPSIS', 100),
            ],

        ],
    ],

];
