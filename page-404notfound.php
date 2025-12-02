<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>404 Page Not Found</title>

    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/404_notfound.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
  </head>
  <body class="page-notfound">
    <div class="page-404">
      <div class="overlay">
        <img src="<?php echo get_template_directory_uri(); ?>/images/gifphy.gif" alt="404 background" class="bg-gif" />

        <div class="content">
          <h1>404</h1>
          <p>Oops. The page you are looking<br />for can’t be found!</p>

          <form class="search-form" id="google-search-form">
            <input type="text" id="search-input" placeholder="Search..." />
            <button type="button" id="search-btn"><i class="fa fa-search"></i></button>
          </form>

          <a href="<?php echo home_url(); ?>" class="back-home-btn">Home</a>
        </div>
      </div>
    </div>
  </body>
</html>
