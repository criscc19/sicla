<?php
require 'main.inc.php';
$page_title = 'Menu';

llxHeader('', $page_title, $help_url);
?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<style>
body{background:#f3f3f3;}
#wrapper{padding:90px 15px;}
.navbar-expand-lg .navbar-nav.side-nav{flex-direction: column;}
.card{margin-bottom: 15px; border-radius:0; box-shadow: 0 3px 5px rgba(0,0,0,.1); }
.header-top{box-shadow: 0 3px 5px rgba(0,0,0,.1)}
.leftmenutrigger, .navbar-nav li a .shortmenu{display: none}
.card-title{ font-size: 28px}
@media(min-width:992px) {
.leftmenutrigger{display: block;display: block;margin: 7px 20px 4px 0;cursor: pointer;}
#wrapper{padding: 90px 15px 15px 75px; }
#wrapper.open{padding: 90px 15px 15px 225px; }
.navbar-nav.side-nav.open {left:0;}
.side-nav li a {padding: 20px}
.navbar-nav li a .shortmenu {float: right;display: block;opacity: 1}
.navbar-nav.side-nav.open.navbar-nav li a .shortmenu {opacity: 0}
.navbar-nav.side-nav{background: #585f66;box-shadow: 2px 1px 2px rgba(0,0,0,.1);position:fixed;top:56px;flex-direction: column!important;left:-140px;width:200px;bottom:0;padding-bottom:40px}
}
.animate{-webkit-transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;-ms-transition:all .2s ease-in-out;transition:all .2s ease-in-out}
.navbar-nav li a svg{font-size: 25px;float: left;margin: 0 10px 0 5px;}
.side-nav li { border-bottom: 1px solid #50575d;}
.side-nav .dropdown {position:initial;}
.side-nav .dropdown-menu {position:relative;opacity:0;left:120%;top:0;height:100%;border:0;padding:0;margin:0;border-radius:0;box-shadow:5px 0 5px rgba(0,0,0,.1);background:#eee;visibility: hidden;display:block;transition: .4s ease all;}
.side-nav .dropdown-menu.show {left:100%;opacity:1;visibility: visible;display:block;transition: .4s ease all;}
</style>
<!------ Include the above in your HEAD tag ---------->

  <div id="wrapper" class="animate">
    <nav class="navbar header-top fixed-top navbar-expand-lg navbar-dark bg-dark">
      <span class="navbar-toggler-icon leftmenutrigger"></span>
      <a class="navbar-brand" href="#">LOGO</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav animate side-nav">
          <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user"></i> Submenu <i class="fas fa-user shortmenu animate"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
          <li class="nav-item">
            <a class="nav-link" href="#" title="Cart"><i class="fas fa-cart-plus"></i> Cart <i class="fas fa-cart-plus shortmenu animate"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" title="Comment"><i class="fas fa-comment"></i> Comment <i class="fas fa-comment shortmenu animate"></i></a>
          </li>
        </ul>
        <ul class="navbar-nav ml-md-auto d-md-flex">
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fas fa-user"></i> Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fas fa-key"></i> Logout</a>
          </li>
        </ul>
      </div>
    </nav>
    <div class="container-fluid">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Try Other</h5>
              <h6 class="card-subtitle mb-2 text-muted">Bootstrap 4.0.0 Snippet by pradeep330</h6>
              <p class="card-text">You can also try different version of Bootstrap V4 side menu. Click below link to view all Bootstrap Menu versions.</p>
              <a href="https://bootsnipp.com/pradeep330" class="card-link">link</a>
              <a href="http://websitedesigntamilnadu.com" class="card-link">Another link</a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Try Other</h5>
              <h6 class="card-subtitle mb-2 text-muted">Bootstrap 4.0.0 Snippet by pradeep330</h6>
              <p class="card-text">You can also try different version of Bootstrap V4 side menu. Click below link to view all Bootstrap Menu versions.</p>
              <a href="https://bootsnipp.com/pradeep330" class="card-link">link</a>
              <a href="http://websitedesigntamilnadu.com" class="card-link">Another link</a>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Card title</h5>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Card title</h5>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

 <script>
$(document).ready(function () {
  $('.leftmenutrigger').on('click', function (e) {
    $('.side-nav').toggleClass("open");
    $('#wrapper').toggleClass("open");
    e.preventDefault();
  });
});
 </script>
<?php
llxFooter();

$db->close();
 
?>