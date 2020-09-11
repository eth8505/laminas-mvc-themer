<?php

    use LaminasMvcThemer\Resolver\ConfigResolver;
    use LaminasMvcThemer\Theme\DefaultTheme;

    return [
        'laminas-mvc-themer' => [
            'resolver' => ConfigResolver::class,
            'default-theme' => DefaultTheme::class
        ]
    ];
