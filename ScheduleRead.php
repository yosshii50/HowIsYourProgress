<?php

// 指定された行番号を取得
$lineno = filter_input( INPUT_POST , 'lineno' );

// デバッグ用ログファイル保存
// file_put_contents( 'ScheduleRead.Log' , $lineno );

// 行番号が指定されていない場合、新規作成として処理
if( $lineno == 'null' ){
	exit( json_encode( array( '','','' ) ) );
}

// ファイルから読み込み、行ごとの配列に格納
$Filedata_arr = file( 'Schedule.txt' );

// 処理中の行番号
$LineNo = 0;

// 行ごとの配列から、行ごとに処理
foreach ( $Filedata_arr as &$Line_data ){
	
	// 処理中の行番号を加算していく
	$LineNo += 1;
	
	// [TAB]区切りを配列に格納
	$Line_arr = explode( "\t" , $Line_data );
	//                   ↑仕様上の制限から[']はNG
	
	if( $LineNo == $lineno ){
		// 処理中の行番号と指定された行番号が一致したらループを抜ける
		break;
	}
	
}

// 配列をJSONに変換して返す
exit( json_encode( $Line_arr ) );

?>
