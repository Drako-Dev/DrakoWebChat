var last_msg = check_last_msg();

function set_scroll_max(){

	const messages = document.querySelector('.messages');

	var max_scroll_val = messages.scrollHeight;

	messages.scroll(0, max_scroll_val);

}

function check_last_msg(){

	var xmlHttp = new XMLHttpRequest();

	xmlHttp.open( "GET", "server.php", false);

	xmlHttp.send();

	return xmlHttp.responseText;

}

function update_msgs(){

	if(last_msg == check_last_msg()){

		//...

	}else{

		const messages = document.querySelector('.messages');

		var msg = document.createElement("div");

		msg.innerHTML = check_last_msg();

		messages.append(msg);

		last_msg = check_last_msg(); 

	}

}

function send_msg(){

	var msg = document.getElementById("msg").value;

	var xmlHttp = new XMLHttpRequest();

	xmlHttp.open( "GET", "server.php?send="+msg, false);

	document.getElementById("msg").value = "";

	xmlHttp.send();

}

setInterval(update_msgs, 250);

set_scroll_max();