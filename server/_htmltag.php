<?php

function attr($key, $val) { return "$key=\"$val\""; }

function html_tag($tag, $attributes, $content)
{
	$str = "<$tag ";
	
	foreach ($attributes as $key => $value)
		$str .= attr($key, $value) . ' ';

	$str .= '>'; $str .= "\n";

	foreach ($content as $elt) $str .= $elt;

	$str .= "</$tag>"; $str .= "\n";

	return $str;
}

function html_single_tag($tag, $attributes)
{
	$str = "<$tag ";
	
	foreach ($attributes as $key => $value)
		$str .= attr($key, $value) . ' ';

	$str .= '/>'; $str .= "\n";

	return $str;
}

function html_tag_wrapper($tag, $args)
{
	$attributes = @is_array($args[0]) ? array_shift($args) : array();

	$content = $args;

	return html_tag($tag, $attributes, $content);
}

function html_single_tag_wrapper($tag, $args)
{
	$attributes = @is_array($args[0]) ? array_shift($args) : array();

	$content = $args;

	return html_single_tag($tag, $attributes, $content);
}

function html() { return html_tag_wrapper('html', func_get_args()); }
function head() { return html_tag_wrapper('head', func_get_args()); }
function title() { return html_tag_wrapper('title', func_get_args()); }
function body() { return html_tag_wrapper('body', func_get_args()); }
function h1() { return html_tag_wrapper('h1', func_get_args()); }
function h2() { return html_tag_wrapper('h2', func_get_args()); }
function h3() { return html_tag_wrapper('h3', func_get_args()); }
function h4() { return html_tag_wrapper('h4', func_get_args()); }
function h5() { return html_tag_wrapper('h5', func_get_args()); }
function h6() { return html_tag_wrapper('h6', func_get_args()); }
function a() { return html_tag_wrapper('a', func_get_args()); }
function pre() { return html_tag_wrapper('pre', func_get_args()); }
function span() { return html_tag_wrapper('span', func_get_args()); }
function strong() { return html_tag_wrapper('strong', func_get_args()); }
function table() { return html_tag_wrapper('table', func_get_args()); }
function td() { return html_tag_wrapper('td', func_get_args()); }
function tr() { return html_tag_wrapper('tr', func_get_args()); }
function p() { return html_tag_wrapper('p', func_get_args()); }
function form() { return html_tag_wrapper('form', func_get_args()); }
function script() { return html_tag_wrapper('script', func_get_args()); }
function div() { return html_tag_wrapper('div', func_get_args()); }

function img() { return html_single_tag_wrapper('img', func_get_args()); }
function br() { return html_single_tag_wrapper('br', func_get_args()); }
function input() { return html_single_tag_wrapper('input', func_get_args()); }
function script_link() { return html_single_tag_wrapper('script', func_get_args()); }

?>