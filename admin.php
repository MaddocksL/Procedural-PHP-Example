<?php
  include_once 'templates/header.php';
?>
<section class="main-container">
  <div class="main-admin-wrapper">
<?php
  require 'includes/dbh.php';

  // Preview image code courtesy of http://talkerscode.com/webtricks/preview-image-before-upload-using-javascript.php
  ?>
  <script type="text/javascript">
    function preview_image(event) 
    {
      var reader = new FileReader();
      reader.onload = function()
    {
      var output = document.getElementById("output_image");
      output.src = reader.result;
    }
      reader.readAsDataURL(event.target.files[0]);
    }
  </script>
  <?php

  if (isset($_SESSION['s_id'])) {
    $action = 'null';
    if (isset($_GET['action'])) {
      $action = $_GET['action'];
    }

    $user = $_SESSION['s_user'];
    $query = "SELECT * FROM articles WHERE Author = '$user'";
    $result = mysqli_query($conn, $query)
    or die('Error querying the database');

    switch ($action) {
      case 'Add':
        ?>
          <form class="admin-form" action="includes/submitArticle.php" method="post" enctype="multipart/form-data">
            Title:<br>
            <input type="text" name="title" value="" /><br>
            Article Content:<br>
            <textarea name="article" cols="54" rows="8"></textarea><br><br>
            Image<br>
            <input type="file" name="image" accept="image/*" onchange="preview_image(event)"><br>
            <img id="output_image"/><br><br>
            <div>
            <h1>Categories</h1><br><br>
            <input type="checkbox" name="local" value="1" />Local News
            <input type="checkbox" name="sport" value="1" />Sports
            <input type="checkbox" name="education" value="1" />Education
            <input type="checkbox" name="event" value="1" />Events<br><br>
            </div>
            <input type="hidden" name="author" value="<?php echo $user; ?>" />
            <input type="submit" name="Submit" value="Submit" />
          </form>
        <?php
        break;
      
      case 'Edit':
        if (isset($_GET['id'])) {
          $id = $_GET['id'];
        }
        $query = "SELECT * FROM articles WHERE ID = '$id'";
        $result = mysqli_query($conn, $query)
          or die('Error querying the database');
        $row = mysqli_fetch_assoc($result);

        if ($user == $row["Author"]) {
          $local = $row["LocalNews"];
          $sport = $row["Sport"];
          $education = $row["Education"];
          $events = $row["Events"];
          echo '<pre>' .var_dump($local) . '</pre>';

          ?>
          <form class="admin-form" action="includes/submitArticle.php" method="post" enctype="multipart/form-data">
            Title:<br>
            <input type="text" name="title" value="<?php echo $row['Title']; ?>" /><br>
            Article Content:<br>
            <textarea name="article" cols="40" rows="5"><?php echo $row["Content"]; ?></textarea><br><br>
            Image<br>
            <input type="file" name="image" accept="image/*" onchange="preview_image(event)"><br>
            <img id="output_image"/><br><br>
            <div>
            Categories<br>
            <input type="checkbox" name="local" value="1" <?php echo ($local != 0 ? 'checked' : ''); ?> />Local News<br>
            <input type="checkbox" name="sport" value="1" <?php echo ($sport != 0 ? 'checked' : ''); ?> />Sports<br>
            <input type="checkbox" name="education" value="1" <?php echo ($education != 0 ? 'checked' : ''); ?> />Education<br>
            <input type="checkbox" name="event" value="1" <?php echo ($events != 0 ? 'checked' : ''); ?> />Events<br>
            <input type="hidden" name="id" value="<?php echo $row["ID"]; ?>" />
            <input type="submit" name="Update" value="Update" />
          </form>
          <?php
        } else {
          header("Location: admin.php");
        }
        break;

       case 'Delete':
        if (isset($_GET['id'])) {
          $id = $_GET['id'];
        }
        $query = "SELECT * FROM articles WHERE ID = '$id'";
        $result = mysqli_query($conn, $query)
          or die('Error querying the database');
        $row = mysqli_fetch_array($result);

          echo $user;
          echo var_dump($row["Author"]);
          // exit();
        if ($user == $row["Author"]) {
          $query = "DELETE FROM articles WHERE ID =".$id;
          $result = mysqli_query($conn, $query);
          header("Location: admin.php?remove=success");
        } else {
          header("Location: admin.php?remove=failed");
        }
        break;
      
      default:
        ?>
        <form class="admin-form" action="admin.php">
          <input type="submit" style="margin-bottom: 40px;" name="action" value="Add">
        </form>
        <?php

        if (mysqli_num_rows($result) == 0) {
          echo("No articles found");
        } else {
          echo('<h1 class="admin-table">Your articles</h1>');
          while($row = mysqli_fetch_array($result)) {
            ?>
            <a href='/cms/article.php?id="<?php echo $row["ID"];?>"'>
              <b class='admin-heading'><?php echo $row["Title"]." by ".$row["Author"]; ?></b>
            </a><br>
            <form class="admin-form" action="admin.php">
              <input type="submit" name="action" value="Edit" />
              <input type="hidden" name="id" value="<?php echo $row["ID"];?>" />
            </form>
            <form class="admin-form" action="admin.php">
              <input type="submit" name="action" value="Delete" onclick="return confirm(`Are you sure you want to delete?`); "/>
              <input type="hidden" name="id" value="<?php echo $row["ID"];?>" />
            </form><br><br>
            <?php
          }
        }
        break;
    }    
  } else {
    header("Location: index.php?login=nologin");
    exit();
}
?>
  </div>
</section>

<?php
  include_once 'templates/footer.php';
?>