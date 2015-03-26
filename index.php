<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

/**
 * Since you have installed from or have composer installed.
 */
require 'vendor/autoload.php';

/**
 * See data/colors.sql for importing the test data.
 */
$dbh = new PDO('mysql:host=localhost;dbname=test', 'root', 'phpdev');
$dbh->query('SET NAMES UTF8');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Generic Pagination</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style type="text/css">
            body { padding : 40px 0}
            h1, h2 { text-align:center;}
            .results-info-bar , .no-results-info-bar { font-size: 2rem; text-align:center; }
            .center { text-align: center;}
        </style>
    </head>
    <body>
        <div class="container">
            <h1>PHP Generic Pagination Samples</h1>
            <p>Simple to use pagination from any dataset. See samples below!</p>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <h2>From database ordered by Color Hexadecimal value</h2>
                    <?php
                    $stmt = $dbh->prepare("SELECT * FROM colors ORDER by color_hex");
                    $stmt->execute();
                    $resultSet = $stmt->fetchAll();
                    
                    $paginator = new Giba\Paginator($resultSet);
                    $paginator->setClass('pagination pagination-sm');
                    $paginator->setRange(3);
                    ?>
                    <?= $paginator->navigate('results'); ?>
                    <div class="center">
                        <?= $paginator->navigate('menu'); ?>
                    </div>                    
                    <table class="table table-bordered">
                        <tbody>
                            <?php foreach ($paginator->getResults() as $r) : ?>
                                <tr>
                                    <th width="45%"><?= $r['color_name']; ?></th>
                                    <td width="10%"><?= $r['color_hex']; ?></td>
                                    <td width="45%" style="background:<?= $r['color_hex']; ?>">&nbsp;</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="center">
                        <?= $paginator->navigate('menu'); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <h2>From database ordered by Color Name value</h2>
                    <?php
                    $stmt = $dbh->prepare("SELECT * FROM colors ORDER by color_name");
                    $stmt->execute();
                    $resultSet = $stmt->fetchAll();
                    $paginator = new Giba\Paginator($resultSet);
                    $paginator->setClass('pagination pagination-sm');
                    $paginator->setRange(3);
                    $paginator->setPaginator('hex');
                    ?>
                    <?= $paginator->navigate('results'); ?>
                    <div class="center">
                        <?= $paginator->navigate('menu'); ?>
                    </div>                    
                    <table class="table table-bordered">
                        <tbody>
                            <?php foreach ($paginator->getResults() as $r) : ?>
                                <tr>
                                    <th width="45%"><?= $r['color_name']; ?></th>
                                    <td width="10%"><?= $r['color_hex']; ?></td>
                                    <td width="45%" style="background:<?= $r['color_hex']; ?>">&nbsp;</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="center">
                        <?= $paginator->navigate('menu'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h2>From Array Width Paginator Translated into Portuguese</h2>
                    <?php
                    $resultSet = include 'data/colors.php';
                    $paginator = new Giba\Paginator($resultSet, 'pt_BR');
                    $paginator->setClass('pagination pagination-sm');
                    $paginator->setRange(10);
                    $paginator->setPaginator('arr');
                    ?>
                    <?= $paginator->navigate('results'); ?>
                    <div class="center">
                        <?= $paginator->navigate('menu'); ?>
                    </div>                    
                    <table class="table table-bordered">
                        <tbody>
                            <?php foreach ($paginator->getResults() as $key => $data) : ?>
                                <tr>
                                    <th width="4"><?= $key; ?></th>
                                    <th width="43%"><?= $data[0]; ?></th>
                                    <td width="10%"><?= $data[1]; ?></td>
                                    <td width="43%" style="background:<?= $data[1]; ?>">&nbsp;</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="center">
                        <?= $paginator->navigate('menu'); ?>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </body>
</html>
