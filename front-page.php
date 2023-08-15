<?php get_header(); ?>

<main class="main">
<div>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-xs-12">
                This is the first column.
                <?php new Inc\Hello(); ?>
            </div>
            <div class="col-md-9 col-xs-12">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-xs-12">
                            <div class="card" style="width: 18rem;">
                                <img src="https://placehold.jp/300x200.png" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">An item</li>
                                    <li class="list-group-item">A second item</li>
                                    <li class="list-group-item">A third item</li>
                                </ul>
                                <div class="card-body">
                                    <a href="#" class="card-link">Card link</a>
                                    <a href="#" class="card-link">Another link</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
<?php get_footer(); ?>