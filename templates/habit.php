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
                    <h1 class="margin-base-vertical"><?php echo $habit->getHabitName(); ?></h1>
                    <p>
                        Click on an item to change its status.
                    </p>
                    <p>
                        Back to <a href="/">your habits</a>.
                    </p>
                    <div class="habit-days-container text-center">
                    <?php foreach ($habit->getHabitDays() as $habitDay) { ?>
                        <div class="habit-day text-center <?php switch($habitDay->getStatusId()){ case 2: echo "successful"; break; case 3: echo "unsuccessful"; break; } ?>">
                            <div class="ajax-loader"></div>
                            <input type="hidden" class="id" value="<?php echo $habitDay->getDayId(); ?>" />
                            <?php echo $habitDay->getDayNumber(); ?>
                        </div>
                    <?php } ?>
                    <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
    <script src="/media/js/habit.js" type="text/javascript"></script>
    </body>
</html>
