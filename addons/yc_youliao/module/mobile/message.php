<?php 
	set_time_limit(0); //解除超时限制	
	$start = time();
	//Util::deleteCache('sq_queue','sq_q');//===调试
	$cache = Util::getCache('sq_queue','sq_q');
	//echo("m1");//===调试
	if( empty( $cache ) || $cache['time'] < ( time()- 60 ) ){
		//echo("m2");//===调试
		Util::setCache('sq_queue','sq_q',array('time'=>time()));
		$queue = new queue;
		$queue -> queueMain($this);
		$url = Util::createModuleUrl('message',array('op'=>1));
		$end = time();
		sleep( 10 -($end - $start) );
		Util::deleteCache('sq_queue','sq_q'); // 这个必须放在休眠后执行
		Util::http_request($url,'', 1);
	}

	die;
	
	
	

	
