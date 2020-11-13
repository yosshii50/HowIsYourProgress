
// 表示に必要なHTML出力
document.write('<span id="TestMsg"></span>');

// 起動時に実行
document.addEventListener('DOMContentLoaded', function(){
	
	AutoExec();
	
} , false )

function AutoExec() {
	
	var Xhr = new XMLHttpRequest();
	
	Xhr.open( 'POST', 'test.php' );
	Xhr.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	
	Xhr.send();
	
	Xhr.onreadystatechange = function() {
		
		if ( Xhr.status === 200 ) { // 200:成功
			if ( Xhr.readyState === 4 ) { // 4:通信完了
				
				var SdlLstStr = Xhr.responseText;
				
				document.getElementById('TestMsg').innerHTML = SdlLstStr ;
				
				init();
				
			}
		} else {
			document.getElementById('TestMsg').innerHTML = 'readyState=' + Xhr.readyState + ' status=' + Xhr.status ;
		}
		
	}
}

