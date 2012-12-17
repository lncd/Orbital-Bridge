<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Bridge {

    public function categories()
    {
    	$p_c = new Page_category();
    	$p_c->order_by('order');
    	$p_c->where('active', 1);
		return $p_c->get();
    }
    
    public function pages()
    {
    	$p = new Page();
		return $p->get();
    }
    
    public function category_pages()
    {
	    $categories = $this->categories();
		
		$category_pages = array();
		
		foreach($categories as $category)
		{
			$p = new Page();
			$p->where_related_page_category_link('page_category_id', $category->id);
			$p->order_by('order');
			$pages = $p->get();
			$category_pages[$category->id] = $pages;
		}
		
		return $category_pages;
    }
}