<?php

/*
possibilities


- type = id, value = id => a post permalink
- type = id, value = 0, inside The Loop => the permalink of current post

- type = slug, value = a post slug => a post permalink

- type = comment, value = comment ID

- type = cat_id, tag_id; value = valid taxonomy ID
- type = cat_slug, tag_slug, tax_slug; value = valid taxonomy slug

- type = tag_id, tag_id; value = valid taxonomy ID
- type = tag_slug, tag_slug, tax_slug; value = valid taxonomy slug


- type = tax_id, value = valid taxonomy ID, taxonomy_type = valid custom taxonomy type
- type = tax_slug, value = valid taxonomy slug, taxonomy_type = valid custom taxonomy type

- type = post_feed, value = post ID *or* slug
- type = cat_feed, value = category ID *or* slug
- type = tag_feed, value = tag ID *or* slug
- type = tax_feed -> *not yet implemented*


- title_only="1": instead of printing a link, print its title attribute

*/



class HkInLink extends HkInLink_HkTools{

	public function __construct(){
		parent::__construct();
		
		
		$this->setFilters();
	}
	
	
	public function setFilters(){
	
		add_shortcode('p2p', array($this, 'shortcode'));
		add_shortcode('hkLink', array($this, 'shortcode'));
	
		add_action('wp_head', array($this, 'errorStyle'));
	
	}




	public function shortcode($atts, $content=null){
	
		// $content has priority over $text, if it is not empty overwrite $text with it
		if( !empty($content) && '{{emtpy}}'!=$content && '{{title}}'!=$content ){
			$atts['text']=$content;
		}
		
		return $this->setLink($atts);
	
	}


