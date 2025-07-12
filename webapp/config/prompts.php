<?php

return [

    // TODO: move the prompts to a table with a 'name', 'prompt_data' fields and store them in json format
    // TODO: create a PiecePrompt DTO with the structure below.

    'idea' => [

        'text' => env(
            'PROMPTS_IDEA_TEXT',
            <<<text
Think like a professional author, brainstorm, and generate a <<WORDS>> words story idea<<TITLE>>for a <<TYPE>> with the following appeal terms:

GENRE: <<GENRE>><<SUB_GENRE>>
SETTING: <<SETTING>>
TIME PERIOD: <<TIMELINE>>
STORY LINE: <<STORYLINE>>
PACE: <<PACE>>
CHARACTER: <<CHARACTER>>
STORY TONE: <<TONE>>
WRITING STYLE: <<STYLE>>
THEME: <<THEME>>

Also, give me no less that three but no more that eight Tags that reflect the essence of the idea. Avoid telling the story, just give me the idea,
and please respond with the content only; do not add any extra instructions, options or comments.

Return the data in JSON format using the following structure:
{ "content": "[IDEA HERE]"<<TITLE_TEMPLATE>>, "tags": ["tag1", "tag2",...] }
text
        ),

        'title' => env(
            'PROMPTS_IDEA_TITLE',
            ', with a title, '
        ),

        'title_template' => env(
            'PROMPTS_IDEA_TITLE_TEMPLATE',
            ', "title": "[TITLE HERE]" '
        ),

        'words_limit' => (int) env('PROMPTS_IDEA_WORDS_LIMIT', 200),
    ],

];
