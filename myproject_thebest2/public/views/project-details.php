<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/project-details.css">

    <script src="https://kit.fontawesome.com/723297a893.js" crossorigin="anonymous"></script>
    <title>PROJECT DETAILS</title>
</head>

<body>
<div class="base-container">
<!--    <nav>-->
<!--        <img src="public/img/logo2.svg">-->
<!--        <ul>-->
<!--            <li>-->
<!--                <i class="fas fa-project-diagram"></i>-->
<!--                <a href="projects" class="button">projects</a>-->
<!--            </li>-->
<!--        </ul>-->
<!--    </nav>-->
    <main>
        <section class="project-details">
            <img src="public/uploads/<?= $project->getImage(); ?>">
            <div>
                <h2><?= $project->getTitle(); ?></h2>
                <p><?= $project->getDescription(); ?></p>
            </div>
        </section>
    </main>
</div>
</body>
