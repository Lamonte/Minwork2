<?php
//load template
$template = new view("template");
$template->content = "404 Page Not Found";
$template->render();