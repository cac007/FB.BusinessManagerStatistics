<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>FbStat BM</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="description" content="TreeMenu creates tree menus out of UL/LI tags that pop open when clicked.">
<meta name="author" content="Mack Pexton">
<link rel="stylesheet" href="acmebase.css" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/gif" href="icon.gif" />

<style type="text/css">
/* Menu container */
.menu	{
	width:100%;
	height:175px;
	/*border:solid #FF9900 1px;*/
	padding:10px 5px 10px 5px;
	}

/* Menu styles */
.menu ul
	{
	margin:0px;
	padding:0px;
	text-decoration:none;
	}
.menu li
	{
	margin:0px 0px 0px 5px;
	padding:0px;
	list-style-type:none;
	text-align:left;
	font-family:Arial,Helvetica,sans-serif;
	font-size:13px;
	font-weight:normal;
	}

/* Submenu styles */
.menu ul ul 
	{
	background-color:#F6F6F6;
	}
.menu li li
	{
	margin:0px 0px 0px 16px;
	}

/* Symbol styles */
.menu .symbol-item,
.menu .symbol-open,
.menu .symbol-close
	{
	float:left;
	width:16px;
	height:1em;
	background-position:left center;
	background-repeat:no-repeat;
	}
/*.menu .symbol-item  { background-image:url(icons/page.png); }*/
.menu .symbol-close { background-image:url(icons/plus.png);}
.menu .symbol-open  { background-image:url(icons/minus.png); }
.menu .symbol-item.last  { }
.menu .symbol-close.last { }
.menu .symbol-open.last  { }

/* Menu line styles */
.menu li.item  { font-weight:normal; }
.menu li.close { font-weight:normal; }
.menu li.open  { font-weight:bold; }
.menu li.item.last  { }
.menu li.close.last { }
.menu li.open.last  { }

a.go:link, a.go:visited, a.go:active
        {
        display:block;
        height:26px;
        width:100px;
        background-color:#FFFFFF;
        color:#333333;
        font-family:Arial,Helvetica,sans-serif;
        font-size:12px;
        font-weight:bold;
        text-align:right;
        text-decoration:none;
        line-height:26px;
        padding-right:30px;
        background-image:url(go.gif);
        background-position:right;
        background-repeat:no-repeat;
        }
a.go:hover
        {
        text-decoration:none;
        color:#488400;
        }
#example3 { width:40%; background-color:#F9F9F9; padding:0px; margin-left:24px; }
#example3 li { list-style:none; margin:1px 0px; }
#example3 li a { display:block; height:16px; padding:0px 4px; background-color:#EEEEFF; }
#example3 li ul { margin:0px; padding:0px; }
#example3 li ul li a { background-color:#F9F9F9; border-bottom: solid #ECECEC 1px; padding-left:20px; }
</style>

<script src="TreeMenu.js" type="text/javascript"></script>
</head>

<body>
<button onclick="TreeMenu.show_all(document.getElementById('example1'))">Show All</button>
<button onclick="TreeMenu.hide_all(document.getElementById('example1'))">Hide All</button>
<button onclick="TreeMenu.reset(document.getElementById('example1'));location.reload();">Reset</button>
<button onclick="window.location='?day=yesterday'">Вчера</button>
<a href="https://vk.com/newuim"  target="_blank">(c) Ins</a>
<div id="loasttoday">Потрачено сегодня: </div>
<div class="menu" style="float:left;">
<ul id="example1">

<?php
$limit='';
$day="";
if ($_GET["limit"] == null){$limit='&limit=25';} // показываем последние 25 рекламных кабинетов добавленных в бм
else{$limit='&limit='.$_GET["limit"];} // site.ru/?limit=71 показываем последние 71 рекламных кабинетов добавленных в бм
if ($_GET["day"] == null){$day='today';}else{$day=$_GET["day"];}

