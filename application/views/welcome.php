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
    <br>
    <div class="row">
        <div class="col-lg-4 col-md-6  col-xs-12">
            <img class="img-responsive center-block img-circle" src="<?=base_url()?>assets/images/1.png">
            <div class="text-center">
                Start the new year in great shape by grabbing some weights and put out all the sugar from this past christmas.
            </div>
        </div>
        <div class="col-lg-4 col-md-6  col-xs-12">
            <img class="img-responsive center-block img-circle" src="<?=base_url()?>assets/images/2.png">
            <div class="text-center">
                Run to your nearest tenis court and release those energies by shooting some balls with your friends. Show them that you're a winner.
            </div>
        </div>
        <div class="col-lg-4 col-md-6  col-xs-12">
            <img class="img-responsive center-block img-circle" src="<?=base_url()?>assets/images/3.png">
            <div class="text-center">
                Have you noticed those dance classes happening near the beach? Give it a try and shake it all off.
            </div>
        </div>
    </div>
</div>
