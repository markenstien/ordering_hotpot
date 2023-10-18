<?php build('content') ?>
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
                <div class="row">
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
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <h6>Brand:</h6>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted"><strong><?php echo $item->brand_name?></strong></p>
                            </li>
                        </ul>

                        <h6>Description:</h6>
                        <p><?php echo $item->remarks?></p>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <h6>Manufacturer:</h6>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted"><strong><?php echo $item->manufacturer_name?></strong></p>
                            </li>
                        </ul>

                        <h6>Specification:</h6>
                        <ul class="list-unstyled pb-3">
                            <li>Packing : <?php echo $item->packing?>'s</li>
                            <li>Quantity Per Case : <?php echo $item->qty_per_case?> </li>
                        </ul>
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
            <?php foreach($relatedProducts as $key => $row) :?>
                <div class="p-2 pb-3">
                    <div class="product-wap card rounded-0">
                        <div class="card rounded-0">
                            <img class="card-img rounded-0 img-fluid" src="<?php echo $row->images[0]->full_url?>" style="width: 150px;">
                            <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                <ul class="list-unstyled">
                                    <li>
                                        <a class="btn btn-success text-white mt-2" href="<?php echo _route('home:catalog-view', $row->id)?>">
                                        <i class="far fa-eye"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <a href="shop-single.html" class="h3 text-decoration-none"><?php echo $row->name?></a>
                            <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                <li><?php echo wPacking($row->packing)?></li>
                                <li class="pt-2">
                                    <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                                </li>
                            </ul>
                            <ul class="list-unstyled d-flex justify-content-center mb-1">
                                <li>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-muted fa fa-star"></i>
                                </li>
                            </ul>
                            <p class="text-center mb-0">$20.00</p>
                        </div>
                    </div>
                </div>
            <?php endforeach?>
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