$loasttoday;
$biz_id=""; // ид бма РЕДАКТИРУЕМ
$access_token=""; // access_token смотрящего акка РЕДАКТИРУЕМ

$url = 'https://graph.facebook.com/v4.0/'.$biz_id.'/client_ad_accounts?fields=insights.date_preset('.$day.'),ads.date_preset('.$day.').time_increment('.$day.').limit(500){insights.limit(500).date_preset('.$day.'){results,relevance_score,cpm,inline_link_click_ctr},adlabels,created_time,recommendations,updated_time,ad_review_feedback,bid_info,configured_status,delivery_info,status,effective_status,adcreatives.limit(500){place_page_set_id,object_story_spec{instagram_actor_id,link_data{link},page_id},image_crops,image_url,status,thumbnail_url},result,cost_per_lead_fb,name,clicks,spent,cost_per,reach,link_ctr},date{'.$day.'},funding_source_details,business{name},adrules_library{name},transactions,current_unbilled_spend,adspaymentcycle,spend_cap,amount_spent,age,disable_reason,account_status,balance,all_payment_methods{pm_credit_card{account_id,credential_id,display_string,exp_month,exp_year}},currency,timezone_name,created_time,name'.$limit.'&locale=ru_RU&access_token='.$access_token;

$proxy = ''; // proxy_ip:proxy_port РЕДАКТИРУЕМ
$proxyauth = ''; // proxy_login:proxy_pass	РЕДАКТИРУЕМ

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
$curl_scraped_page = curl_exec($ch);
curl_close($ch);
$json = json_decode($curl_scraped_page,true);


if($json['data']==null)
{
	 $js = json_encode($json, JSON_PRETTY_PRINT);
	echo '<pre>' . $js . '</pre>';
	return;
}

