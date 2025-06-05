<?php

use illuminate\support\facades\route;

route::view('/', 'welcome');
route::view('/about', 'about');
route::view('/contact', 'contact');