<?php

session_start();

require_once '/app/Utils/utils.php';
require_once '/app/Requests/articles.php';
checkAdmin();

// Vérification si le formulaire est soumis et  rempli
if (
    !empty($_POST['title'])
    && !empty($_POST['description'])
) {
    // Nettoyer les données
    $title = strip_tags($_POST['title']);
    $description = strip_tags($_POST['description']);

    // Créer une variable pour stocker l'article créé
    $titleExist = findOneArticleByTitle($title);
    var_dump($titleExist);
    // Verifier si le titre existe déja
    if (!$titleExist) {
        if (createArticle($title, $description)) {
            $_SESSION['messages']['success'] = "Votre article a bien été créé";

            // Redirection vers la page article
            // header('Location: /articles.php');
            exit(302);
        } else {
            $errorMessage = "Une erreur est survenue lors de la création de l'article";
        }
    } else {
        $errorMessage = "Cet article existe déja";
    }
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création articles | My first app PHP</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>

<body>
    <?php require_once '/app/public/Layout/_header.php'; ?>
    <main>
        <?php require_once '/app/public/Layout/_messages.php'; ?>
        <section class="container mt-4">
            <h1 class="title text-center">Création des articles</h1>
            <form action="/admin/articles/create.php" method="POST" class="card mt-4">
                <?php if (isset($errorMessage)): ?>
                    <div class="alert alert-danger">
                        <?= $errorMessage; ?>
                    </div>
                <?php endif; ?>
                <label for="title">Titre</label>
                <input type="text" name="title" id="title" required placeholder="Titre">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description" required placeholder="description">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </section>
    </main>
</body>

</html>