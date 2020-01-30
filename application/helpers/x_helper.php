<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function xIsUserLoggedIn() {
		$ci = &get_instance();
		$ci->data['logged_in'] = false;

		if (//$_SESSION[G_SESSION]['remote_addr'] == $_SERVER['REMOTE_ADDR']
			//&& $_SESSION[G_SESSION]['user_agent'] == $_SERVER['HTTP_USER_AGENT']
			//&& 
			$_SESSION[G_SESSION]['iduser'] && $_SESSION[G_SESSION]['logged_in'] == 1) {
			
			$ci->data['logged_in'] = true;
			return true;
		}
		
		return false;

		if ($_SESSION[G_SESSION]['remote_addr'] != $_SERVER['REMOTE_ADDR']
			|| $_SESSION[G_SESSION]['user_agent'] != $_SERVER['HTTP_USER_AGENT']
			|| !$_SESSION[G_SESSION]['iduser']
			|| $_SESSION[G_SESSION]['logged_in'] != 1) {

			return false;
		}
		
		
		return false;
	}
	
	function xRemoveSpecial($mystr,$stripapp=true) {
		// $pattern = '/[%&;()\"';
		$pattern = '/[%&;\"';
		if($stripapp === false) // tidak stripping ', tapi direplace jadi '', biasanya dipakai di nama
			$mystr = str_replace("'","''",$mystr);
		else
			$pattern .= "\'";
		if(preg_match('/[A-Za-z%\/]/',$mystr)) // kalau ada alfabet, %, atau /, strip <>
			$pattern .= '<>';
		$pattern .= ']|--/';
		
		return preg_replace($pattern, '$1', $mystr);
	}
	
	function xStatusAktif($status) {
		return $status?'<span class="label label-success">Aktif</span>':'<span class="label label-danger">Tidak Aktif</span>';
	}
	
	function xFormatNumber($num) {
		return number_format($num,0,',',',');
	}

	function xFormatNumberDec($num) {
		return number_format($num,2,'.',',');
	}
	
	function xStripNumber($number, $str=',') {
		return str_replace($str,'',$number);
	}

	function xSetList($sql) {
		$list = array();
		$rs = dbGetRows($sql);
		foreach ($rs as $row) {
			$list[$row['ID']] = $row['VAL'];
		}
		return $list;
	}
	
	function xIsInRangeTime($start, $end, $now=null) {
		if (!$now) {
			$now = date('Y-m-d');
		}
		
		if ($start > $now || $end < $now)
			return false;
		
		return true;
	}
	
	function xIsValidDate($str) {
		if (preg_match('/-/',$str)) {
			$date = explode("-", $str);
			$month = (int)$date[1];
			$day = (int)$date[2];
			$year = (int)$date[0];
			return checkdate($month,$day,$year);
		}
		return false;
	}
	
	function xGetDiffDate($date1, $date2) {
		$diff = abs($date2 - $date1);
		return floor($diff / (60*60*24));
	}
	
	function xCheckDateKeyExist($key_date_list, $start, $end) {
		$date1 = strtotime($start);
		$date2 = strtotime($end);
		$diff = xGetDiffDate($date1, $date2);
		
		$idx = 0;
		$begin = $date1;
		for ($i=0;$i<$diff;$i++) {
			$date = strtotime("+$i day", $begin);
			$date_str = date('Y-m-d',$date);
			
			if (!key_exists($date_str, $key_date_list)) {
				return false;
			}
		}
		return true;
	}
	
	function xPageTitle($page_title='') {
		$ret = '';
		if ($page_title){
			$ret = "<h2 class=\"page-title\" style=\"margin-top:0;padding-bottom:20px;font-family:times new roman\">$page_title</h2><div class=\"clear\"></div>";
		}
		return $ret;
	}

	function xHTMLTextBox($nameid,$value='',$maxlength='',$size='',$edit=true,$class='form-control',$add='',$password=false) {
		if(!empty($edit)) {
			if ($password)
				$tb = '<input type="password" name="'.$nameid.'" id="'.$nameid.'"';
			else
				$tb = '<input type="text" name="'.$nameid.'" id="'.$nameid.'"';
			if($value != '') $tb .= ' value="'.$value.'"';
			if($class != '') $tb .= ' class="'.$class.'"';
			if($maxlength != '') $tb .= ' maxlength="'.$maxlength.'"';
			if($size != '') $tb .= ' size="'.$size.'"';
			if($add != '') $tb .= ' '.$add;
			$tb .= '>';
		}
		else if($value == '')
			$tb = '&nbsp;';
		else
			$tb = $value;
		
		return $tb;
	}

	function xHTMLTextArea($nameid,$value='',$rows='',$cols='',$edit=true,$class='',$add='') {
		if(!empty($edit)) {
			$ta = '<textarea wrap="soft" name="'.$nameid.'" id="'.$nameid.'"';
			if($class != '') $ta .= ' class="'.$class.'"';
			if($rows != '') $ta .= ' rows="'.$rows.'"';
			if($cols != '') $ta .= ' cols="'.$cols.'"';
			if($add != '') $ta .= ' '.$add;
			$ta .= '>';
			if($value != '') $ta .= $value;
			$ta .= '</textarea>';
		}
		else if($value == '')
			$ta = '&nbsp;';
		else
			$ta = nl2br($value);
		
		return $ta;
	}
	
	function xHTMLSelect($nameid,$arrval='',$value='',$edit=true,$class='',$add='',$emptyrow=false) {
		if(!empty($edit)) {
			$slc = '<select name="'.$nameid.'" id="'.$nameid.'"';
			if($class != '') $slc .= ' class="'.$class.'"';
			if($add != '') $slc .= ' '.$add;
			$slc .= ">\n";
			if($emptyrow)
				$slc .= '<option></option>'."\n";
			if(is_array($arrval)) {
				foreach($arrval as $key => $val) {
					$slc .= '<option value="'.$key.'"'.(!strcasecmp($value,$key) ? ' selected' : '').'>';
					$slc .= $val.'</option>'."\n";
				}
			}
			$slc .= '</select>';
		}
		else {
			if(is_array($arrval)) {
				foreach($arrval as $key => $val) {
					if(!strcasecmp($value,$key)) {
						$slc = $val;
						break;
					}
				}
			}
			if(!isset($slc))
				$slc = '&nbsp;';
		}
		
		return $slc;
	}

	function xHTMLCheckBox($nameid,$valuecontrol='',$value='',$edit=true,$class='',$add='') {
		if (!$edit && $value == $valuecontrol) {
			return '<span class="label label-success"><span class="glyphicon glyphicon-ok"></span></span>';
		}

		$tb = '<input type="checkbox" name="'.$nameid.'" id="'.$nameid.'"';
		if($valuecontrol != '') {
			$tb .= ' value="'.$valuecontrol.'"';
			if ($value == $valuecontrol)
				$tb .= ' checked ';
		}
		if($class != '') $tb .= ' class="'.$class.'"';
		if($add != '') $tb .= ' '.$add;
		if(!$edit)
			$tb .= ' disabled ';
		$tb .= '>';
		
		return $tb;
	}
	
	function xHTMLCheckBoxLabel($nameid,$valuecontrol='',$value='',$edit=true,$class='',$add='',$label='') {
		$style = '';
		if (!$edit && $value)
			$style = ' style="margin:0;padding:0"';
	
		echo "<label class=\"checkbox\" for=\"$nameid\" $style >";
		echo xHTMLCheckBox($nameid,$valuecontrol,$value,$edit);
		echo " $label</label>";
	}
	
	function xHTMLRadio($nameid,$arrval='',$value='',$edit=true,$br=false,$class='',$add='') {
		$radio = '';
		
		if(!empty($edit)) {
			if(is_array($arrval)) {
				foreach($arrval as $key => $val) {
					$radio .= '<label><input type="radio" name="'.$nameid.'" id="'.$nameid.'_'.$key.'" value="'.$key.'"'.(!strcasecmp($value,$key) ? ' checked' : '').' '.$add.'> ';
					$radio .= '&nbsp; ' . $val.'</label>'.($br ? '<br/>' : '')."\n";
				}
			}
		}
		else {
			if(is_array($arrval)) {
				foreach($arrval as $key => $val) {
					if(!strcasecmp($value,$key)) {
						$radio = $val;
						break;
					}
				}
			}
		}
		
		return $radio;
	}

	// mengubah format tanggal dari dd-mm-yyyy menjadi yyyy-mm-dd dan sebaliknya
	function xFormatDate($dmy,$delim='-',$todelim='-') {
		if($dmy == '')
			return '';
		if($dmy == 'null')
			return 'null';
		list($y,$m,$d) = explode($delim,substr($dmy,0,10));
		return $d.$todelim.$m.$todelim.$y;
	}
	
	// mengubah format tanggal dari yyyy-mm-dd menjadi format indonesia
	function xFormatDateInd($ymd,$full=true,$dmy=false,$delim='-',$withtime=false) {
		if ($withtime)
			$time = substr($ymd,11,5);

		if($ymd == '')
			return '';
		if($ymd == 'null')
			return 'null';
		
		if($dmy)       
			list($d,$m,$y) = explode($delim,substr($ymd,0,10));
		else
			list($y,$m,$d) = explode($delim,substr($ymd,0,10));
		
		return (int)$d.' '.xIndoMonth($m,$full).' '.$y. ' ' . $time;
	}
	
	// mengubah format tanggal, tapi ada time dibelakangnya
	function xFormatDateTime($dmy,$delim='-') {
		if($dmy == '')
			return '';
		if($dmy == 'null')
			return 'null';
		return xFormatDate(substr($dmy,0,10)).substr($dmy,10,6);
	}
	
	// mengubah format hhii menjadi hh:ii
	function xFormatTime($hi,$delim=':') {
		if($hi == '')
			return '';
		
		$hi = str_pad($hi,2,'0',STR_PAD_LEFT);
		return substr($hi,0,2).':'.substr($hi,2,2);
	}

	// nama hari di bahasa indonesia
	function xIndoDay($nhari,$full=true) {
		if($full) {
			switch($nhari) {
				case 0: return "Minggu";
				case 1: return "Senin";
				case 2: return "Selasa";
				case 3: return "Rabu";
				case 4: return "Kamis";
				case 5: return "Jumat";
				case 6: return "Sabtu";
			}
		}
		else {
			switch($nhari) {
				case 0: return "Min";
				case 1: return "Sen";
				case 2: return "Sel";
				case 3: return "Rab";
				case 4: return "Kam";
				case 5: return "Jum";
				case 6: return "Sab";
			}
		}
	}
	
	// nama bulan di bahasa indonesia
	function xIndoMonth($nbulan,$full=true) {
		if($full) {
			switch($nbulan) {
				case 1: return "Januari";
				case 2: return "Februari";
				case 3: return "Maret";
				case 4: return "April";
				case 5: return "Mei";
				case 6: return "Juni";
				case 7: return "Juli";
				case 8: return "Agustus";
				case 9: return "September";
				case 10: return "Oktober";
				case 11: return "November";
				case 12: return "Desember";
			}
		}
		else {
			switch($nbulan) {
				case 1: return "Jan";
				case 2: return "Feb";
				case 3: return "Mar";
				case 4: return "Apr";
				case 5: return "Mei";
				case 6: return "Jun";
				case 7: return "Jul";
				case 8: return "Agu";
				case 9: return "Sep";
				case 10: return "Okt";
				case 11: return "Nov";
				case 12: return "Des";
			}
		}
	}
	
	function xGetDayIndex($str) {
		if ($str == 'monday')
			return '1';
		elseif ($str == 'tuesday')
			return '2';
		elseif ($str == 'wednesday')
			return '3';
		elseif ($str == 'thursday')
			return '4';
		elseif ($str == 'friday')
			return '5';
		elseif ($str == 'saturday')
			return '6';
		elseif ($str == 'sunday')
			return '7';

		return false;
	}

	function xGetDayString($idx) {
		if ($idx == '1')
			return 'monday';
		elseif ($idx == '2')
			return 'tuesday';
		elseif ($idx == '3')
			return 'wednesday';
		elseif ($idx == '4')
			return 'thursday';
		elseif ($idx == '5')
			return 'friday';
		elseif ($idx == '6')
			return 'saturday';
		elseif ($idx == '7')
			return 'sunday';

		return false;
	}
	
	function xTimeLapse($time) {
		if (!$time)
			return false;
		
		$num_year = 31104000;
		$num_mon = 2592000;
		$num_day = 86400;
		$num_hour = 3600;
		$num_minute = 60;

		if ($time > $num_day) {
			$days = (int)($time / $num_day);
			$hours = (int) (($time % $num_day) / $num_hour);
			$minutes = (int) ((($time % $num_day) % $num_hour) / $num_minute);
			$date_ret = "{$days} " . lang('g_days');
			if ($hours)
				$date_ret .= " {$hours} ". lang('g_hours');
			else {
				$minutes = (int) (($time % $num_day) / $num_minute);
			}
			if ($minutes)
				$date_ret .= " {$minutes} ". lang('g_minutes');
				
			$date_ret = '<font color="#CC0000">' . $date_ret . '</font>';
		}
		elseif ($time > $num_hour && $time < $num_day)
			$date_ret = "<font color=\"#0000CC\">" . (int)($time / $num_hour) . ' ' . lang('g_hours') . ' ' . (int)(($time % $num_hour) / 60) . ' ' . lang('g_minutes')."</font>";
		else
			$date_ret = "<font color=\"#0000CC\">" . (int)($time / 60) . ' ' . lang('g_minutes')."</font>";

		return $date_ret;
		
	}
	
	function xTime2String($date, $time_zone=0, $format=false) {
		$ci = &get_instance();
		
		if (!$format) {
			$format = $ci->config->item('date_format3');
		}

		if (!is_numeric($date))
			return false;

		$num_year = 31104000;
		$num_mon = 2592000;
		$num_day = 86400;
		$num_hour = 3600;

		if ($format === 'short') {
			$time_temp = time() - $date;

			if ($time_temp > $num_year) {
				$years = (int)($time_temp / $num_year);
				$months = (int) (($time_temp % $num_year) / $num_mon);
				$date_ret = "{$years} " . lang('g_years') . "&nbsp;&nbsp;{$months} " . lang('g_months');
			}
			elseif ($time_temp > $num_mon) {
				$months = (int)($time_temp / $num_mon);
				$days = (int) (($time_temp % $num_mon) / $num_day);
				$date_ret = "{$months} " . lang('g_months');
				if ($days)
					$date_ret .= "&nbsp;&nbsp;{$days} " . lang('g_days');
			}
			elseif ($time_temp > $num_day && $time_temp < $num_mon) {
				$days = (int)($time_temp / $num_day);
				$hours = (int) (($time_temp % $num_day) / $num_hour);
				$date_ret = "{$days} " . lang('g_days');
				if ($hours)
					$date_ret .= "&nbsp;&nbsp;{$hours} ". lang('g_hours');
			}
			elseif ($time_temp > $num_hour && $time_temp < $num_day)
		    	$date_ret = "<font color=\"#CC0000\">" . (int)($time_temp / $num_hour) . ' ' . lang('g_hours') . ' ' . (int)(($time_temp % $num_hour) / 60) . ' ' . lang('g_minutes')."</font>";
		  	else
		    	$date_ret = "<font color=\"#CC0000\">" . (int)($time_temp / 60) . ' ' . lang('g_minutes')."</font>";

		    return $date_ret;
		}
		elseif ($format === 'constant1') {
			$cur_stime = $date + $time_zone - date("Z");
			if ( (int) (strftime("%Y", time())) == (int) (strftime("%Y", $cur_stime)) ) {
				if ( (int) (strftime("%Y%m%d", time())) == (int) (strftime("%Y%m%d", $cur_stime)) )
					$date_ret = $date?strftime("%I:%M %p", $cur_stime):"&nbsp;";
				else
					$date_ret = $date?strftime("%b %d", $cur_stime):"&nbsp;";
			}
			else {
				$date_ret = $date?strftime($config['date_format2'], $cur_stime):"&nbsp;";
			}				
		}
		else
			$date_ret = strftime($format, $date + $time_zone - date("Z"));
			
		return $date_ret;
	}
	
	function xNotification($message, $class='alert-success') {
		$ret = "
		<div class=\"alert $class\">
			<span class=\"close\" data-dismiss=\"alert\">&times;</span>
			$message
		</div>";
		return $ret;
	}
	
	###############################################################################

	function xSetFilterTable($ctl, &$field, $extra_style='', $extra_attr='') {
		$init_style = '';
		$init_attr = "onclick=\"setFilterTable('{$field['name']}:{$field['type']}')\"";

		$field['allow_filter'] = !isset($field['allow_filter'])?true:$field['allow_filter'];
		$field['sort'] = '';

		if (!empty($field['width']))
			$init_style .= "width:{$field['width']};";
		if (!empty($field['text-align']))
			$init_style .= "text-align:{$field['text-align']};";

		if ($field['allow_filter']!==false) {
			$f='';
			$s='';
			if (isset($_SESSION[G_SESSION][$ctl]['filter_sort'])) {
				list($f, $s) = explode(' ',$_SESSION[G_SESSION][$ctl]['filter_sort']);
				if ($field['name'] === $f) {
					if ($s === 'asc')
						$field['sort'] = "<img src='".base_assets()."images/up.gif' />";
					elseif ($s === 'desc')
						$field['sort'] = "<img src='".base_assets()."images/down.gif' />";
				}
			}

			$init_style .= "cursor:pointer;";
			$init_attr .= ' class="filtertable_header" ';
		}
		
		$style = "style=\"$init_style$extra_style\"";
		
		return $style . ' ' . $init_attr . ' ' . $extra_attr;
	}
	
	function xShowButtonMode($mode, $key=null) {
		$str = '';
		if ($mode === 'lst' || $mode === 'index' || $mode === 'daftar') {
			$str .= xGetButton('add');
			$str .= xGetButton('reset');
			return $str;
		}

		if ($mode === 'edit') {
			$str .= xGetButton('lst');
			return $str;
		}

		if ($mode === 'add') {
			$str .= xGetButton('lst');
			return $str;
		}

		if ($mode === 'detail') {
			$str .= xGetButton('edit', $key);
			$str .= xGetButton('add');
			$str .= xGetButton('delete', $key);
			$str .= xGetButton('lst');
			return $str;
		}

		if ($mode === 'save') {
			$str .= xGetButton('save');
			$str .= xGetButton('batal', $key);
			return $str;
		}
	}
	
	function xGetButton($id, $key=null) {
		$ci = &get_instance();
		
		if ($id === 'add' && in_array('c_create',$ci->auth) ) {
			return '<span class="btn btn-sm btn-primary" onclick="return goEdit()">' . xPlusIcon() . ' Tambah</span> ';
		}

		if ($id === 'edit' && in_array('c_update',$ci->auth) ) {
			return '<span class="btn btn-sm btn-default" onclick="return goEdit(\''.$key.'\')">' . xEditIcon() . ' Ubah</span> ';
		}

		if ($id === 'delete' && in_array('c_delete',$ci->auth) ) {
			return '<span class="btn btn-sm btn-danger" onclick="return goDelete(\''.$key.'\')">' . xRemoveIcon() . ' Hapus</span> ';
		}

		if ($id === 'lst' || $id === 'index') {
			return '<span class="btn btn-sm btn-default" onclick="return goList()">' . xListIcon() . ' Daftar</span> ';
		}

		if ($id === 'save') {
            return '<span class="btn btn-sm btn-primary" onclick="return goSave()">' . xSaveIcon() . ' Simpan</span> ';
        }

        if ($id === 'batal') {
            return '<span class="btn btn-sm btn-default" onclick="return goBatal(\''.$key.'\')">' . xBatalIcon() . ' Batal</span> ';
        }

        if ($id === 'reset') {
            return '<span class="btn btn-sm btn-default" onclick="return goReset()">' . xRefreshIcon() . ' Reset</span> ';
        }
        
        if ($id === 'cetak') {
            return '<span class="btn btn-sm" onclick="return goCetak(\''.$key.'\')">' . xPrintIcon() . ' Cetak</span> ';
        }
        
        if ($id === 'cetak-ijin') {
            return '<span type="button" class="btn btn-sm" onclick="return goCetakIjin(\''.$key.'\')">' . xPrintIcon() . ' Cetak Izin</span> ';
        }
        
        if ($id === 'tolak') {
            return '<span class="btn btn-sm" onclick="return goTolak(\''.$key.'\')"><i class="glyphicon glyphicon-thumbs-down"></i> Tolak</span> ';
        }
        
        if ($id === 'kembali') {
            return '<span class="btn btn-sm" onclick="return goKembali(\''.$key.'\')"><i class="glyphicon glyphicon-backward"></i> Kembalikan</span> ';
        }
        
        if ($id === 'terima') {
            return '<span class="btn btn-sm" onclick="return goTerima(\''.$key.'\')"><i class="glyphicon glyphicon-thumbs-up"></i> Terima</span> ';
        }
        
        if ($id === 'proses') {
            return '<span class="btn btn-sm" onclick="return goProses(\''.$key.'\')">' . xCheckIcon() . ' Proses</span> ';
        }
        
        if ($id === 'execute') {
            return '<span class="btn btn-sm" onclick="return goExecute(\''.$key.'\')"><i class="glyphicon glyphicon-tag"></i> Setujui</span> ';
        }

	}
	
	function xButton($type='', $label='', $action='') {
		if ($type == 'x_closepop') {
			return '<span class="btn btn-xs btn-danger" onclick="closePop()">' . xRemoveIcon() . '</span>';
		}
		elseif ($type == 'x_cancelpop') {
			return '<span class="btn btn-sm btn-default" onclick="closePop()">Batal</span>';
		}
	}
	
	function xEditList($url) {
		return '<a class="btn btn-xs btn-warning" href="'. $url .'"><span class="glyphicon glyphicon-pencil"></span></a>';
	}

	function xDeleteList($id, $label) {
		return "<a class=\"btn btn-xs btn-danger\" href=\"javascript:void()\" onclick=\"deleteList('$id', '$label');return false\"><span class=\"glyphicon glyphicon-remove\"></span></a>";
	}
	
	function xEncrypt($str, $key=false){
		if (!$key) {
			$key = 'E1O2F3S';
			if (phpversion() > '5.4')
				$key .= '213456798';
		}
		$encrypted = trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $str, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
		return $encrypted;
	}
	
	function xDecrypt($str, $key=false){
		if (!$key) {
			$key = 'E1O2F3S';
			if (phpversion() > '5.4')
				$key .= '213456798';
		}
		$decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($str), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
		return $decrypted;
	}

    function xPadNoAgenda($noagenda) {
		return str_pad((int)$noagenda,4,'0',STR_PAD_LEFT);
	}

    function xPadNoRegistrasi($noreg) {
		return str_pad((int)$noreg,5,'0',STR_PAD_LEFT);
	}
	
	function xRomanNumerals($num) {
		$n = intval($num);
		$res = '';

		$roman_numerals = array(
					'M'  => 1000,
					'CM' => 900,
					'D'  => 500,
					'CD' => 400,
					'C'  => 100,
					'XC' => 90,
					'L'  => 50,
					'XL' => 40,
					'X'  => 10,
					'IX' => 9,
					'V'  => 5,
					'IV' => 4,
					'I'  => 1);
	 
		foreach ($roman_numerals as $roman => $number) {
			$matches = intval($n / $number);
	 
			$res .= str_repeat($roman, $matches);
	 
			$n = $n % $number;
		}
	 
		return $res;
    }

	function xClosePop() {
		return '<span class="btn btn-xs btn-danger" onclick="closePop()">' . xRemoveIcon() . '</span>';
	}

	function xEncryptSafe($str) {
		$ci = &get_instance();
		$key = $ci->config->item('gate_key');

		return rawurlencode(xEncrypt($str, $key));
	}

	function xDecryptSafe($str) {
		$ci = &get_instance();
		$key = $ci->config->item('gate_key');
		
		return xDecrypt(rawurldecode($str), $key);
	}

	function xValidTimeDiffCurl($time, $max=3600) {
		# hanya boleh range 1 jam == 3600

		$now = time();
		if (abs($now - $time) > $max) 
			return false;
		
		return true;		
	}
	
	function xFilterPaging($pagination, $filter_string, $num_start, $num_end, $num_all) {
		$str = "<div class=\"clear\"></div>";
		$str .= "<div style=\"margin-top:3px\">";
		$str .= "<span class=\"pagination pagination-sm\" style=\"margin-top:0;margin-bottom:0px;padding-bottom:0px\">$pagination</span>";
		if ($filter_string) {
			$str .= "<span class=\"label label-danger\" style=\"font-size:14px\">Fiter: ON</span>";
		}
		if ($num_all) {
			$num_start = number_format($num_start);
			$num_end = number_format($num_end);
			$num_all = number_format($num_all);
			$str .= "<span style=\"float:right\">$num_start-$num_end dari $num_all</span>";
		}
			
		$str .= "</div><div class=\"clear\"></div>";
		
		return $str;
	}
	
	function xSaveIcon() {
		return '<i class="glyphicon glyphicon-floppy-disk"></i>';
	}
	function xBatalIcon() {
		return '<i class="glyphicon glyphicon-repeat"></i>';
	}
	function xRemoveIcon() {
		return '<i class="glyphicon glyphicon-remove"></i>';
	}
	function xRefreshIcon() {
		return '<i class="glyphicon glyphicon-refresh"></i>';
	}
	function xPrintIcon() {
		return '<i class="glyphicon glyphicon-print"></i>';
	}
	function xEditIcon() {
		return '<i class="glyphicon glyphicon-pencil"></i>';
	}
	function xListIcon() {
		return '<i class="glyphicon glyphicon-list"></i>';
	}	
	function xPlusIcon() {
		return '<i class="glyphicon glyphicon-plus"></i>';
	}	
	function xCheckIcon() {
		return '<i class="glyphicon glyphicon-ok"></i>';
	}	
	function xTrashIcon() {
		return '<i class="glyphicon glyphicon-trash"></i>';
	}	
	function xEnvelopeIcon() {
		return '<i class="glyphicon glyphicon-envelope"></i>';
	}	
	
	function xPreviewImages($isifile, $path, $idfile) {
		$isifile = pg_unescape_bytea($isifile);
		try {
			$img = new imagick();
			$img->setResolution(200,200);
			$img->readImageBlob($isifile);
			//$img->setImageResolution(100,100);
			$img->setImageBackgroundColor('white');
			$num_pages = $img->getNumberImages();
			for($i = 0;$i < $num_pages; $i++) {
				$img->setIteratorIndex($i);
				$img->setImageFormat('jpeg');

				$img->writeImage($path.$idfile.'-'.$i);

				if ($i == 0) {
					$img->setResolution(100,100);
					$img->resizeImage(200,200, imagick::FILTER_LANCZOS, 0.9, true);
					$img->setImageCompressionQuality(100);
					$img->writeImage($path.$idfile.'-x');
				}
			}
		}
		catch (Exception $e) {
			//var_dump($e->getMessage());die();
			return false;
		}
	}
	
	function xExpiredDisposisiStatus($tgl_expired='', $status) {
		if ($status > 2 || !$tgl_expired)
			return '';
		
		if ($tgl_expired < date('Y-m-d'))
			return '<span class="label label-danger blink-me" style="float:right" title="Melewati tenggat waktu!">!</span>';
				
		$ci = &get_instance();
		$warning_expired = $ci->config->item('disposisi_warning_expired');
		if (!$warning_expired)
			$warning_expired = 3;

		$date1 = strtotime(date('Y-m-d'));
		$date2 = strtotime($tgl_expired);
		$diff = xGetDiffDate($date1, $date2);

		if ($diff <= $warning_expired)
			return '<span class="label label-warning" style="float:right" title="Mendekati tenggat waktu">!</span>';
		
		return '';
	}
	
	function xFormatSizeUnits($bytes) {
		if ($bytes >= 1073741824)
			$bytes = number_format($bytes / 1073741824, 1) . ' GB';
		elseif ($bytes >= 1048576)
			$bytes = number_format($bytes / 1048576, 1) . ' MB';
		elseif ($bytes >= 1024)
			$bytes = number_format($bytes / 1024, 1) . ' KB';
		elseif ($bytes > 1)
			$bytes = $bytes . ' bytes';
		elseif ($bytes == 1)
			$bytes = $bytes . ' byte';
		else
			$bytes = '0 bytes';

		return $bytes;
	}
	
	function xSplitJabatan($txt, $only_name=false) {
		return $txt;
		$arr_penerima = explode(' - ', $txt);
		$ret = '';
		foreach ($arr_penerima as $k=>$str) {
			if (!$k) {
				$ret .= $str;
				if ($only_name)
					return $str;
			} else {
				$ret .= "<br/>$str";
			}
		}
		return $ret;
	}

	function xGetTemplate() {
		if ($_SESSION[G_SESSION]['tampilan'] == '2016')
			return '2016/';
		else
			return '2015/';
	}

	function xGetDefaultTemplate() {
		return '2015/';
	}

	function xGetGlobalView() {
		return './application/views/_global/';
	}

	function base_assets() {
		return base_url('assets/web') . '/';
	}

	function xShortenNama($str, $max_chars=10) {
		if (strlen($str) <= $max_chars)
			return $str;

		$strs = explode(' ', $str);
		$ret = '';

		for ($i=0;$i<10;$i++) {
			if (strlen($ret) >= $max_chars) {
				if (strlen($ret) - $max_chars <= 3)
					return $ret;

				$ret2 = '';
				for ($k=0;$k<$i-1;$k++) {
					$ret2 .= $strs[$k] . ' ';
				}
				if ($ret2=='') 
					return substr($strs[0],0,12);
				return $ret2;
			}
			if ($i==0 && strlen($strs[$i]) >= 10) {
				if (strlen($strs[$i])<=13)
					return $strs[$i];

				return substr($strs[$i], 0, 10);
			}

			$ret .= $strs[$i] . ' ';
		}

		return $ret;

	}

	function xLogActivity($param=false) {
		$ci = &get_instance();
		$ci->load->database();

		if (!$param) {
			return false;
		}

        $record = array();

        $user_id = SessionManagerWeb::getUserID();
        $username = SessionManagerWeb::getUserName();

        // user id
        if ($user_id) {
        	$record['user_id'] = $user_id;
        }
        else {
	        if ($param['user_id'])
	        	$record['user_id'] = $param['user_id'];
	    }
	    // username
	    if ($username) {
	    	$record['username'] = $username;
	    }
	    else {
	        if ($param['username'])
	        	$record['username'] = $param['username'];
	    }
	    // aksi
        if ($param['aksi'])
        	$record['aksi'] = $param['aksi'];
        // tipe
        if ($param['tipe'])
        	$record['tipe'] = $param['tipe'];

        // diakses lewat
		$record['useragent'] = substr($_SERVER['HTTP_USER_AGENT'],0,100);
        // ip
        $record['ip'] = $_SERVER['REMOTE_ADDR'];
        dbInsert('user_logs', $record);
        return true;
	}	

	/*
		param = url, message, phone		
	*/
	function xSendSMS($param=null){
		if ($param==null){
			return false;
		}
		$ci = &get_instance();

		$curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $param['url']);
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
            'userkey' => $ci->config->item('sms_userkey'),
            'passkey' => $ci->config->item('sms_passkey'),
            'nohp' => $param['phone'],
            'pesan' => $param['message']
        ));
        $results = json_decode(curl_exec($curlHandle), true);
        curl_close($curlHandle);
	}	


	/*
		Var Dump and die with pre
	*/
	function xDump($data){
		echo '<pre>';
		var_dump($data);
		die;
	}