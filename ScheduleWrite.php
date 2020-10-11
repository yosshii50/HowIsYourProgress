<?php

// POSTデータ取得
$date      = filter_input( INPUT_POST , 'date'      );
$data      = filter_input( INPUT_POST , 'data'      );
$backcolor = filter_input( INPUT_POST , 'backcolor' );
$lineno    = filter_input( INPUT_POST , 'lineno'    );

// [git clone] したら [sudo chown www-data:www-data Schedule.txt] しないとけない、エラー処理が必要
$filename_org = 'Schedule.txt';
$filename_old = 'Schedule-old.txt';

// 古いバックアップファイルを削除
unlink( $filename_old );

// ファイル名変更
rename( $filename_org , $filename_old );

// 対象行のデータ生成
$crtdata .= $date      . "\t";
$crtdata .= $data      . "\t";
$crtdata .= $backcolor . "\t";
$crtdata .= "\n";
//          ↑           ↑  特殊文字なので[']ではNG

// 全ファイル内容読み込み
$filealldata = file_get_contents( $filename_old );

if( $lineno == 'null' ){
	
	// 追加の場合
	$filealldata .= $crtdata;
	
} else {
	
	// 修正の場合
	
	$LineNo = 1;
	$StartPos = 0;
	
//	$DebugStr = $filealldata . "\nMax:" . strlen( $filealldata ) . "\n" ;
	
	while( $StartPos < strlen( $filealldata ) ) {
//		$DebugStr .= $StartPos . "\n";
		
		if( $LineNo == $lineno ){
			// 処理中の行番号と指定された行番号が一致した場合
			
			$HeadStr = substr( $filealldata , 0 , $StartPos );
			$FootStr = substr( $filealldata , strpos( $filealldata , "\n" , $StartPos ) + 1 );
			
//			$DebugStr .= 'break' . "\n";
//			$DebugStr .= $HeadStr . $crtdata . $FootStr;
			$filealldata = $HeadStr . $crtdata . $FootStr;
			
			break;
		}
		
		$StartPos = strpos( $filealldata , "\n" , $StartPos ) + 1;
		$LineNo += 1;
		
	}
	
	
	// デバッグ用ログファイル保存
//	file_put_contents( 'ScheduleWrite.Log' , $DebugStr );
	
}

// 全ファイル内容書き込み
file_put_contents( $filename_org , $filealldata );

?>

