
// 元号変換

// 表示に必要なHTML出力
document.write('<select id="GengouHenkanComboBox" onchange="ComboBoxChange1();"/>');
document.write('<input type="text" id="Text1"size="5" onkeyup="TextChange1();"> ');
document.write('<span id="ViewString"></span>');

// 起動時に実行
document.addEventListener('DOMContentLoaded', function(){
	
	// 内容初期化
	ComboBoxInit1();
	
	// 内容変更時
	ComboBoxChange1();
	TextChange1();
	
} , false )

// 内容初期化
function ComboBoxInit1() {
	
	var TmpCmbBox = document.getElementById("GengouHenkanComboBox");
	
	// 固定値セット
	AddComboBoxItemStr( TmpCmbBox , 'H30' );
	AddComboBoxItemStr( TmpCmbBox , 'H31' );
	AddComboBoxItemStr( TmpCmbBox , 'H32' );
	AddComboBoxItemStr( TmpCmbBox , 'R1'  );
	AddComboBoxItemStr( TmpCmbBox , 'R2'  );
	AddComboBoxItemStr( TmpCmbBox , 'R3'  );
	
	// 変動値セット
	var BaseNen = 2019; // 現元号の基準年
	var ima = new Date(); // 今日の日付
	var YearST = ima.getFullYear() - BaseNen - 1; // ２年前の令和年取得
	var YearED = YearST + 5; // ５年分
	
	for( var YearWK = YearST ; YearWK < YearED ; YearWK++ ) {
		
		// 令和3年までは初期値で入れているので、令和3年以降のみ追加
		if( YearWK > 3 ) {
			AddComboBoxItemStr( TmpCmbBox , 'R' + YearWK );
		}
		
		// 今年を初期値に設定
		if( YearWK == ima.getFullYear() - BaseNen + 1 ) {
			
			var SetIdx = GetComboBoxValue2Index( TmpCmbBox , 'R' + YearWK );
			TmpCmbBox.options[SetIdx].selected = true
			
		}
	}
	
}

// コンボボックスの value から index 番号を取得
function GetComboBoxValue2Index( SetCmbBox , ItemValue ) {
	for( var WrkIdx = 0 ; WrkIdx < SetCmbBox.options.length ; WrkIdx++ ) {
		if( SetCmbBox.options[ WrkIdx ].value === ItemValue ) {
			return WrkIdx;
		}
	}
	return -1;
}

// コンボボックスに項目追加
function AddComboBoxItemStr( SetCmbBox , SetItemStr , IsSelected ) {
	
	var TmpOption = document.createElement("option");
	TmpOption.text  = SetItemStr;
	TmpOption.value = SetItemStr;
	SetCmbBox.appendChild( TmpOption );
	
	if( IsSelected == true ) {
		TmpOption.selected = true;
	}
	
}

// コンボボックス変更時
function ComboBoxChange1() {
	
	// 変更値取得
	var WrkString = document.getElementById("GengouHenkanComboBox").value;
	
	// テキストボックスに上書き
	document.getElementById("Text1").value = WrkString;
	
	// 文字内容変更時
	TextChange1();
	
}

// 文字内容変更時
function TextChange1() {
	
//	var WarekiList = [ [ 'M' , 1868 , '明治' ]
//	                 , [ 'T' , 1912 , '大正' ]
//	                 , [ 'S' , 1926 , '昭和' ]
	var WarekiList = [ [ 'H' , 1989 , '平成' ]
	                 , [ 'R' , 2019 , '令和' ]
	                 ];
	
	// 文字取得
	var WrkStr = document.getElementById("Text1").value;
	
	// 和暦検索
	var WrkNen = 0;
	var WrkIdx = 0;
	for( WrkIdx = 0 ; WrkIdx < WarekiList.length  ; WrkIdx++ ) {
		// 先頭文字から判別
		if( WrkStr.slice( 0 , 1 ).toUpperCase() == WarekiList[ WrkIdx ][0] ){
			WrkNen = Number( WrkStr.slice( 1 ) ) + WarekiList[ WrkIdx ][1] - 1;
			break;
		}
	}
	// 一致しない場合
	if( WrkIdx == WarekiList.length ) {
		// 西暦入力として処理
		WrkNen = Number( WrkStr );
	}
	
	// 和暦ごとの表示内容生成
	var SetStr = '';
	for( WrkIdx = 0 ; WrkIdx < WarekiList.length  ; WrkIdx++ ) {
		if( WrkNen >=  WarekiList[ WrkIdx ][1] ) {
			SetStr =  WarekiList[ WrkIdx ][2] + ( WrkNen -  WarekiList[ WrkIdx ][1] + 1 ) + '年 ' + SetStr;
		}
	}
	
	// 結果表示
	document.getElementById("ViewString").innerHTML = WrkNen + '年 ' + SetStr;
	
}

