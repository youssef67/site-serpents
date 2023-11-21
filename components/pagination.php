<?php
echo '<div class="row justify-content-md-center mt-3">
    <div class="col col-lg-2">
    </div>
    <nav class="col-md-auto">
        <ul class="pagination">
            <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
            <li class="page-item ' . ($_SESSION["currentPage"] == 1 ? 'disabled' : '') . '">
                <a onclick="ajaxPagination(' . ($_SESSION["currentPage"] - 1) . ')" class="page-link">Précédente</a>
            </li>';

for ($page = 1; $page <= $pages; $page++) {
    // Lien vers chacune des pages (activé si on se trouve sur la page correspondante)
    echo '<li class="page-item ' . ($_SESSION["currentPage"] == $page ? 'active' : '') . '">
        <a onclick="ajaxPagination(' . $page . ')" class="page-link">' . $page . '</a>
    </li>';
}

echo '<li class="page-item ' . ($_SESSION["currentPage"] == $pages ? 'disabled' : '') . '">
        <a onclick="ajaxPagination(' . ($_SESSION["currentPage"] + 1) . ')" class="page-link">Suivante</a>
    </li>
</ul>
</nav>
<div class="col col-lg-2">
</div>
</div>';
?>





