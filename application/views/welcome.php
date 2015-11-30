<!-- Call header_login on controller-->
<div class="menu-wrapper">
    <div id="pageHeader" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#pageHeader" data-slide-to="0" class="active"></li>
            <li data-target="#pageHeader" data-slide-to="1"></li>
            <li data-target="#pageHeader" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="item active">
                <div class="slide1"></div>
                <div class="carousel-caption" >
                    <h4>Improve your life!</h4>
                </div>
            </div>
            <div class="item">
                <div class="slide2"></div>
                <div class="carousel-caption">

                </div>
            </div>
            <div class="item">
                <div class="slide3"></div>
                <div class="carousel-caption">

                </div>
            </div>
        </div>
        <a href="#pageHeader" class="left carousel-control " data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a href="#pageHeader" class="right carousel-control " data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>
    <div class="login-menu">
            <div class="container-fluid">
                <div class="row">
                    <div class="well-lg  bg-primary login">
                        <form method="post" action="checklogin">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Email</span>
                                <input type="text" class="form-control" placeholder="email" name="email" id="email" aria-describedby>
                            </div><br/>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Password</span>
                                <input type="password" class="form-control" placeholder="password" name="password" id="password" >
                            </div><br/>
                            <input type="submit"  class="form-control" name="Login">
                        </form>
                    </div>
                </div>
            </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-4 col-md-6  col-xs-12">
            <img class="img-responsive center-block img-circle" src="<?=base_url()?>assets/images/1.png">
            <div class="text-center">
                O utilizador poderá visualizar as suas estatisticas de forma bastante simples e
            com a possibilidade de filtrar as suas actividades num determinado intervalo de tempo.
            </div>
        </div>
        <div class="col-lg-4 col-md-6  col-xs-12">
            <img class="img-responsive center-block img-circle" src="<?=base_url()?>assets/images/1.png">
            <div class="text-center">
                O utilizador poderá visualizar as suas estatisticas de forma bastante simples e
                com a possibilidade de filtrar as suas actividades num determinado intervalo de tempo.
            </div>
        </div>
        <div class="col-lg-4 col-md-6  col-xs-12">
            <img class="img-responsive center-block img-circle" src="<?=base_url()?>assets/images/1.png">
            <div class="text-center">
                O utilizador poderá visualizar as suas estatisticas de forma bastante simples e
                com a possibilidade de filtrar as suas actividades num determinado intervalo de tempo.
            </div>
        </div>
    </div>
</div>
