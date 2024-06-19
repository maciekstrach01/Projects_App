<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/projects.css">
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <script src="https://kit.fontawesome.com/994c628b23.js" crossorigin="anonymous"></script>
    <title>PROJECTS</title>
</head>
<body>
    <div class="base-container">
      <nav>
        <img src="public/img/logo2.svg">
        <ul>
            <li>
                <i class="fa-solid fa-diagram-project"></i>
                <a href="#" class="button">projects</a>
            </li>

            <li>
                <i class="fa-solid fa-users"></i>
                <a href="#" class="button">users</a>
            </li>

            <li>
                <i class="fa-solid fa-message"></i>
                <a href="#" class="button">messages</a>
            </li>

            <li>
                <i class="fa-solid fa-envelope"></i>
                <a href="#" class="button">notification</a>
            </li>

            <li>
                <i class="fa-solid fa-gears"></i>
                <a href="#" class="button">settings</a>
            </li>
        </ul>
      </nav>
      <main>
        <header>
            <div class="search-bar">
                <form>
                    <input placeholder="search project">
                </form>
            </div>
           
            <div class="add-project">
                <i class="fa-solid fa-plus"></i>
              add project
            </div>
        
        </header>
        <section class="project-form">
           <h1>UPLOAD</h1>
           <form action="addProject" method="POST" ENCTYPE="multipart/form-data">
           <?php if(isset($messages)) {
                        foreach($messages as $message) {
                            echo $message;
                        }                  
                    }
                    ?>
            <input type="text" name="title" placeholder="title">
            <textarea name="description" rows="5" placeholder="description"></textarea>

            <input type="file" name="file">
            <button type="submit">send</button>
           </form>
        </section>
      </main>
    </div>
</body>