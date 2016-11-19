function setCookie(key, value) 
{
	var expires = new Date();
	expires.setTime(expires.getTime() + (1 * 24 * 60 * 60 * 1000));
	document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
}

function getCookie(key) 
{
	var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
	return keyValue ? keyValue[2] : null;
}

function ShowErrorModal(title, msg) 
{
	$('#errorModal').modal();
	$('#errorModalTitle').text(title);
	$('#errorModalBody').text(msg);
	return false;
}