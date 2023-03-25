<?php 

require 'database.php';

if(!empty($_GET['id'])){
    $id = checkInput($_GET['id']);
}
$db = Database::connect();
$statement = $db -> prepare('SELECT items.id, items.name, items.description, items.price, items.image, categories.name AS category
FROM items LEFT JOIN categories on items.category = categories.id
WHERE items.id = ?');

$statement -> execute(array($id));
$item = $statement -> fetch();
Database::disconnect();

function checkInput($data){
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
            <div class="col-sm-6">
                <h1><strong>Voir un item </strong></h1>
                <br>
                <form action="">
                    <div class="form-group">
                        <label for="">Nom:</label><?php echo ' '.$item['name']?>
                    </div>
                    <div class="form-group">
                        <label for="">Description:</label><?php echo ' '.$item['description']?>
                    </div>
                    <div class="form-group">
                        <label for="">Prix:</label><?php echo ' '.number_format((float)$item['price'], 2, '.', '').' €';?>
                    </div>
                    <div class="form-group">
                        <label for="">Catégorie:</label><?php echo ' '.$item['category']?>
                    </div>
                    <div class="form-group">
                        <label for="">Image:</label><?php echo ' '.$item['image']?>
                    </div>
                </form>
                <div class="fom-action">
                    <a href="index.php" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i> Retour</a>
                </div>
            </div>
            <div class="col-sm-6 site">
            <div class="card">
                <img src="<?php echo  '../img/'. $item['image']?>" alt="">
                <div class="price"><?php echo number_format((float)$item['price'], 2, '.', '').' €';?></div>
                <div class="card-body">
                <h4><?php echo $item['name']?></h4>
                <p><?php echo $item['description']?></p>
                <a href="#" class="btn btn-primary" role="button"><i
                class="fa-solid fa-cart-plus"></i> Commander</a>
                </div>
              </div>
            </div>
           </div>
        </div>
    </div>
</body>
</html>