<?php

use PhpUnitGen\Core\Generators\Tests\DelegateTestGenerator;

return [
    /*
     |--------------------------------------------------------------------------
     | Automatic Generation.
     |
     | Tells if the generator should create tested class instantiation and
     | complex tests skeleton (getter/setter tests...).
     |--------------------------------------------------------------------------
     */
    'automaticGeneration' => true,

    /*
     |--------------------------------------------------------------------------
     | Contract implementations to use.
     |
     | Tells which implementation you want to use when PhpUnitGen requires a
     | specific contract.
     |--------------------------------------------------------------------------
     */
    'implementations'     => DelegateTestGenerator::implementations(),

    /*
     |--------------------------------------------------------------------------
     | Base Namespace of source code.
     |
     | This string will be removed from the test class namespace.
     |--------------------------------------------------------------------------
     */
    'baseNamespace'       => '',

    /*
     |--------------------------------------------------------------------------
     | Base Namespace of tests.
     |
     | This string will be prepend to the test class namespace.
     |--------------------------------------------------------------------------
     */
    'baseTestNamespace'   => 'Tests',

    /*
     |--------------------------------------------------------------------------
     | Test Case.
     |
     | The absolute class name to TestCase.
     |--------------------------------------------------------------------------
     */
    'testCase'            => 'PHPUnit\\Framework\\TestCase',

    /*
     |--------------------------------------------------------------------------
     | Excluded methods.
     |
     | Those methods will not have tests or skeleton generation. This must be an
     | array of RegExp compatible with "preg_match", but without the opening and
     | closing "/", as they will be added automatically.
     |--------------------------------------------------------------------------
     */
    'excludedMethods'     => [
        '__construct',
        '__destruct',
    ],

    /*
     |--------------------------------------------------------------------------
     | Merged PHP documentation tags.
     |
     | Those tags will be retrieved from tested class documentation, and appends
     | to the test class documentation.
     |--------------------------------------------------------------------------
     */
    'mergedPhpDoc'        => [
        'author',
        'copyright',
        'license',
        'version',
    ],

    /*
     |--------------------------------------------------------------------------
     | PHP documentation lines.
     |
     | Those complete documentation line (such as "@author John Doe") will be
     | added to the test class documentation.
     |--------------------------------------------------------------------------
     */
    'phpDoc'              => [],

    /*
     |--------------------------------------------------------------------------
     | Options.
     |
     | This property is for generator's specific configurations. It might
     | contains any other useful information for test generation.
     |--------------------------------------------------------------------------
     */
    'options'             => [
        /*
         |----------------------------------------------------------------------
         | Laravel Options.
         |
         | Those options are used by Laravel Test Generators and are nested in
         | a "laravel." namespace.
         |  - "user" is the class of User Eloquent model, since it will be used
         |    in many tests.
         |----------------------------------------------------------------------
         */
        // 'laravel.user' => 'App\\User',
    ],
];
