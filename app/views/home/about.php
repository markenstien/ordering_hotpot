<?php build('content') ?>
<section class="bg-success py-5">
    <div class="container">
        <div class="row align-items-center py-5">
            <div class="col-md-8 text-white">
                <h1>About Us</h1>
                <p>
                The Cadaceous Drug and Medica Supplies opened in 1998. Every day, the pharmacy sells thousands of medications, 
                supplying all the residents in the surrounding districts. 
                There are two branches of Cadeceous Drugs and Medical Supplies. 
                One branch is situated in Quezon City, in the NCR region of the Philippines, and the other is situated in Bulacan,
                 in Central Luzon. The drugstore's owner earned a bachelor's degree in pharmaceutical sciences and will continue to expand the Drugstore.
                </p>

                <div style="background-color: #fff;"><img src="<?php echo _path_upload_get('cadaceous_logo.png');?>" alt="<?php echo COMPANY_NAME?> Logo"
                style="width:350px; margin:0px auto; display:block"></div>
            </div>
            <div class="col-md-4">
                <img src="<?php echo _path_upload_get('cadaceous.jpg')?>" alt="About Hero">
            </div>
        </div>
    </div>
</section>
<!-- Close Banner -->
<?php endbuild()?>

<?php loadTo('tmp/landing')?>