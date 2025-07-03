<?php

use Prism\Prism\Enums\Provider;

return [

    'services' => [

        'openai' => [
            'provider' => Provider::OpenAI,
            'enabled' => (bool) env('OPENAI_ENABLED', false),
            'models' => [env('OPENAI_MODEL', 'gpt-4o-mini-2024-07-18')],
            'max_tokens' => (int) env('OPENAI_MAX_TOKENS', 768),
            'presence_penalty' => (float) env('OPENAI_PRESENCE_PENALTY', 0.3),
            'request_timeout' => (int) env('OPENAI_REQUEST_TIMEOUT', 30),
            'temperature' => (float) env('OPENAI_TEMPERATURE', 0.8),
        ],

        'anthropic' => [
            'provider' => Provider::Anthropic,
            'enabled' => (bool) env('ANTHROPIC_ENABLED', false),
            'models' => [env('ANTHROPIC_MODEL', '')],
            'max_tokens' => (int) env('ANTHROPIC_MAX_TOKENS', 768),
            'presence_penalty' => (float) env('ANTHROPIC_PRESENCE_PENALTY', 0.3),
            'request_timeout' => (int) env('ANTHROPIC_REQUEST_TIMEOUT', 30),
            'temperature' => (float) env('ANTHROPIC_TEMPERATURE', 0.8),
        ],

        'ollama' => [
            'provider' => Provider::Ollama,
            'enabled' => (bool) env('OLLAMA_ENABLED', false),
            'models' => explode(',', (string) env('OLLAMA_MODELS', '')),
            'max_tokens' => (int) env('OLLAMA_MAX_TOKENS', 768),
            'presence_penalty' => (float) env('OLLAMA_PRESENCE_PENALTY', 0.4),
            'request_timeout' => (int) env('OLLAMA_REQUEST_TIMEOUT', 30),
            'temperature' => (float) env('OLLAMA_TEMPERATURE', 0.8),
        ],

        'open-router' => [
            'provider' => Provider::Mistral,
            'enabled' => (bool) env('OPEN_ROUTER_ENABLED', false),
            'models' => explode(',', (string) env('OPEN_ROUTER_MODELS', '')),
            'max_tokens' => (int) env('OPEN_ROUTER_MAX_TOKENS', 768),
            'presence_penalty' => (float) env('OPEN_ROUTER_PRESENCE_PENALTY', 0.4),
            'request_timeout' => (int) env('OPEN_ROUTER_REQUEST_TIMEOUT', 30),
            'temperature' => (float) env('OPEN_ROUTER_TEMPERATURE', 0.8),
        ],

    ],

];
