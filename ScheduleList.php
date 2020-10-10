<?php

// ファイルから読み込み、行ごとの配列に格納
$Filedata_arr = file( 'Schedule.txt' );

// 行番号
$LineNo = 0;

// 行ごとの配列から、行ごとに処理
foreach ( $Filedata_arr as &$Line_data ){
	
	$Line_arr = [];
	
	$LineNo += 1;
	$Line_arr[] = $LineNo;
	
	// [TAB]区切りを配列に格納
	$Line_arr += explode( "\t" , $Line_data );
	//                  ↑仕様上の制限から[']はNG
	
	// 返信用配列に配列ごと保存
	$Send_arr[] = $Line_arr;
	
}

// 配列をJSONに変換して返す
print( json_encode( $Send_arr ) );

?>
