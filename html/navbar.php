<tr id="nav">
  <?php
  $urls = array(
    'Strona główna' => '?page=',
    'Historia' => '?page=history',
    'Ciekawostki' => '?page=facts',
    'Galeria' => '?page=gallery',
    'Kontakt' => '?page=contact',

  );

  foreach ($urls as $name => $url) {
    print '<td ' . (($currentPage === $name) ? ' class="active" ' : '') .
      '><a href="' . $url . '">' . $name . '</a></td>';
  }
  ?>
</tr>