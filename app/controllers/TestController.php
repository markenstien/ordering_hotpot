<?php 

	class TestController extends Controller

	{

		public function index()
		{
			$test = "300.31";

			var_dump(floatval($test) - 100);
		}
	}