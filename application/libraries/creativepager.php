<?php

/*
creativePager version 1.1
created by Creative Dreams 02-06-2010

<span id="pager_info1"></span>
<ul id="pager" class="">
	<li id="pager_first"><a href="">{FIRST}</a></li>
	<li id="pager_pos_first">...</li>
	<li id="pager_prev"><a href="">{PREV}</a></li>

	<!-- BEGIN DYNAMIC BLOCK: pages -->
	<li><a href="">{NUM_PAGE}</a></li>
	<!-- END DYNAMIC BLOCK: pages -->

	<li id="pager_next"><a href="">{NEXT}</a></li>
	<li id="pager_pre_last">...</li>
	<li id="pager_last"><a href="">{LAST}</a></li>
</ul>
<span id="pager_info2"></span>
*/

class CreativePager{

	var $id;
	var $class;
	var $selected_page;
	var $total_items;
	var $items_per_page;
	var $total_pages;
	var $type;
	var $nav_pages;
	var $url;
	var $info1;
	var $info2;
	var $first;
	var $last;
	var $pos_first;
	var $pre_last;
	var $prev;
	var $next;
	var $first_prev;
	var $next_last;
	var $out;

	function pager($params){
		global $tpl;

		// Default Values
		$this->id							= isset($params['id']) ? $params['id'] : 'pager';
		$this->class					= isset($params['class']) ? $params['class'] : '';
		$this->selected_page	= isset($params['selected_page']) ? ($params['selected_page']>0 ? $params['selected_page'] : 1) : 1;
		$this->total_items	 	= isset($params['total_items']) ? $params['total_items'] : '';
		$this->items_per_page	= isset($params['items_per_page']) ? ($params['items_per_page']>0 ? $params['items_per_page'] : 10) : 10;
		$this->total_pages	 	= isset($params['total_pages']) ? $params['total_pages'] : ceil($this->total_items/$this->items_per_page);
		$this->type					 	= isset($params['type']) ? $params['type'] : 'intelligent';
		$this->nav_pages		 	= isset($params['nav_pages']) ? (($params['nav_pages']!==true and $params['nav_pages']>0 or $params['nav_pages']===false) ? $params['nav_pages'] : 9) : 9;
		$this->url					 	= isset($params['url']) ? $params['url'] : '';
		$this->info1				 	= isset($params['info1']) ? (($params['info1']!==true or $params['info1']===false) ? $params['info1'] : 'Total: '.$this->total_items) : 'Total: '.$this->total_items;
		$this->info2				 	= isset($params['info2']) ? (($params['info2']!==true or $params['info2']===false) ? $params['info2'] : 'Soru: '.$this->selected_page.' / '.$this->total_pages) : 'Soru: '.$this->selected_page.' / '.$this->total_pages;
		$this->first				 	= isset($params['first']) ? ($params['first']===true ? 1 : $params['first']) : 1;
		$this->last					 	= isset($params['last']) ? ($params['last']===true ? $this->total_pages : $params['last']) : $this->total_pages;
		$this->pos_first		 	= isset($params['pos_first']) ? (($params['pos_first']!==true or $params['pos_first']===false) ? $params['pos_first'] : '...') : '...';
		$this->pre_last			 	= isset($params['pre_last']) ? (($params['pre_last']!==true or $params['pre_last']===false) ? $params['pre_last'] : '...') : '...';
		$this->prev					 	= isset($params['prev']) ? (($params['prev']!==true or $params['prev']===false) ? $params['prev'] : '«') : '«';
		$this->next					 	= isset($params['next']) ? (($params['next']!==true or $params['next']===false) ? $params['next'] : '»') : '»';
		$this->first_prev		 	= isset($params['first_prev']) ? ($params['first_prev']=='after' ? 'after' : 'before') : 'before';
		$this->last_next		 	= isset($params['last_next']) ? ($params['last_next']=='before' ? 'before' : 'after') : 'after';

	}

	// Substitute the tags #SELECTED_PAGE#, #TOTAL_ITEMS#, #TOTAL_PAGES# for their values, in the info1, info2, first, pos_first, prev, next, pre_last, last
	function check_expression($value){
		if($value){
			$value=str_replace('#SELECTED_PAGE#',$this->selected_page,$value);
			$value=str_replace('#TOTAL_ITEMS#',$this->total_items,$value);
			$value=str_replace('#TOTAL_PAGES#',$this->total_pages,$value);
		}
		return $value;
	}

	// Analises the url passed, if it has the tag #NUM_PAGE# it substitues for the true value of the page,
	// otherwise puts ?page=1 or &page=1 in the end of url
	function get_url($page){
		if(strpos($this->url,'#NUM_PAGE#')!==false){
			return str_replace('#NUM_PAGE#',$page,$this->url);
		}else{
			return $this->url.(strpos($this->url,'?')!==false ? '&' : '?').'page='.$page;
		}
	}

	// Button first
	function draw_first(){
		$out='';
		if($this->first){

			$out='<li id="'.$this->id.'_first"><a href="'.$this->get_url(1).'">'.$this->check_expression($this->first).'</a></li>';

			if($this->pos_first)
				$out.='<li id="'.$this->id.'_pos_first">'.$this->check_expression($this->pos_first).'</li>';

		}

		return $out;
	}

