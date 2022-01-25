<nav class="navbar navbar-expand-lg navbar-light bg-light mx-auto">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Kostka Rubika - moja pasja</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mb-2 mb-lg-0" id="navbarContent">
        <?php
        $currentPage = $_GET['page'];
        $query = "SELECT * FROM page_list ORDER BY id ASC LIMIT 10";
        $result = mysqli_query($dblink, $query);
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
        <li class="nav-item">
          <a class="nav-link" href="?page=Kontakt">Kontakt</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?page=Sklep">Sklep</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?page=Koszyk">Koszyk</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?page=cms">CMS</a>
        </li>
        <li class="nav-item">
          <span class="nav-link disabled" id="date"></span>
        </li>
        <li class="nav-item">
          <span class="nav-link disabled" id="clock"></span>
        </li>

      </ul>
    </div>
  </div>
</nav>