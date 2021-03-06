
// スケジュール一覧

// 表示に必要なHTML出力
document.write('スケジュール ');
document.write('<input type="button" value="追加" onClick="location.href=\'ScheduleWrite.html?p=l\'">');
document.write('<span id="DelMsg"></span>');
document.write('<span id="SdlLstID"></span>');
document.write('<span id="ErrMsg"></span>');

// 起動時に実行
document.addEventListener('DOMContentLoaded', function(){
	
	// 一覧再表示
	ListRefresh();
	
} , false )

var DelListArr = []; // 削除対象リスト
var MaxCount = 0; // リスト件数

// 一覧再表示
function ListRefresh() {
	
	var Xhr = new XMLHttpRequest();
	
	Xhr.open( 'POST', 'ScheduleList.php' );
	Xhr.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	
	Xhr.send();
	
	Xhr.onreadystatechange = function() {
		
		if ( Xhr.status === 200 ) { // 200:成功
			if ( Xhr.readyState === 4 ) { // 4:通信完了
				
				var ColorControl = new ColorControl_Cls();
				var SdlLstStr = '<table border="1">';
				
				SdlLstStr += '<tr>';
				SdlLstStr += '<th></th>'  ;
				SdlLstStr += '<th>日付</th>'  ;
				SdlLstStr += '<th>内容</th>'  ;
				SdlLstStr += '<th>背景色</th>';
				SdlLstStr += '<th><input type="button" value="削除" onClick="Sakujyo()"></th>'  ;
				SdlLstStr += '</tr>';
				
				for( Linedata_arr of JSON.parse( Xhr.responseText ) ) {
					
					SdlLstStr += '<tr>';
					SdlLstStr += '<th><input type="button" value="修正" onClick="location.href=\'ScheduleWrite.html?p=l&l=' + Linedata_arr[0] + '\'"></th>' ;
					SdlLstStr += '<td>' + Linedata_arr[1] + '</td>';
					SdlLstStr += '<td>' + Linedata_arr[2] + '</td>';
					SdlLstStr += '<td bgcolor="' + ColorControl.Color2RGB( Linedata_arr[3] , 'Wrk_Color2RGB_CanvasID' ) + '">' + Linedata_arr[3] + '</td>';
					//SdlLstStr += '<td>' + Linedata_arr[3] + '</td>';
					SdlLstStr += '<th><input type="checkbox" id="delcbox' + Linedata_arr[0] + '"></th>'  ;
					SdlLstStr += '</tr>';
					
					MaxCount = Linedata_arr[0];
				}
				
				SdlLstStr += '</table>';
				
				document.getElementById('SdlLstID').innerHTML = SdlLstStr ;
				
			}
		} else {
			document.getElementById('ErrMsg').innerHTML = 'readyState=' + Xhr.readyState + ' status=' + Xhr.status ;
		}
		
	}
}

// 削除
function Sakujyo() {
	
	DelListArr = [];
	
	for( DelIdx = 1 ; DelIdx <= MaxCount ; DelIdx++ ){
		
		if( document.getElementById("delcbox" + DelIdx).checked == true ){
			DelListArr.push( DelIdx );
		}
		
	}
	
	if( DelListArr.length  == 0 ){
		var MsgStr = '削除対象を選択してください。';
	} else {
		var MsgStr = DelListArr.length + '件削除します。'
		                               + '<input type="button" value="削除実行" onClick="SakuJikko()">'
		                               + '<input type="button" value="削除中止" onClick="SakuCancel()">' ;
	}
	document.getElementById('DelMsg').innerHTML = MsgStr;
	
}

// 削除実行
function SakuJikko() {
	
	var Xhr = new XMLHttpRequest();
	
	Xhr.open( 'POST', 'ScheduleWrite.php' );
	Xhr.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
	
	Xhr.send( 'dellist=' + JSON.stringify(DelListArr) );
	
	Xhr.onreadystatechange = function() {
		
		if ( Xhr.status === 200 ) { // 200:成功
			if ( Xhr.readyState === 4 ) { // 4:通信完了
				
				document.getElementById('DelMsg').innerHTML = '';
				
				// 一覧再表示
				ListRefresh();
				
			}
		} else {
			document.getElementById('ErrMsg').innerHTML = 'readyState=' + Xhr.readyState + ' status=' + Xhr.status ;
		}
		
	}
	
}

// 削除中止
function SakuCancel() {
	
	document.getElementById('DelMsg').innerHTML = '';
	
	// 一覧再表示
	ListRefresh();
	
}


