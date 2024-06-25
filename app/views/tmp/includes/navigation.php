<div class="container-xxl position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
        <a href="" class="navbar-brand p-0">
            <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i><?php echo COMPANY_NAME?></h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0 pe-4">
                <?php if(whoIs()) :?>
                    <a href="<?php echo _route('order:index')?>" class="nav-item nav-link">
                        <span class="badge bg-info">Back to Account</span>
                    </a>
                <?php endif?>
               <a href="<?php echo _route('home:index')?>" class="nav-item nav-link active">Home</a>
               <a href="<?php echo _route('home:shop')?>" class="nav-item nav-link">Menu</a>
               <a href="<?php echo _route('home:reservation')?>" class="nav-item nav-link">Reservation</a>
               <?php if(!whoIs()) :?>
               <a href="<?php echo _route('auth:login')?>" class="nav-item nav-link">Login</a>
               <?php endif?>
               <a href="<?php echo _route('cart:index')?>" class="nav-item nav-link">Cart</a>
               <a href="#contact" class="nav-item nav-link">Contact</a>
            </div>
        </div>
    </nav>
</div>