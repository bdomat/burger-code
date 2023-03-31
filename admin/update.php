<?php
require 'database.php';
if (!empty($_GET['id'])) {
    $id = checkInput($_GET['id']);
}
//variables init
$nameError = $descriptionError = $priceError = $categoryError = $imageError = $name = $description = $price = $category = $image = "";

if (!empty($_POST)) {
    $name = checkInput($_POST['name']);
    $description = checkInput($_POST['description']);
    $price = checkInput($_POST['price']);
    $category = checkInput($_POST['category']);
    $image = checkInput($_FILE['image']['name']);
    $imagePath = '../img/' . basename($image);
    $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
    $isSuccess = true;

    if (empty($name)) {
        $nameError = "Ce champs ne peut pas être vide";
        $isSuccess = false;
    }
    if (empty($description)) {
        $descriptionError = "Ce champs ne peut pas être vide";
        $isSuccess = false;
    }
    if (empty($price)) {
        $priceError = "Ce champs ne peut pas être vide";
        $isSuccess = false;
    }
    if (empty($category)) {
        $categoryError = "Ce champs ne peut pas être vide";
        $isSuccess = false;
    }
    if (empty($image)) {
        $imageUpdated = false;
    } else {
        $imageUpdated = true;
        $isUploadSuccess = true;
        if ($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif") {
            $imageError = "Les fichiers autorisés sont : jpg, jpeg, png, gif";
            $isUploadSuccess = false;
        }
        if (file_exists($imagePath)) {
            $imageError = "Lefichier existe déja";
            $isUploadSuccess = false;
        }
        if ($_FILES["image"]["size"] > 500000) {
            $imageError = "Le fichier ne doit pas dépasser les 500KB";
            $isUploadSuccess = false;
        }
        if ($isUploadSuccess) {
            if (!move_upload_file($_FILES["image"]["tmp_name"], $imagePath)) {
                $imageError = "Il y a eu une erreur lors de l'upload";
                $isUploadSuccess = false;
            }
        }
    }
    if (($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated)) {
        $db = Database::connect();
        if ($isImageUpdated) {
            $statement = $db->prepare("UPDATE items set name = ?, description = ?, price = ?, category = ?, image = ?, WHERE id= ?");
            $statement->execute(array($name, $description, $price, $category, $image, $id));
        } else {
            $statement = $db->prepare("UPDATE items set name = ?, description = ?, price = ?, category = ?,  WHERE id= ?");
            $statement->execute(array($name, $description, $price, $category, $image, $id));
        }
        Database::disconnect();
        header("Location: index.php");
    } else if (isImageUpdated && !isUploadSuccess) {
        $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM items where id = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $image          = $item['image'];
        Database::disconnect();
    }
} else {
    $db = Database::connect();
    $statement = $db->prepare("SELECT * FROM items WHERE id = ?");
    $statement->execute(array($id));
    $item = $statement->fetch();
    $name           = $item['name'];
    $description    = $item['description'];
    $price          = $item['price'];
    $category       = $item['category'];
    $image          = $item['image'];
    $id = $item['id'];
    Database::disconnect();
}
function checkInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BurgerCode</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Holtwood+One+SC&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <h1 class="text-logo"><i class="fa-solid fa-utensils"></i> Burger Code <i class="fa-solid fa-utensils"></i></h1>
    <div class="container admin">
        <div class="row">
            <div class="col-sm-6">
                <h1><strong>Modifier un item </strong></h1>
                <br>
                <form class="form" action="<?php echo 'update.php?id=' . $id; ?>" method="post.php" enctype="multipart/form-data">
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
                            foreach ($db->query('SELECT * FROM categories') as $row) {
                                if ($row['id'] == $category)
                                    echo '<option selected="selected" value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                else
                                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                            }
                            Database::disconnect();
                            ?>
                        </select>
                        <span class="help-inline"><?php echo $categoryError; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="image">Image :</label>
                        <p><?php echo $image ?>
                            <input type="file" name="image" id="image">
                            <span class="help-inline"><?php echo $imageError; ?></span>
                    </div>

                    <div class="fom-action">
                        <button type="submit" class="btn btn-success"><i class="fa-solid fa-circle-plus"></i> Modifier</button>
                        <a href="index.php" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i> Retour</a>
                    </div>
                </form>

            </div>
            <div class="col-md-6">
                <div class="card site">
                    <img src="<?php echo '../img/' . $image; ?>" alt="...">
                    <div class="price"><?php echo number_format((float)$price, 2, '.', '') . ' €'; ?></div>
                    <div class="card-body">
                        <h4><?php echo $name; ?></h4>
                        <p><?php echo $description; ?></p>
                        <a href="#" class="btn btn-primary" role="button"><i class="fa-solid fa-cart-plus"></i> Commander</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>