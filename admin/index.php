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
            <h1><strong>Liste des items </strong><a href="" class="btn btn-success btn-lg"><i class="fa-solid fa-plus"></i>
 Ajouter </a></h1>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Catégorie</th>  
                        <th>Actions</th>                     
                    </tr>
                </thead>
                <tbody>
                <?php 
                require 'database.php';
                $db = Database::connect();
                $statement = $db->query('SELECT items.id, items.name, items.description, items.price, categories.name AS category
                FROM items LEFT JOIN categories on items.category = categories.id
                ORDER BY items.id DESC');
                while($item = $statement->fetch()){
                echo '<tr>';
                    echo '<td>'.$item['name'].'</td>';
                    echo '<td>'.$item['description'].'</td>';
                    echo '<td>'.number_format((float)$item['price'], 2, '.', '').' €'.'</td>';
                    echo '<td>'.$item['category'].'</td>';
                    echo '<td width=300>';
                        echo '<a href="view.php?id='.$item['id'].'" class="btn btn-secondary"><i class="fa-solid fa-eye"></i> Voir</a>';
                        echo '<a href="update.php?id='.$item['id'].'" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i> Modifier</a>';
                        echo '<a href="delete.php?id='.$item['id'].'" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Supprimer</a>';
                    echo '</td>';
                echo '</tr>';
                }
                Database::disconnect();
                ?>

                </tbody>
            </table>
        </div>
    </div>
</body>
</html>