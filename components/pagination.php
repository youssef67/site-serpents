<script>
    window.onload = function() {
        miseAjourSerpentMort();
    }
</script>
<?php
$a = new \classes\Animal();

//Variables permettant de définir si on se trouve sur une page qui affiche les serpents morts ou les serpents vivants
//Si Serpents mort = true
//Si serpents vivant = false
$DieOrlive = $_SESSION["current_url"] === "vivarium" ? false : true;

//ON récupèrele nombre de pages après actualisation
if($DieOrlive) {
    $pages = ceil($a->selectCountAllDeadSnake() / 5);
} else {
    if (isset($_SESSION["nb_resultat_filtre"]))
        $pages = ceil($_SESSION["nb_resultat_filtre"] / 5);
    else
        $pages = ceil($a->selectCountAll() / 5);
}

echo "<div class='row justify-content-md-center mt-3'>
    <div class='col col-lg-2'></div>
    <nav class='col-md-auto'>
        <ul class='pagination'>";

// Lien vers la page précédente (désactivé si on se trouve sur la 1ère page)
echo "<li class='page-item " . ($_SESSION['currentPage'] == 1 ? 'disabled' : '') . "'>
            <a onclick='ajaxPagination(" . ($_SESSION['currentPage'] - 1), $DieOrlive .")' class='page-link'>Précédente</a>
        </li>";

// Lien vers chacune des pages (activé si on se trouve sur la page correspondante)
for ($page = 1; $page <= $pages; $page++) {
    if ($page > $pages) $page = $pages;
    echo "<li class='page-item " . ($_SESSION['currentPage'] == $page ? 'active' : '') . "'>
            <a onclick='ajaxPagination($page, $DieOrlive)' class='page-link'>$page</a>
        </li>";
}

// Lien vers la page suivante (désactivé si on se trouve sur la dernière page)
echo "<li class='page-item " . ($_SESSION['currentPage'] == $pages ? 'disabled' : '') . "'>
            <a onclick='ajaxPagination(" . ($_SESSION['currentPage'] + 1), $DieOrlive .")' class='page-link'>Suivante</a>
        </li>
    </ul>
</nav>
<div class='col col-lg-2'></div>
</div>";
?>
