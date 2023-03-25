<?php 
require 'database.php';

$nameError = $descriptionError = $priceError = $categoryError = $imageError = $name = $description = $price = $category = $image = "";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BurgerCode</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Holtwood+One+SC&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1 class="text-logo"><i class="fa-solid fa-utensils"></i> Burger Code <i class="fa-solid fa-utensils"></i></h1>
    <div class="container admin">
        <div class="row">
           <div class="row">
                <h1><strong>Voir un item </strong></h1>
                <br>
                <form class="form" action="insert.php" method="post.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Nom:</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nom" value="<?php echo $name; ?>">
                        <span class="help-inline"><?php echo $nameError; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <input type="text" name="description" id="description" class="form-control" placeholder="Description" value="<?php echo $description; ?>">
                        <span class="help-inline"><?php echo $descriptionError; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="price">Prix: (en €)</label>
                        <input type="number" step="0.01" name="price" id="price" class="form-control" placeholder="Prix" value="<?php echo $price; ?>">
                        <span class="help-inline"><?php echo $priceError; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="category">Catégorie</label>
                        <select name="category" id="category" class="form-control">
                            <?php 
                            $db = Database::connect();
                            foreach($db->query('SELECT * FROM categories') as $row){
                                echo '<option value="'. $row['id']. '">' . $row['name'].'</option>';
                            }
                            Database::disconnect();
                            ?>
                        </select>
                        <span class="help-inline"><?php echo $categoryError; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="image">Sélectionner une imaage :</label>
                        <input type="file" name="image" id="image" >
                        <span class="help-inline"><?php echo $imageError; ?></span>
                    </div>
                </form>
                <div class="fom-action">
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-circle-plus"></i> Ajouter</button>
                    <a href="index.php" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i> Retour</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>