<!DOCTYPE html>
<html>
    <head>
        <!-- https://github.com/bernljung/habits -->
        <title>Habits</title>
        <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
        <link href="/media/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="/media/css/style.css">
        <link href='http://fonts.googleapis.com/css?family=Abel|Open+Sans:400,600' rel='stylesheet'>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-md-offset-1 panel panel-default">
                    <p class="text-right logout">
                        <a href="/logout">Logout</a>
                    </p>
                    <?php if(count($userHabits) > 0){ ?>
                        <h1 class="margin-base-vertical">Your new habits:</h1>
                         <p>
                            Start a <a href="/habits/new">new habit</a>.
                        </p>
                        <?php foreach ($userHabits as $habit) { ?>
                        <h2> -> <a href="/habits/<?php echo $habit->getHabitId();?>"><?php echo $habit->getHabitName(); ?></a></h2>
                        <?php } ?>
                    <?php }else{ ?>
                    <h1>Start your new habit</h1>
                    <p>
                        Give your new habit a name and get started!
                    </p>

                    <form action="/habits/doNew" method="post">
                            <input type="text" class="form-control input-lg" name="habitname" placeholder="My new habit" required />
                        <p class="text-center">
                            <button type="submit" class="btn btn-success btn-lg">Get started!</button>
                        </p>
                    </form>
                    <?php } ?>



                </div>
            </div>
        </div>
    </body>
</html>
