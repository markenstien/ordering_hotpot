<?php build('content') ?>
<div class="container-xxl">
    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container my-5 py-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-3 text-white animated slideInLeft">Meal<br>Overview</h1>
                </div>
                <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                    <img class="img-fluid" src="img/hero.png" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Open Content -->
<section class="bg-light">
    <div class="container pb-5">
        <div class="row">
            <div class="col-lg-5 mt-5">
                <div class="card mb-3 main-image-container">
                    <div class="img-magnifier-container">
                        <img class="card-img img-fluid" src="<?php echo $item->images[0]->full_url ?? ''?>" 
                        alt="Card image cap" id="product-detail">
                    </div>
                </div>
                <div class="row" style="display: none;">
                    <!--Start Controls-->
                    <div class="col-1 align-self-center">
                        <a href="#multi-item-example" role="button" data-bs-slide="prev">
                            <i class="text-dark fas fa-chevron-left"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                    </div>
                    <!--End Controls-->
                    <!--Start Carousel Wrapper-->
                    <div id="multi-item-example" class="col-10 carousel slide carousel-multi-item" data-bs-ride="carousel">
                        <!--Start Slides-->
                        <div class="carousel-inner product-links-wap" role="listbox">

                            <!--First slide-->
                            <div class="carousel-item active">
                                <div class="row">
                                    <?php foreach($item->images as $key => $image) :?>
                                        <div class="col-4">
                                            <a href="#">
                                                <img class="card-img img-fluid img-thumbnail" src="<?php echo $image->full_url?>" 
                                                alt="Product Image 1" style="width:150px; height:150px"
                                                id="<?php echo uniqid('thumbnail')?>">
                                            </a>
                                        </div>
                                    <?php endforeach?>
                                </div>
                            </div>
                            <!--/.First slide-->
                        </div>
                        <!--End Slides-->
                    </div>
                    <!--End Carousel Wrapper-->
                    <!--Start Controls-->
                    <div class="col-1 align-self-center">
                        <a href="#multi-item-example" role="button" data-bs-slide="next">
                            <i class="text-dark fas fa-chevron-right"></i>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <!--End Controls-->
                </div>
            </div>
            <!-- col end -->
            <div class="col-lg-7 mt-5">
                <div class="card">
                    <div class="card-body">
                        <?php Flash::show()?>
                        <h1 class="h2"><?php echo $item->name?></h1>
                        <label for="#">(#<?php echo $item->sku?>)</label>
                        <p class="h3 py-2">PHP <?php echo amountHTML($item->sell_price)?></p>
                        <h6>Remarks</h6>
                        <p><?php echo $item->remarks?></p>

                        <?php
                            Form::open([
                                'method' => 'post',
                                'action' => _route('cart:add', $item->id)
                            ]);
                            Form::hidden('item_id', $item->id);
                            Form::hidden('price',$item->sell_price);
                        ?>
                            <div class="row">
                                <div class="col-auto">
                                    <ul class="list-inline pb-3">
                                        <li class="list-inline-item text-right">
                                            Quantity
                                            <input type="hidden" name="quantity" id="product-quanity" value="1">
                                        </li>
                                        <li class="list-inline-item"><span class="btn btn-success" id="btn-minus">-</span></li>
                                        <li class="list-inline-item"><span class="badge bg-secondary" id="var-value">1</span></li>
                                        <li class="list-inline-item"><span class="btn btn-success" id="btn-plus">+</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row pb-3">
                                <div class="col d-grid">
                                    <button type="submit" class="btn btn-success btn-lg" name="submit">Add To Cart</button>
                                </div>
                            </div>
                        <?php Form::close()?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Close Content -->

<!-- Start Article -->
<section class="py-5">
    <div class="container">
        <div class="row text-left p-2 pb-3">
            <h4>Related Products</h4>
        </div>
        <!--Start Carousel Wrapper-->
        <div id="carousel-related-product">
            <div class="row">
            <?php foreach($relatedProducts as $key => $row) :?>
                <div class="col-lg-6 mb-5" onclick="window.location = '<?php echo _route('home:catalog-view', $row->id)?>'" style="cursor:pointer">
                    <div class="d-flex align-items-center">
                        <div class="w-100 d-flex flex-column text-start ps-4">
                            <h5 class="d-flex justify-content-between border-bottom pb-2">
                                <span><?php echo $row->name?></span>
                                <span class="text-primary"><?php echo amountHTML($row->sell_price, 'PHP')?></span>
                            </h5>
                            <div class="mb-2">
                                <img class="flex-shrink-0 img-fluid rounded" src="<?php echo $row->images[0]->full_url ?? ''?>" 
                                alt="" style="width: 150px;">
                            </div>
                            <small class="fst-italic"><?php echo $row->remarks?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach?>
            </div>
        </div>
    </div>
</section>
<!-- End Article -->
<?php endbuild() ?>

<?php build('styles')?>
<style>
    * {box-sizing: border-box;}

    .img-magnifier-container {
        position:relative;
    }

    .img-magnifier-container img{
        height: 500px;
    }

    .img-magnifier-glass {
        position: absolute;
        border: 3px solid #000;
        cursor: none;
        /*Set the size of the magnifier glass:*/
        width: 250px;
        height: 250px;
    }
</style>
<?php endbuild()?>
<?php build('scripts')?>
<!-- Start Slider Script -->
<script src="<?php echo _path_tmp('main-tmp/assets/js/slick.min.js')?>"></script>
    <script>
        function magnify(imgID, zoom) {
            var img, glass, w, h, bw;

            img = document.getElementById(imgID);
            /*create magnifier glass:*/
            glass = document.createElement("DIV");
            glass.setAttribute("class", "img-magnifier-glass");
            /*insert magnifier glass:*/
            img.parentElement.insertBefore(glass, img);
            /*set background properties for the magnifier glass:*/
            glass.style.backgroundImage = "url('" + img.src + "')";
            glass.style.backgroundRepeat = "no-repeat";
            glass.style.backgroundSize = (img.width * zoom) + "px " + (img.height * zoom) + "px";
            bw = 3;
            w = glass.offsetWidth / 2;
            h = glass.offsetHeight / 2;
            /*execute a function when someone moves the magnifier glass over the image:*/
            glass.addEventListener("mousemove", moveMagnifier);
            img.addEventListener("mousemove", moveMagnifier);
            /*and also for touch screens:*/
            glass.addEventListener("touchmove", moveMagnifier);
            img.addEventListener("touchmove", moveMagnifier);

            function moveMagnifier(e) {
                var pos, x, y;
                /*prevent any other actions that may occur when moving over the image*/
                e.preventDefault();
                /*get the cursor's x and y positions:*/
                pos = getCursorPos(e);
                x = pos.x;
                y = pos.y;
                /*prevent the magnifier glass from being positioned outside the image:*/
                if (x > img.width - (w / zoom)) {x = img.width - (w / zoom);}
                if (x < w / zoom) {x = w / zoom;}
                if (y > img.height - (h / zoom)) {y = img.height - (h / zoom);}
                if (y < h / zoom) {y = h / zoom;}
                /*set the position of the magnifier glass:*/
                glass.style.left = (x - w) + "px";
                glass.style.top = (y - h) + "px";
                /*display what the magnifier glass "sees":*/
                glass.style.backgroundPosition = "-" + ((x * zoom) - w + bw) + "px -" + ((y * zoom) - h + bw) + "px";
            }

            function getCursorPos(e) {
                var a, x = 0, y = 0;
                e = e || window.event;
                /*get the x and y positions of the image:*/
                a = img.getBoundingClientRect();
                /*calculate the cursor's x and y coordinates, relative to the image:*/
                x = e.pageX - a.left;
                y = e.pageY - a.top;
                /*consider any page scrolling:*/
                x = x - window.pageXOffset;
                y = y - window.pageYOffset;
                return {x : x, y : y};
            }
        }

        $('.img-magnifier-container').on('mouseout', function(){
            $('.img-magnifier-glass').hide();
        });

        $('.img-magnifier-container').on('mouseover', function(){
            $('.img-magnifier-glass').hide();
            $('.img-magnifier-glass').show();
        });

        $('.img-thumbnail').click(function(){
            $('#product-detail').attr('src', $(this).attr('src'));
            if(document.querySelectorAll('.img-magnifier-glass')) {
                document.querySelectorAll('.img-magnifier-glass').forEach(box => {
                    box.remove();
                });
            }
            console.log($(this).attr('src'));
            magnify('product-detail', 2);
        });

        magnify('product-detail', 2);

        $('#carousel-related-product').slick({
            infinite: true,
            arrows: false,
            slidesToShow: 4,
            slidesToScroll: 3,
            dots: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 3
                    }
                }
            ]
        });
    </script>
<?php endbuild()?>
<?php loadTo('tmp/landing')?>