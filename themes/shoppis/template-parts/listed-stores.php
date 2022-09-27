<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listed Stores</title>
</head>
<body>

<div class="listed-stores">
    <?php the_title(); ?>
    <?php the_field('store_phone_number', get_the_id()); ?>
    <?php the_field('store_address', get_the_id()); ?>
    <?php the_field('store_opening_hours', get_the_id()); ?>
</div>
    
</body>
</html>