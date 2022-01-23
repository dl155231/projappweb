<tr id="nav">
  <?php
  $currentPage = $_GET['page'];
  $query = "SELECT * FROM page_list ORDER BY id ASC LIMIT 10";
  $result = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_array($result)) {
    if (($row['status'] == 1)) {
      $active = $currentPage === $row['page_title'] ? 'active' : '';
      $title = $row['page_title'];
      $el = "<li class='nav-item'>
            <a class='nav-link {$active}' href='?page={$title}'>$title</a>
          </li>";
      echo $el;
    }
  }
  ?>
</tr>