	// Button last
	function draw_last(){
		$out='';
		if($this->last){

			if($this->pre_last)
				$out='<li id="'.$this->id.'_pre_last">'.$this->check_expression($this->pre_last).'</li>';

			$out.='<li id="'.$this->id.'_last"><a href="'.$this->get_url($this->total_pages).'">'.$this->check_expression($this->last).'</a></li>';

		}

		return $out;
	}

	// Button previous
	function draw_prev(){
		$out='';
		if($this->prev and $this->selected_page>1)
			$out='<li id="'.$this->id.'_prev"><a href="'.$this->get_url($this->selected_page-1).'">'.$this->check_expression($this->prev).'</a></li>';

		return $out;
	}

	// Button next
	function draw_next(){
		$out='';
		if($this->next and $this->selected_page<$this->total_pages)
			$out='<li id="'.$this->id.'_next"><a href="'.$this->get_url($this->selected_page+1).'">'.$this->check_expression($this->next).'</a></li>';

		return $out;
	}

	function draw_info1(){
		return '<span id="'.$this->id.'_info1">'.$this->check_expression($this->info1).'</span>';
	}

	function draw_info2(){
		return '<span id="'.$this->id.'_info2">'.$this->check_expression($this->info2).'</span>';
	}

	// Builds the pager accordingly to the type desired
	function draw_type(){
		$out='';
		if($this->nav_pages){

			switch($this->type){

				case 'centered':
					$out=$this->type_centered();
				break;

				case 'paginated':
					$out=$this->type_paginated();
				break;

				default:
					$out=$this->type_intelligent();
				break;

			}

		}

		// Puts the first button before or after the previous button
		// and puts the last button before or after the next button
		return ($this->first_prev=='after' ? $this->draw_prev().$this->draw_first() : $this->draw_first().$this->draw_prev())
					 .$out.
					 ($this->last_next=='before' ? $this->draw_last().$this->draw_next() : $this->draw_next().$this->draw_last());
	}


	// Centered type - the selected page allways stays in the center
	function type_centered(){
		$out='';

		if($this->selected_page<=ceil(($this->nav_pages+1)/2)){
			$min=1;
			$max=$this->nav_pages;
			$this->first=false;
		}elseif($this->selected_page>$this->total_pages-floor(($this->nav_pages+1)/2)){
			$min=$this->total_pages-$this->nav_pages+1;
			$max=$this->total_pages;
			$this->last=false;
		}else{
			$min=$this->selected_page-ceil(($this->nav_pages-1)/2);
			$max=$min+$this->nav_pages-1;
		}

		if($this->total_pages<=$this->nav_pages)
			$this->last=false;

		if($min<1) $min=1;
		if($max>$this->total_pages) $max=$this->total_pages;

		for($i=$min; $i<=$max; $i++)
			$out.='<li><a href="'.$this->get_url($i).'" '.($i==$this->selected_page ? 'class="selected"' : '').'>'.$i.'</a></li>';

		return $out;
	}

	// Paginated Type - the pages stays the same until the next button is pressed and the selected page is the last in the navbar
	function type_paginated(){
		$out='';

		$total_group_pages=ceil($this->total_pages/$this->nav_pages);

		for($i=1; $i<=$total_group_pages; $i++){
			if($this->selected_page>=$i*$this->nav_pages-$this->nav_pages+1 and $this->selected_page<=$i*$this->nav_pages){
				$min=$i*$this->nav_pages-$this->nav_pages+1;
				$max=$i*$this->nav_pages;
				$total_group_pages_selected=$i;
			}
		}

		if($total_group_pages_selected==1)
			$this->first=false;
		if($total_group_pages_selected==$total_group_pages)
			$this->last=false;

		if($min<1) $min=1;
		if($max>$this->total_pages) $max=$this->total_pages;

		for($i=$min; $i<=$max; $i++)
			$out.='<li><a href="'.$this->get_url($i).'" '.($i==$this->selected_page ? 'class="selected"' : '').'>'.$i.'</a></li>';

		return $out;
	}

	// Intelligent type - similar to the centered type, that the selected page is allways in the center except that in the beggining/end it lets to choose more pages
	function type_intelligent(){
		$out='';

		if($this->selected_page<3+($this->nav_pages-1)/2){
			$min=1;
			$max=$this->nav_pages;
			$this->first=false;
		}elseif($this->selected_page>$this->total_pages-($this->nav_pages-1)/2-2){
			$min=$this->total_pages-$this->nav_pages+1;
			$max=$this->total_pages;
			$this->last=false;
		}else{
			$min=$this->selected_page-ceil(($this->nav_pages-1)/2);
			$max=$min+$this->nav_pages-1;
		}

		if($this->total_pages<=$this->nav_pages)
			$this->last=false;

		if($min<1) $min=1;
		if($max>$this->total_pages) $max=$this->total_pages;

		for($i=$min; $i<=$max; $i++){
			$out.='<li><a href="'.$this->get_url($i).'" '.($i==$this->selected_page ? 'class="selected"' : '').'>'.$i.'</a></li>';
		}

		return $out;
	}

	// Display the output
	function display(){

		// Builds the all structure of the pager (info1 + pager + info2)
		$out='';
		if($this->info1!==false)
			$out.=$this->draw_info1();
		if($this->total_pages>1){
			$out.='<ul id="'.$this->id.'"'.($this->class!='' ? ' class="'.$this->class.'"' : '').'>';
			$out.=$this->draw_type();
			$out.='</ul>';
		}
		if($this->info2!==false)
			$out.=$this->draw_info2();

		$this->out=$out;

		return $this->out;
	}

}

?>