    public function setLink($args = ''){
        global $wpdb;
		
		$defaults = array(
            'type' => 'id',
            'value' => 0,
            'text' => null,
			'section' => null,
            'attributes' => null,
			"title_only" => null,
			'taxonomy_type' => "invalid_type"
		);
		
		$args = wp_parse_args( $args, $defaults );
		$args = apply_filters('hkInLink_setLink_args', $args);
		extract($args);
		
		$title='';
		

		
		// port to switch()
        if($type == 'id'){
		
			if(!is_numeric($value))
				return $this->reportError("invalid parameter, when type=id, value must be numeric, but it's $value",$text);

			// tests ifthis ID refers to a valid post
			// if this ID is 0 and we're inside The Loop, it will return current post
			$post = get_post($value);
			if(empty($post) || is_wp_error($post)){
				return $this->reportError("There seems to not be a post with id $value",$text);
			}
			
			
			
			// get_the_title() is required because it encodes special characters, that are not encoded in database
			$title = get_the_title($value);
			
            $permalink = get_permalink($value);
        }

        elseif($type == 'slug'){
		
			$id = $wpdb->get_var($wpdb->prepare("select ID from {$wpdb->posts} where post_name = %s", $value));
		
			if(!is_numeric($id)){
				return $this->reportError("There seems to not be a post with slug $value",$text);
			}
			
			
			// get_the_title() is required because it encodes special characters, that are not encoded in database
			$title = get_the_title($id);
		
            $permalink = get_permalink($id);
        }

        elseif($type == 'comment'){
		
			if(!is_numeric($value))
				return $this->reportError("invalid parameter, when type=comment, value must be a comment ID, but it's $value",$text);

			// tests ifthis ID refers to a valid comment
			// if this ID is 0 and we're inside The Loop, it will return current comment
			$comment = get_comment($value);
			if(empty($comment) || is_wp_error($comment)){
				return $this->reportError("There seems to not be a comment with id $value",$text);
			}
			
			$post = get_post($comment->comment_post_ID);
			if(empty($post) || is_wp_error($post)){
				return $this->reportError("For some strange reason, the comment with id $value doesn't have a valid post related to it",$text);
			}
			
			
			// get_the_title() is required because it encodes special characters, that are not encoded in database
			$post_title = get_the_title($post->ID);
			
			if(function_exists('hkTC_get_comment_title'))
				$comment_title = hkTC_get_comment_title($comment->comment_ID);
			
			if(empty($comment_title))
				$comment_title = "comment #" . $comment->comment_ID;
			else
				$comment_title = "comment '".$comment_title."'";
			
			
				
			$title = $comment_title . " @ " . "'".$post_title."'";
			
			
			
            $permalink = get_comment_link($value);
			$section = null;
        }
		
		elseif($type == 'cat_slug' || $type == 'tag_slug' || $type == 'tax_slug'){
			$term_obj = null;
			
			if($type == 'cat_slug'){
				$taxname = $taxtype = "category";
			}elseif($type == 'tag_slug'){
				$taxname = "tag";
				$taxtype = 'post_tag';
			}else{
				if(!is_taxonomy($taxonomy_type))
					return $this->reportError("There is no custom taxonomy of type $taxonomy_type",$text);
			
				$taxtype = $taxonomy_type;
				$taxname = "taxonomy " . $taxonomy_type;
			}
			
			
			
			$term_obj = get_term_by( 'slug', $value, $taxtype );
			if( empty($term_obj) || is_wp_error($term_obj) ){
				return $this->reportError("There seems to not be a $taxname with slug $value",$text);
			}
		
		
		
			$title = $term_obj->name;
			
			$permalink = get_term_link($term_obj,$taxtype);
		
		}
		
        elseif($type == 'cat_id' || $type == 'tag_id' || $type == 'tax_id'){
		
			if(!is_numeric($value))
				return $this->reportError("invalid parameter, when type=cat_id|tag_id|tax_id, value must be its ID, but it's $value",$text);
			

			$term_id = $value;
			$term_obj = null;
			
			if($type == 'cat_id'){
				$taxname = $taxtype = "category";
			}elseif($type == 'tag_id'){
				$taxname = "tag";
				$taxtype = 'post_tag';
			}else{
				if(!is_taxonomy($taxonomy_type))
					return $this->reportError("There is no custom taxonomy of type $taxonomy_type",$text);
			
				$taxtype = $taxonomy_type;
				$taxname = "taxonomy " . $taxonomy_type;
			}
			
			
			$term_obj = get_term( $term_id, $taxtype);
			if( empty($term_obj) || is_wp_error($term_obj) ){
				return $this->reportError("There seems to not be a $taxname with ID $value",$text);
			}
            
			
			$title = $term_obj->name;	//single_cat_title()
			
			$permalink = get_term_link($term_obj,$taxtype);
        }


		
		
		
		elseif($type == 'post_feed'){
		
			if(is_numeric($value)){
				$post_id = $value;
			}else{
				$post_id = $wpdb->get_var($wpdb->prepare("select ID from {$wpdb->posts} where post_name = %s", $value));
			
				if(!is_numeric($post_id)){
					return $this->reportError("There seems to not be a post with slug $value",$text);
				}
			}
		
			
			$title = "Comments feed for '" . get_the_title($post_id) . "'";
		
			$permalink = get_post_comments_feed_link($post_id);
		
		}
		
		elseif($type == 'cat_feed' || $type == 'tag_feed' || $type == 'tax_feed'){
		
			if($type == 'tax_feed')
				return $this->reportError("Custom taxonomy feed link not yet implemented",$text);
		
		
			if($type == 'cat_feed'){
				$taxname = $taxtype = "category";
			}elseif($type == 'tag_feed'){
				$taxname = "tag";
				$taxtype = 'post_tag';
			}else{
				if(!is_taxonomy($taxonomy_type))
					return $this->reportError("There is no custom taxonomy of type $taxonomy_type",$text);
			
				$taxtype = $taxonomy_type;
				$taxname = "taxonomy " . $taxonomy_type;
			}
		
			if(!is_numeric($value)){
				$term_obj = get_term_by( 'slug', $value, $taxtype );
				if( empty($term_obj) || is_wp_error($term_obj) ){
					return $this->reportError("There seems to not be a $taxname with slug $value",$text);
				}
			
			}else{
				$term_obj = get_term( $value, $taxtype);
				if( empty($term_obj) || is_wp_error($term_obj) ){
					return $this->reportError("There seems to not be a $taxname with ID $value",$text);
				}
			}
		
		
		
			$title = "RSS feed for $taxname '$term_obj->name'";
	
	
			if($type == 'cat_feed')		$permalink = get_category_feed_link($term_obj->term_id);
			elseif($type == 'tag_feed')	$permalink = get_tag_feed_link($term_obj->term_id);
			else return $this->reportError("Custom taxonomy feed link not yet implemented",$text);
		
		
		}
		
		
		
		
        else{
            return $this->reportError("Invalid link type: $type",$text);
        }

		
		
		
		
		if(is_wp_error($permalink)){
			return $this->reportError('An unespected error happened in Hikari Internal Links plugin. $permalink returned with error "'. $permalink->get_error_message() .'".',$text);
		}
		
		if( !empty($section)  &&  $section[0]!='#' ){
			$section='#'.$section;
		}
		
		if(empty($text)){
			$text = $title;
		}
		
		if($title_only){
			return $title;
		}
		
		
        $link = '<a href="' . $permalink . $section .'" title="'. $title .'"';

        if(!$this->isBlank($attributes)){
            $link .= " $attributes";
        }

        $link .= ">$text</a>";

        return $link;
    }




	public function reportError($error='Hikari Internal Links default error',$text=''){
	
		// wpdberror is a default CSS class
		//the error is an anchor (with no href!) so that expected style can still be applied and iferror is displayed it looks a bit more as it would be ifit wasn't an error x.x
		
		$errorMsg = '';
		
		if(!empty($text)){
			$errorMsg .= "<a>$text</a>";
		}
		
		$errorMsg .= '<span class="wpdberror"> (Hikari Internal Links error: ' . $error . ') </span>';
		
		return apply_filters('hkInLink_error_msg', $errorMsg,$error,$text);
	
	}


	public function errorStyle(){
		$style = "display: none;";
		if(current_user_can("edit_posts"))
			$style = "display: inline !important; background-color: yellow;";
	
		echo "\n<!-- Dynamic Internal Links provided by \n Hikari Internal Links - http://Hikari.ws/email-url-obfuscator -->
<style type='text/css'>.wpdberror{ $style }</style>\n";
	}
}


global $hkInLink;
$hkInLink = new HkInLink();