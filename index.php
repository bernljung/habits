<?php

session_start();
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
require 'models/User.php';
$user = new User();

/***********
 App Initiation
************/
$app = new \Slim\Slim(array(
    'debug' => true,
    'mode' => 'development',
    'templates.path' => './templates',
    ));

$app->user = new User();


/***********
 Home View
************/
$app->get('/',
    function () use ($app) {
        if ($app->user->isLoggedIn()){
            $app->render('home.php',
                        array('userHabits' => $app->user->getHabitsByUserId(
                                            $app->user->getLoggedInUserId())));
        }else{
            $app->redirect($app->urlFor('login'));
        }
})->name('home');


/***********
 Habit Form
************/
$app->get('/habits/new',
    function () use ($app) {
    $app->render('newhabit.php');
})->name('newhabit');


/***********
 Habit View
************/
$app->get('/habits/:habitId', function ($habitId) use ($app) {
    if ($app->user->isLoggedIn()){
        $habit = $app->user->getUserHabitByHabitId($habitId);
        $app->render('habit.php', array('habit' => $habit));
    }else{
        $app->redirect($app->urlFor('login'));
    }
})->name('habitview');


/***********
 Login View
************/
$app->get('/login',
    function () use ($app) {
        $app->render('login.php');
})->name('login');


/***********
 Do login
************/
$app->post(
    '/doLogin',
    function () use ($app) {
        if (isset($_POST['user_email'])){
            $app->user->login($_POST['user_email']);
            $app->redirect($app->urlFor('home'));
        }
        $app->redirect($app->urlFor('login'));
    }
)->name('doLogin');


/***********
 Create new habit
************/
$app->post(
    '/habits/doNew',
    function () use ($app) {
        if (isset($_POST['habitname']) && $app->user->isLoggedIn()){
            $newHabitId = $app->user->createUserHabit($_POST['habitname']);
            $app->redirect($app->urlFor('habitview',
                                        array('habitId' => $newHabitId)));
        }
    }
)->name('doNewHabit');


/***********
 Change day status
************/
$app->post(
    '/doChangeDayStatus',
    function () use ($app) {
        if (isset($_POST['day_id'])){
            print_r($_POST);
            echo $app->user->changeUserHabitDayStatus($_POST['day_id']);
        }
    }
)->name('doChangeDayStatus');


/***********
 Logout
************/
$app->get('/logout',
    function () use ($app) {
        if ($app->user->isLoggedIn()){
            $app->user->logout();
        }
        $app->redirect($app->urlFor('home'));
})->name('logout');


/***********
 Slim Welcome View
************/
$app->get('/welcome',
    function () use ($app) {
    $app->render('welcome.php');
})->name('welcome');

$app->run();
