<?php

use App\Controllers\Admin\ArticlesController;
use App\Controllers\Admin\CategoriesController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\SettingsController;
use App\Controllers\Admin\TagsController;
use App\Controllers\Admin\UsersController;
use App\Controllers\ArticleController;
use App\Controllers\AuthController;
use App\Controllers\CategoryController;
use App\Controllers\FeedController;
use App\Controllers\HomeController;
use App\Controllers\SearchController;
use App\Controllers\SitemapController;
use App\Controllers\TagController;
use App\Core\Router;

require __DIR__ . '/../app/bootstrap.php';

$router = new Router();

$homeController = new HomeController();
$articleController = new ArticleController();
$categoryController = new CategoryController();
$tagController = new TagController();
$searchController = new SearchController();
$authController = new AuthController();
$feedController = new FeedController();
$sitemapController = new SitemapController();

$router->get('/', [$homeController, 'index']);
$router->get('/about', [$homeController, 'about']);
$router->get('/contact', [$homeController, 'contact']);
$router->post('/contact', [$homeController, 'contactSubmit']);
$router->get('/article/{slug}', [$articleController, 'show']);
$router->get('/categorie/{slug}', [$categoryController, 'show']);
$router->get('/tag/{slug}', [$tagController, 'show']);
$router->get('/search', [$searchController, 'index']);
$router->get('/rss.xml', [$feedController, 'rss']);
$router->get('/sitemap.xml', [$sitemapController, 'index']);

$router->get('/login', [$authController, 'loginForm']);
$router->post('/login', [$authController, 'login']);
$router->get('/logout', [$authController, 'logout']);

$dashboardController = new DashboardController();
$articlesController = new ArticlesController();
$categoriesController = new CategoriesController();
$tagsController = new TagsController();
$usersController = new UsersController();
$settingsController = new SettingsController();

$router->get('/admin', [$dashboardController, 'index']);
$router->get('/admin/articles', [$articlesController, 'index']);
$router->get('/admin/articles/create', [$articlesController, 'create']);
$router->post('/admin/articles', [$articlesController, 'store']);
$router->get('/admin/articles/{id}/edit', [$articlesController, 'edit']);
$router->post('/admin/articles/{id}/update', [$articlesController, 'update']);
$router->post('/admin/articles/{id}/delete', [$articlesController, 'delete']);

$router->get('/admin/categories', [$categoriesController, 'index']);
$router->post('/admin/categories', [$categoriesController, 'store']);
$router->post('/admin/categories/{id}/delete', [$categoriesController, 'delete']);

$router->get('/admin/tags', [$tagsController, 'index']);
$router->post('/admin/tags', [$tagsController, 'store']);
$router->post('/admin/tags/{id}/delete', [$tagsController, 'delete']);

$router->get('/admin/users', [$usersController, 'index']);
$router->post('/admin/users', [$usersController, 'store']);
$router->post('/admin/users/{id}/delete', [$usersController, 'delete']);

$router->get('/admin/settings', [$settingsController, 'index']);
$router->post('/admin/settings', [$settingsController, 'update']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
