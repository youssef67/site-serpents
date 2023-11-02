<div class="row">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <img src="../img/others/logo.png"
                 class="rounded-circle"
                 alt=""
                 style="width: 50px; height: 50px"
            />
            <button
                    class="navbar-toggler"
                    type="button"
                    data-mdb-toggle="collapse"
                    data-mdb-target="#navbarNav"
                    aria-controls="navbarNav"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
            >
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link"  href="index.php">Home</a>
                    </li><li class="nav-item">
                        <a class="nav-link" href="index.php?page=vivarium">Vivarium</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=loveRoom">Love room</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=cimetiere">Cimetière</a>
                    </li>
                </ul>
                <?php if(isset($_REQUEST["page"]) && $_REQUEST["page"] == "vivarium") { ?>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link"  href="index.php?page=updtSnake&id=new">Créer un nouveau Serpent</a>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </nav>
</div>
