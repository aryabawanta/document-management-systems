<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Cron extends WEB_Controller {
		protected $ispublic = true;

		public function sendNotifications(){
			die('fitur sedang dimatikan');
			$this->load->model("Notification_model");
			$this->load->model("Application_model");

			$notifications = $this->Notification_model->filter("where status ='".Notification_model::STATUS_NEW."'")->limit_offset("limit 10 offset 0")->getAll();

			$userkey = 't7og6vhhk4elrsr9gg88';
			$passkey = '4j3y2hp99xz5np1vod3l';
			$url = 'http://codelogic.zenziva.co.id/api/sendsms/';
			foreach ($notifications as $notification) {
				$destination = $notification['whatsapp'];
				// $destination = "6285792995463";

				// set message
				$application_name = '';
				// if (!$notification['is_url']){
				// 	$application_name = '*Aplikasi '.$this->Application_model->column("name")->filter("where id='".$notification['application_id']."'")->getOne()." :*\n\n";
				// }
				$message = $application_name.$notification['message']; 

				$curlHandle = curl_init();
				curl_setopt($curlHandle, CURLOPT_URL, $url);
				curl_setopt($curlHandle, CURLOPT_HEADER, 0);
				curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
				curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
				curl_setopt($curlHandle, CURLOPT_POST, 1);
				curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
				    'userkey' => $userkey,
				    'passkey' => $passkey,
				    'nohp' => $destination,
				    'pesan' => $message
				));
				$results = json_decode(curl_exec($curlHandle), true);
				curl_close($curlHandle);
				if ($results['status']=='1'){
					$record = array();
					$record['status'] = Notification_model::STATUS_QUEUED;
					$record['sent_at'] = Util::timeNow();
					$this->Notification_model->filter("id=".$notification['id'])->update($record);
				}
			}
		}

		// get staff yang belum laporan harian
		public function staffNotReported(){
			$db_eoffice = $this->load->database('eoffice', true);

			$this->load->model("Position_model");
			$this->load->model("User_Position_model");
			$this->load->model("User_model");
			$this->load->model("Notification_model");

			$date = date('Y-m-d 00:00:00', strtotime("-1 days"));
			// weekend
			if (date('N', strtotime($date)) >= 6){
				die('Kemarin Weekend BROOOOO');
			}

			echo 'Sudah Laporan :';

			$chief_positions = $this->Position_model->filter("where is_chief=1")->getAll();
			foreach ($chief_positions as $key => $value) {
				$recievers = Util::toMap($this->User_Position_model->filter("where position_id={$value['id']}")->order("order by id")->getAll(), 'user_id', 'user_id');	

				$is_atasan = false;
				unset($recievers[null]);
				if (empty($recievers)){

					$recievers = Util::toMap($this->User_Position_model->filter("where position_id={$value['superior_position_id']}")->order("order by id")->getAll(), 'user_id', 'user_id');

					$is_atasan = true;

					unset($recievers[null]);
					if (empty($recievers)){
						continue;	
					}
				}
				

				$staffs = Util::toMap($this->Position_model->column('up.user_id')
												->table("positions p")
												->join("left join user_position up on up.position_id=p.id")
												->filter("where p.superior_position_id={$value['id']}")->getAll(), 'user_id', 'user_id');
				unset($staffs[null]);
				if (empty($staffs)){
					continue;
				}

				/* Notification */
					$notification = array();
					$notification['application_id'] = '-';
					$notification['status'] = Notification_model::STATUS_NEW;
					
					/* MESSAGE */
						$message='';
						foreach ($staffs as $user_id) {
							$sql = "select * from posts p 
										left join users u on u.id=p.user_id 
										left join daily_reports d on d.post_id=p.id
										where 
										p.category_id=5 and u.username='{$user_id}}' 
										and d.date='{$date}'";
							if (!dbGetOne($sql, $db_eoffice)){
								$name = $this->User_model->column("name")->filter("where id='$user_id'")->getOne();
								$message  .="- $name\n";
							} else {
								$name = $this->User_model->column("name")->filter("where id='$user_id'")->getOne();
								echo "\n- ".$name;
							}
						}
						$message .="\nSegera koordinasikan dengan staff anda. Terima Kasih.";
					/* END MESSAGE */
					/* RECIEVER */
						foreach ($recievers as $key => $user_id) {
							$user = $this->User_model->filter("where id='$user_id'")->getBy();
							if ($is_atasan) {
								$notification['message'] = "[Dikirim ke Anda karena Posisi ".$value['name']." KOSONG]\n";
							} else {
								$notification['message'] = "";
							}
							$notification['message'] .= "Dear Sdr. {$user['name']},\nBerikut rangkuman staff yang belum laporan pada hari kemarin :\n\n".$message;
							echo '<pre>'.$notification['message'];
							$notification['whatsapp'] = $user['whatsapp'];
							$this->Notification_model->create($notification, FALSE, FALSE);
						}
					/* END RECIEVER */
				/* End Notification */
			}
		}

		/* COMMENTED 
			public function sendNotificationsWA(){
				$this->load->model("Notification_model");
				$this->load->model("Application_model");

				$notifications = $this->Notification_model->filter("where status ='".Notification_model::STATUS_NEW."'")->getAll();

				$my_apikey = "JWNGL8DYNCJM3LW9C4R1"; 
				foreach ($notifications as $notification) {
					$destination = $notification['whatsapp'];
					
					// set message
					$application_name = '';
					if (!$notification['is_url']){
						$application_name = '*Aplikasi '.$this->Application_model->column("name")->filter("where id='".$notification['application_id']."'")->getOne()." :*\n\n";
					}
					$message = $application_name.$notification['message']; 

					$api_url = "http://panel.apiwha.com/send_message.php"; 
					$api_url .= "?apikey=". urlencode ($my_apikey); 
					$api_url .= "&number=". urlencode ($destination); 
					$api_url .= "&text=". urlencode ($message); 
					$my_result_object = json_decode(file_get_contents($api_url, false)); 
					echo '<pre>';
					echo "<br>Result: ". $my_result_object->success; 
					echo "<br>Description: ". $my_result_object->description; 
					echo "<br>Code: ". $my_result_object->result_code; 
					echo '</pre>';
					if ($my_result_object->success){
						$record = array();
						$record['status'] = Notification_model::STATUS_QUEUED;
						$record['sent_at'] = Util::timeNow();
						$this->Notification_model->filter("id=".$notification['id'])->update($record);
					}
				}
			}
		*/
    }
?>