foreach($json['data'] as $item) {
	$payall=0;
	$payalldes="";;
	if($item['transactions']['data']!=null)
	{
		foreach($item['transactions']['data'] as $item2) {
			if($item2['status']=='completed')
			{
				$payall=$item2['amount']['total_amount_in_hundredths']+$payall;	
				if($payalldes==""){$payalldes=intval($item2['amount']['total_amount_in_hundredths'])/100;}else
					{$payalldes=$payalldes.';'.intval($item2['amount']['total_amount_in_hundredths'])/100;}	
			}
			
		}
		$payall=intval($payall)/100;
	}
	
	$account_status=$item['account_status'];
	switch ($account_status)
            {
                case "1":
                    $account_status = "Ok";
                    break;
                case "2":
                    $account_status = "DISABLED";
                    break;
                case "3":
                    $account_status = "UNSETTLED";
                    break;
                case "7":
                    $account_status = "PENDING_RISK_REVIEW";
                    break;
                case "8":
                    $account_status = "PENDING_SETTLEMENT";
                    break;
                case "9":
                    $account_status = "IN_GRACE_PERIOD";
                    break;
                case "100":
                    $account_status = "PENDING_CLOSURE";
                    break;
                case "101":
                    $account_status = "CLOSED";
                    break;
                case "201":
                    $account_status = "ANY_ACTIVE";
                    break;
                case "202":
                    $account_status = "ANY_CLOSED";
                    break;
            }
		$disable_reason=$item['disable_reason'];
		switch ($disable_reason)
            {
                case "0":
                    $disable_reason = "NONE";
                    break;
                case "1":
                    $disable_reason = "ADS_INTEGRITY_POLICY";
                    break;
                case "2":
                    $disable_reason = "ADS_IP_REVIEW";
                    break;
                case "3":
                    $disable_reason = "RISK_PAYMENT";
                    break;
                case "4":
                    $disable_reason = "GRAY_ACCOUNT_SHUT_DOWN";
                    break;
                case "5":
                    $disable_reason = "ADS_AFC_REVIEW";
                    break;
                case "6":
                    $disable_reason = "BUSINESS_INTEGRITY_RAR";
                    break;
                case "7":
                    $disable_reason = "PERMANENT_CLOSE";
                    break;
                case "8":
                    $disable_reason = "UNUSED_RESELLER_ACCOUNT";
                    break;
                case "9":
                    $disable_reason = "UNUSED_ACCOUNT";
                    break;
               
            }		
			$paytype=$item['funding_source_details']['type'];
			if($paytype=='1')$paytype="CARD";
			
			$loasttoday=$loasttoday+$item['insights']['data'][0]['spend'];
			
			$color='';
			if ($disable_reason!='NONE'){$color= 'background-color: #ff0000;';}
			
			$pravilacount=0;			$pravilades="";
			if($item['adrules_library']!=null){
			foreach($item['adrules_library']['data'] as $adrules_library)
			{
				if($pravilacount==0){$pravilades=$adrules_library['name'];}else{$pravilades=$pravilades.'&#013;'.$adrules_library['name'];}								
				$pravilacount++;
			}}
			
echo '<li>
	<div style="'.$color.'">
		<span style="display: inline-block;text-align: left;width: 150px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="business name:'.$item['business']['name'].'&#013;'.$item['name'].'&#013;created_time:'.$item['created_time'].'">'.$item['name'].'</span>
		
		<span style="display: inline-block;text-align: center;width: 100px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="'.$account_status.'">'.$account_status.'</span>
		
		<span style="display: inline-block;text-align: center;width: 150px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="'.$disable_reason.'">'.$disable_reason.'</span>
		
		<!-- <span style="display: inline-block;text-align: center;width: 100px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="">'.$paytype.''.str_replace('Mastercard','',$item['funding_source_details']['display_string']).'</span>--!>
		
		<span style="display: inline-block;text-align: center;width: 100px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="">'.str_replace('*','<br>*',$item['all_payment_methods']['pm_credit_card']['data'][0]['display_string']).'</span>

				
		<span style="display: inline-block;text-align: center;width: 100px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="Предстоит к списанию">'.$item['current_unbilled_spend']['amount'].'<br>спишется</span>
		
		<span style="display: inline-block;text-align: center;width: 100px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="списано '.$payalldes.'">'.$payall.'<br>'.$payalldes.'</span>	
		
		<span style="display: inline-block;text-align: center;width: 100px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="">'.$item['insights']['data'][0]['spend'].'<br>затраты сегодня</span>
		
		<span style="display: inline-block;text-align: center;width: 50px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="Текущий порог списания">'.($item['adspaymentcycle']['data'][0]['threshold_amount']/100).'<br>порог</span>
		
		<span style="display: inline-block;text-align: center;width: 50px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="'.$item['currency'].'">'.$item['currency'].'</span>	
		
		<span style="display: inline-block;text-align: center;width: 100px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="'.$item['timezone_name'].'">'.$item['timezone_name'].'</span>
		
		<!-- <span style="display: inline-block;text-align: center;width: 200px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="'.$item['created_time'].'">'.$item['created_time'].'</span>--!>
		
		<span style="display: inline-block;text-align: center;width: 200px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="'.$item['id'].'">'.str_replace('act_','',$item['id']).'</span>
		
		<span style="display: inline-block;text-align: center;width: 200px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="'.$pravilades.'">'.$pravilacount.'<br>правил</span>
		
		
	</div>
  <ul>';
   if($item['ads']['data']!=NULL) {
  foreach($item['ads']['data'] as $ads) {
	 
	 $oneleadrice=(round(($ads['cost_per']/100),2));
	 $leadrice=(round(($ads['spent']/100),2));
	 $leadcount=$ads['result'];
	 if($leadcount=='0'&&$leadrice!='0'){$oneleadrice="‎-".(round(($ads['spent']/100),2));}
	 
	  $leadtype=str_replace('actions:like','Like',$ads['insights']['data'][0]['results'][0]['indicator']);
	  $leadtype=str_replace('actions:offsite_conversion.fb_pixel_lead','Lead',$leadtype);
	  $leadtype=str_replace('actions:link_click','LinkClick',$leadtype);
	  $array_notvalidads=$ads['ad_review_feedback']['global'];	  
		$key_notvalidads='';
		$notvalidads='';
		$color2='';	
		if((is_array($array_notvalidads))=='1'){$color2= 'background:#ffcccc;';$key_notvalidads=key($array_notvalidads);$notvalidads=$array_notvalidads[$key_notvalidads];}
	  echo'
	  <li>
	  <div style='.$color2.'>
	  <img src="'.$ads['adcreatives']['data'][0]['thumbnail_url'].'"   alt="image" onclick = "openImageWindow(\''.$ads['adcreatives']['data'][0]['image_url'].'\');">
	  
</span>
	  <span style="height: 32px;display: inline-block;text-align: center;width: 100px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="name">'.$ads['name'].'</span>
	  <span style="height: 32px;display: inline-block;text-align: center;width: 100px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="status">'.$ads['status'].'<br>'.$ads['delivery_info']['status'].'</span>
	  <span style="height: 32px;display: inline-block;text-align: center;width: 100px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="Показы">'.$ads['reach'].'<br>показы</span>
	  <span style="height: 32px;display: inline-block;text-align: center;width: 100px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="clicks">'.$ads['clicks'].'<br>клики</span>
	  <span style="height: 32px;display: inline-block;text-align: center;width: 100px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="'.($ads['cost_per']/100).'">'.$oneleadrice.'<br>цена лида</span>
	  <span style="height: 32px;display: inline-block;text-align: center;width: 100px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="Лиды">'.$ads['result'].'<br>'.$leadtype.'</span>
	  <span style="height: 32px;display: inline-block;text-align: center;width: 100px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="'.($ads['spent']/100).'">'.$leadrice.'<br>затраты</span>
	   <span style="height: 32px;display: inline-block;text-align: center;width: 100px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="'.$ads['insights']['data'][0]['cpm'].'">'.round($ads['insights']['data'][0]['cpm'],2).'<br>cpm</span>
	  <span style="height: 32px;display: inline-block;text-align: center;width: 100px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="'.$ads['insights']['data'][0]['ctr'].'">'.round($ads['insights']['data'][0]['inline_link_click_ctr'],2).'<br>ctr</span>
	  
	  <span style="height: 32px;display: inline-block;text-align: center;width: 100px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="'.$ads['recommendations'][0]['title'].'&#013;'.$ads['recommendations'][0]['message'].'">'.$ads['recommendations'][0]['title'].'</span>
	  
	   <span style="height: 32px;display: inline-block;text-align: center;width: 100px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="'.$notvalidads.'">'.$key_notvalidads.'</span>
	   


	    <span style="height: 32px;display: inline-block;text-align: center;width: 200px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="'.$ads['adcreatives']['data'][0]['object_story_spec']['link_data']['link'].'">'.$ads['adcreatives']['data'][0]['object_story_spec']['link_data']['link'].'<br>'.$ads['adcreatives']['data'][0]['object_story_spec']['page_id'].'</span>
		
		
	    <span style="height: 32px;display: inline-block;text-align: center;width: 200px;white-space: nowrap;overflow: hidden;padding: 5px;text-overflow: ellipsis;" title="id">'.$ads['id'].'<br>ID</span>
	   
	   
	   </div>
	  </li>'
   ;}}
  echo'</ul>
</li>
<hr>';
}
echo '<script>document.getElementById("loasttoday").innerHTML = "Затраты сегодня: '.$loasttoday.'";</script>';
?>
<script type="text/javascript">
  function openImageWindow(src) {
    var image = new Image();
    image.src = src;
    var width = image.width;
    var height = image.height;
    window.open(src,"Image","width=" + width + ",height=" + height);
  }
</script>
</ul>
<script type="text/javascript">make_tree_menu('example1');</script>
</div>






</body>
</html>
