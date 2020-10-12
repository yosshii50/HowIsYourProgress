<?php

// POSTデータ取得
$date      = filter_input( INPUT_POST , 'date'      );
$data      = filter_input( INPUT_POST , 'data'      );
$backcolor = filter_input( INPUT_POST , 'backcolor' );
$lineno    = filter_input( INPUT_POST , 'lineno'    );
$dellist   = filter_input( INPUT_POST , 'dellist'   );

// [git clone] したら [sudo chown www-data:www-data Schedule.txt] しないとけない、エラー処理が必要
$filename_org = 'Schedule.txt';
$filename_old = 'Schedule-old.txt';

// 古いバックアップファイルを削除
unlink( $filename_old );

// ファイル名変更
rename( $filename_org , $filename_old );

if( $dellist == '' ){ // 削除以外の場合
	
	// 対象行のデータ生成
	$crtdata .= $date      . "\t";
	$crtdata .= $data      . "\t";
	$crtdata .= $backcolor . "\t";
	$crtdata .= "\n";
	//          ↑           ↑  特殊文字なので[']ではNG
} else { // 削除の場合
	$crtdata = '';
	$DelArr = json_decode( $dellist , true );
}

// 全ファイル内容読み込み
$filealldata = file_get_contents( $filename_old );
$SaveAllData = '';

if( $lineno == 'null' and $dellist == '' ){
	// 追加の場合
	
	// 最後に追加
	$SaveAllData = $filealldata . $crtdata;
	
} else {
	// 修正/削除の場合
	
	$LineNo = 1;
	$StartPos = 0;
	
//	$DebugStr = $filealldata . "\nMax:" . strlen( $filealldata ) . "\n" ;
	
	while( $StartPos < strlen( $filealldata ) ) {
//		$DebugStr .= $StartPos . "\n";
		
		if( $dellist == '' ){ // 修正の場合
			if( $LineNo == $lineno ){
				// 処理中の行番号と指定された行番号が一致した場合
				$IsTarget = true;
			}
		} else { // 削除の場合
			foreach ( $DelArr as $DelVal ) {
				if( $LineNo == $DelVal ){
					$IsTarget = true;
					break;
				}
			}
		}
		
		$EndPos = strpos( $filealldata , "\n" , $StartPos ) - $StartPos + 1;
		$TargetStr = substr( $filealldata , $StartPos , $EndPos );
//$DebugStr .= 'G:' . $TargetStr . '<' . $StartPos . '～' . $EndPos . "\n" ;
		
		if( $IsTarget == true ){
			// 差替対象行の場合
			
			$SaveAllData .= $crtdata;
			
			if( $dellist == '' ){ // 修正の場合
				
				// 残りをつなげて終了
				$SaveAllData .= substr( $filealldata , strpos( $filealldata , "\n" , $StartPos ) + 1 ) ;
				break;
				
			}
			
			$IsTarget = false;
		} else {
			// 差替対象行でない場合
			$SaveAllData .= $TargetStr;
//$DebugStr .= 'A:' . $SaveAllData . "\n" ;
		}
		
		$StartPos = strpos( $filealldata , "\n" , $StartPos ) + 1;
		$LineNo += 1;
		
//$DebugStr .= 'G' . "\n" ;
	}
	
}


// デバッグ用ログファイル保存
//file_put_contents( 'ScheduleWrite.Log' , $DebugStr );

// 全ファイル内容書き込み
file_put_contents( $filename_org , $SaveAllData );

?>

