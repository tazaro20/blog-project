<?php
use App\Connection;
require dirname(__DIR__) .'/vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

$pdo = Connection::getPDO();

$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE post_category');
$pdo->exec('TRUNCATE TABLE category');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE user');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

$posts = [];
$categories = [];

for ($i = 0; $i < 50; $i++){
    $name = $faker->sentence();
    $slug = $faker->slug();
    $created_at = $faker->date() . ' ' . $faker->time();
    $content = $faker->paragraphs(rand(3, 15), true);
    $pdo->exec("INSERT INTO post (id, name, slug, created_at, content) VALUES ('', '$name', '$slug', '$created_at', '$content')");
    $posts[] = $pdo->lastInsertId();
}
for ($i = 0; $i < 5; $i++) {
    $name = $faker->sentence(3);
    $slug = $faker->slug();
    $pdo->exec("INSERT INTO category set name = '$name', slug= '$slug' ");
    $categories[] = $pdo->lastInsertId();
}

foreach ($posts as $post) {
    $randomCategories = $faker->randomElements($categories, rand(0, count($categories)));
    foreach ($randomCategories as $category) {
        $pdo->exec("INSERT INTO post_category set  post_id = '$post' , category_id = '$category'");
    }
}

$password = password_hash('admin',PASSWORD_BCRYPT);
$pdo -> exec("insert into user set username = 'admin',password ='$password'");
