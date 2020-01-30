<?php
	// fungsi membuat menu
	function createMenu($arrmenu,&$i) {
		if(empty($arrmenu[$i]))
			return '';
		
		$menu = $arrmenu[$i];
		
		$level =  $menu['levelmenu'];
		$j=$i+1;
		$nextlevel =  $arrmenu[$j]['levelmenu'];
		
		if(!empty($menu['namafile']))
			$href = site_url($menu['namafile']);
		else
			$href = 'javascript:void(0)';
		
		if($menu['namamenu'] == ':separator') {
			$class = 'divider';
			$nama = '';
		}
		else {
			if($nextlevel > $level) {
				if($level == 0)
					$class = 'dropdown';
				else
					$class = 'dropdown-submenu';
			}
			else
				$class = '';
			
			$nama = $menu['namamenu'];
			if($nextlevel > $level) {
				if($level == 0)
					$nama .= ' <i class="fa pull-right fa-angle-down"></i>';
				else
					$nama .= ' <i class="fa pull-right fa-angle-right"></i>';
			}
			
			$nama = '<a href="'.$href.'">' .$nama.'</a>';
		}
		
		$str = '<li'.(empty($class) ? '' : ' class="'.$class.'"').'>'.$nama;
		if($nextlevel > $level) {
			$class = 'dropdown-menu';
			if($level > 0)
				$class .= ' sub-menu';
			$i++;
			$str .= "\n".'<ul class="'.$class.'">'."\n";
			$str .= createMenu($arrmenu,$i);
			$str .= '</ul>'."\n";
		}
		else
			$str .= '</li>'."\n";
		
		$nextlevel = $arrmenu[$j]['levelmenu'];
		if($nextlevel < $level)
			return $str;
		else {
		    $i++;
			return $str.createMenu($arrmenu,$i);
		}
	}
?>
<ul class="nav nav-pills">
	<?php
		$i = 0;
		echo createMenu($arrmenu,$i);
	?>
</ul>