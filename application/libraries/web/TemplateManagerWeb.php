<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class TemplateManagerWeb {
		const VIEW_PATH = 'web/';
		const TPL_PATH = 'web/template/';
		
		/**
		 * Tampilkan halaman menggunakan templat default
		 * @param string $view
		 * @param array $data
		 */
		public function viewDefault($view,$data) {
			$ci = &get_instance();
			$data['body'] = $ci->load->view(static::VIEW_PATH.$view,$data,true);

			$data['menu'] = $ci->load->view(static::TPL_PATH.'body_menu',$data,true);
			$data['sidebar'] = $ci->load->view(static::TPL_PATH.'body_sidebar',$data,true);
			
			$data['header'] = $ci->load->view(static::TPL_PATH.'body_header',$data,true);
			$data['body'] = $ci->load->view(static::TPL_PATH.'body_main',$data,true);
			
			$data['head'] = $ci->load->view(static::TPL_PATH.'head',$data,true);
			$data['body'] = $ci->load->view(static::TPL_PATH.'body',$data,true);
			
			$ci->load->view(static::TPL_PATH.'page',$data);
		}
		
		/**
		 * Mendapatkan link gambar yang cocok
		 * @param array $image
		 * @return $string
		 */
		public function getPostImageLink($image) {
			$wori = $image['original']['width'];
			if($wori > 720)
				return $image['medium']['link'];
			else
				return $image['original']['link'];
		}
    }