<?php

namespace App;

use App\Controllers\AuthController;
use App\Controllers\FileController;
use App\DB;
use App\Interfaces\Router as RouterInterface;
use App\Controllers\Index;
use App\Middleware\FileUpload;
use App\Middleware\Test1;
use App\Middleware\ValidateAuthentification;
use App\Routing\Request;
use App\Middleware\Test;
use DI\Container;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\Tests\Models\DirectoryTree\File;
use Dotenv\Dotenv;

class App
{
    private RouterInterface $router;
    private static Container $container;
    public static Config $config;
    public static DB $db;
    public static EntityManager $entityManager;

    public function __construct(RouterInterface $router)
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__ . '../'));
        $dotenv->load();

        static::$config = new Config($_ENV);
        static::$db = new DB(self::$config->database);
        static::$entityManager = EntityManager::create(
            self::$config->database,
            ORMSetup::createAttributeMetadataConfiguration([__DIR__ . '/Entities'])
        );

        $this->router = $router;
    }

    private function registerRoutes(): void
    {
        $this->router
            ->get(
                '/',
                [Index::class, 'index'],
                [new ValidateAuthentification()]
            )
            ->get(
                '/login',
                [AuthController::class, 'index']
            )
            ->get(
                '/file',
                [FileController::class, 'index'],
                [new ValidateAuthentification()]
            );

        // Post Routes
        $this->router
            ->post(
                '/auth',
                [AuthController::class, 'auth']
            )
            ->post(
                '/upload',
                [FileController::class, 'upload'],
                [new ValidateAuthentification(), new FileUpload()]
            );
    }

    public function getRequest(): Request
    {
        return new Request(uniqid());
    }

    public function run()
    {
        $request = $this->getRequest();
        $this->registerRoutes();

        $output = $this->router->resolve($request);
        echo $output;
    }
}